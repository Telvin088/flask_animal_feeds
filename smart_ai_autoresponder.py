import re
from datetime import date
from app import db, Product, ProductRequest, Message, mail, app

def process_message_with_ai(message_obj):
    """
    A local, rule-based message autoresponder. Classifies messages using regex
    matching, performs database lookups for stock levels or request statuses,
    and drafts/sends email responses. 100% free and offline.
    """
    subject = message_obj.subject.lower()
    body = message_obj.message.lower()
    full_text = f"{subject} {body}"

    # 1. Intent Classification via Keywords
    category = "General"
    
    # Check for Return/Cancellation keywords first
    if any(k in full_text for k in ["return", "cancel", "refund", "mistake", "wrong order"]):
        category = "Return"
    # Check for Order/Request Status keywords
    elif any(k in full_text for k in ["status", "track", "delivery", "pending", "approved", "rejected", "order status", "request status"]):
        category = "Order"
    # Check for Stock keywords
    elif any(k in full_text for k in ["stock", "available", "buy", "price", "cost", "have any", "have in stock", "feed available"]):
        category = "Stock"

    message_obj.category = category
    db.session.commit()

    # 2. Extract context & query the Database
    db_context = ""
    matched_products = []
    
    if category == "Stock":
        all_products = Product.query.all()
        for p in all_products:
            if p.name.lower() in full_text:
                matched_products.append(p)
        
        if matched_products:
            db_context = "Current stock details:\n" + "\n".join(
                [f"- {p.name}: {p.units} units available." for p in matched_products]
            )
        else:
            db_context = "We couldn't identify the specific product from the message. Please check the products page."

    elif category == "Order":
        last_req = ProductRequest.query.filter_by(email=message_obj.email).order_by(ProductRequest.request_date.desc()).first()
        if last_req:
            db_context = (
                f"Your last request details:\n"
                f"- Product: {last_req.product_name}\n"
                f"- Quantity: {last_req.quantity}\n"
                f"- Date: {last_req.request_date}\n"
                f"- Status: {last_req.status}\n"
                f"- Location: {last_req.location}"
            )
        else:
            db_context = "No previous product requests found for your email address."

    elif category == "Return":
        db_context = (
            "Return Policy: Subsidized feed requests can be cancelled while status is 'Pending'. "
            "Once 'Approved' and scheduled for delivery, orders cannot be cancelled or returned unless damaged."
        )

    # 3. Generate Draft Response using Templates
    if category == "Stock":
        if matched_products:
            draft_reply = (
                f"Hello {message_obj.name},\n\n"
                f"Thank you for contacting Feeds Kenya. Regarding your inquiry about product availability, "
                f"we have checked our inventory system. Here are the current stock details:\n\n"
                f"{db_context}\n\n"
                f"If they are available, you can submit a feed request by logging into your portal.\n\n"
                f"Best regards,\nFeeds Kenya Auto-Assistant"
            )
        else:
            draft_reply = (
                f"Hello {message_obj.name},\n\n"
                f"Thank you for contacting Feeds Kenya. You asked about product availability, but we "
                f"could not determine the specific feed from your message. Please visit our client portal "
                f"to check all available feeds in real-time.\n\n"
                f"Best regards,\nFeeds Kenya Auto-Assistant"
            )
            
    elif category == "Order":
        if last_req:
            draft_reply = (
                f"Hello {message_obj.name},\n\n"
                f"Thank you for reaching out. We looked up your request history and found the following record:\n\n"
                f"{db_context}\n\n"
                f"If the status is Pending, our admin team is reviewing it and will notify you via email shortly. "
                f"Let us know if you need to make any changes.\n\n"
                f"Best regards,\nFeeds Kenya Auto-Assistant"
            )
        else:
            draft_reply = (
                f"Hello {message_obj.name},\n\n"
                f"Thank you for reaching out. You inquired about your order status, but we could not find "
                f"any product requests linked to your email ({message_obj.email}). "
                f"Please ensure you are using the same email address registered on your client account.\n\n"
                f"Best regards,\nFeeds Kenya Auto-Assistant"
            )
            
    elif category == "Return":
        draft_reply = (
            f"Hello {message_obj.name},\n\n"
            f"We received your message regarding a return or cancellation. "
            f"According to our policies:\n\n"
            f"{db_context}\n\n"
            f"An administrator will review your message shortly to see how we can assist you with this.\n\n"
            f"Best regards,\nFeeds Kenya Auto-Assistant"
        )
        
    else:  # General
        draft_reply = (
            f"Hello {message_obj.name},\n\n"
            f"Thank you for contacting Feeds Kenya. We have received your message and saved it in our inbox.\n\n"
            f"An administrator will review your message and get back to you shortly.\n\n"
            f"Best regards,\nFeeds Kenya Auto-Assistant"
        )

    message_obj.ai_draft = draft_reply
    db.session.commit()

    # 4. Auto-Send Emails for Stock or Order status inquiries when matching data is found
    can_auto_send = (category == "Stock" and len(matched_products) > 0) or (category == "Order" and last_req is not None)
    
    if can_auto_send:
        try:
            subject = f"Re: {message_obj.subject} [Auto-Response]"
            msg = Message(subject, recipients=[message_obj.email], body=draft_reply)
            mail.send(msg)
            message_obj.ai_status = 'Auto-Sent'
        except Exception as e:
            app.logger.error(f"Autoresponder email failed: {e}")
            message_obj.ai_status = 'Draft Generated'
    else:
        message_obj.ai_status = 'Draft Generated'
        
    db.session.commit()
