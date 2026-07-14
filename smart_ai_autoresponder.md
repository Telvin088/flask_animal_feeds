# Feeds Kenya Smart AI Autoresponder

Feeds Kenya is integrated with a **Deterministic Smart Autoresponder & Template Engine** (the *Agri-Responder*) to process customer contact messages.

This module is **100% free, run locally with zero latency, and requires no external API keys** (like Gemini or OpenAI), making it perfect for lightweight setups and offline demonstration.

---

## 🛠️ System Architecture & Logic Flow

When a user submits a contact message on the `/contact` portal, the system triggers the following automated lifecycle:

```
[ Client Message Submitted ]
            │
            ▼
[ Classifier scans Subject & Body for keywords ]
            │
            ▼
[ Intent Category Identified: Stock / Order / Return / General ]
            │
            ▼
[ Database Context Grounding ]
  - Stock: Queries catalog for matching product stock levels.
  - Order: Queries recent client orders by email.
  - Return: Pulls the standard cancellation policy context.
            │
            ▼
[ Auto-Draft Generated via Templates ]
            │
            ▼
[ Delivery Decision ]
  ├── Category is 'Stock' (found match) or 'Order' (found record)
  │     └── Auto-send reply email & mark [Auto-Sent]
  └── Other categories
        └── Save draft inside the inbox & mark [Draft Ready] for Admin approval
```

---

## 🗄️ Database Schema Additions

The `ClientMessage` model in `app.py` has been updated with three new columns:
* **`category`** (`db.String(50)`, default `'General'`): Tracks the classified user intent.
* **`ai_status`** (`db.String(50)`, default `'Pending'`): Tracks response delivery (`Pending`, `Draft Generated`, `Auto-Sent`, `Replied`).
* **`ai_draft`** (`db.Text`): Stores either the automatically sent message or the pre-compiled draft for the admin.

---

## 🔍 The Local NLP Classifier Rules

The engine classifies incoming messages by checking the subject line and email body for specific keyword triggers:

1. **Return / Cancellation (`Return`)**
   * *Keywords:* `return`, `cancel`, `refund`, `mistake`, `wrong order`
2. **Order Status (`Order`)**
   * *Keywords:* `status`, `track`, `delivery`, `pending`, `approved`, `rejected`, `order status`, `request status`
3. **Product Stock Inquiry (`Stock`)**
   * *Keywords:* `stock`, `available`, `buy`, `price`, `cost`, `have any`, `have in stock`, `feed available`
4. **General Inquiries (`General`)**
   * Fallback category if no other keywords match.

---

## 🛢️ SQL Context Grounding & Replier Templates

Instead of using random strings, the engine looks up live database records to construct exact factual replies.

### 1. Stock Inquiries
* **Database Lookup:** Searches the `products` table for any product whose name matches text in the user's message.
* **Response Template:**
  > Hello {name},
  >
  > Regarding your inquiry about product availability, we have checked our inventory. Here are the current stock details:
  > - {matched_product_name}: {units_available} units available.
  >
  > If they are available, you can submit a feed request by logging into your portal.

### 2. Order Status Inquiries
* **Database Lookup:** Searches the `product_requests` table matching the sender's `email` (sorting by date desc to get their latest order).
* **Response Template:**
  > Hello {name},
  >
  > We looked up your request history and found the following record:
  > - Product: {product_name}
  > - Quantity: {quantity}
  > - Status: {status}
  > - Date: {request_date}
  >
  > If the status is Pending, our admin team is reviewing it and will notify you via email shortly.

### 3. Returns & Cancellations
* **Context:** References the subsidized cancellation policy guidelines.
* **Response Template:**
  > Hello {name},
  >
  > We received your message regarding a return or cancellation. According to our policies:
  > Subsidized feed requests can be cancelled while status is 'Pending'. Once 'Approved' and scheduled for delivery, orders cannot be cancelled or returned unless damaged.
  >
  > An administrator will review your message shortly to see how we can assist you with this.

---

## 🖥️ Administrative Mail Interface

Admins can review all messages and drafts from the Inbox page (`/admin/mail`):

* **Visual Status Badges:** 
  * Category tags are colored to draw immediate attention (`Stock` is yellow, `Order` is teal, `Return` is red, `General` is grey).
  * Auto-sent replies are marked with a solid green badge `✓ Auto-Sent`.
  * Open drafts display an amber badge `⚡ Draft Ready`.
* **Action Drawer:** 
  * Open drafts display a text area pre-populated with the template response. Admins can review, modify the text, and hit **"Send Reply Email"** to deliver the mail instantly.
  * Sent messages (auto-sent or replied) show a collapsed summary of the sent email body for full auditability.
