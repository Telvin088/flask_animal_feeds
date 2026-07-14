import os
import uuid
from datetime import datetime, date, timedelta
from functools import wraps

from flask import (Flask, render_template, request, redirect, url_for,
                   session, flash, jsonify, abort)
from flask_sqlalchemy import SQLAlchemy
from flask_mail import Mail, Message
from werkzeug.security import generate_password_hash, check_password_hash
from werkzeug.utils import secure_filename

# ─────────────────────────────────────────────────────────────
# Configuration
# ─────────────────────────────────────────────────────────────

app = Flask(__name__)
app.secret_key = os.environ.get('SECRET_KEY', 'feeds-kenya-dev-secret-2024')

basedir = os.path.abspath(os.path.dirname(__file__))

app.config['SQLALCHEMY_DATABASE_URI'] = os.environ.get(
    'DATABASE_URL', f'sqlite:///{os.path.join(basedir, "feeds_kenya.db")}')
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

UPLOAD_FOLDER = os.path.join(basedir, 'static', 'uploads')
ALLOWED_EXTENSIONS = {'png', 'jpg', 'jpeg', 'gif', 'webp'}
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER
app.config['MAX_CONTENT_LENGTH'] = 16 * 1024 * 1024

app.config['MAIL_SERVER'] = 'smtp.gmail.com'
app.config['MAIL_PORT'] = 587
app.config['MAIL_USE_TLS'] = True
app.config['MAIL_USERNAME'] = os.environ.get('MAIL_USERNAME', '')
app.config['MAIL_PASSWORD'] = os.environ.get('MAIL_PASSWORD', '')
app.config['MAIL_DEFAULT_SENDER'] = os.environ.get('MAIL_USERNAME', 'noreply@feedskenya.com')

db   = SQLAlchemy(app)
mail = Mail(app)

# ─────────────────────────────────────────────────────────────
# Models
# ─────────────────────────────────────────────────────────────

class User(db.Model):
    __tablename__ = 'users'
    id              = db.Column(db.Integer, primary_key=True)
    username        = db.Column(db.String(80),  unique=True, nullable=False)
    email           = db.Column(db.String(120), unique=True, nullable=False)
    phone_number    = db.Column(db.String(20))
    password_hash   = db.Column(db.String(256), nullable=False)
    profile_picture = db.Column(db.String(256), default='')
    role            = db.Column(db.String(10),  nullable=False, default='client')
    created_at      = db.Column(db.DateTime, default=datetime.utcnow)
    requests        = db.relationship('ProductRequest', backref='client',
                                      lazy=True, foreign_keys='ProductRequest.client_id')

    def set_password(self, pw):
        self.password_hash = generate_password_hash(pw)

    def check_password(self, pw):
        return check_password_hash(self.password_hash, pw)

    @property
    def avatar_url(self):
        if self.profile_picture:
            return url_for('static', filename=self.profile_picture)
        initials = self.username[:2].upper()
        return f'https://ui-avatars.com/api/?name={initials}&background=1B4332&color=fff&bold=true'


class Product(db.Model):
    __tablename__ = 'products'
    id          = db.Column(db.Integer, primary_key=True)
    name        = db.Column(db.String(200), nullable=False)
    units       = db.Column(db.Integer,  default=0)
    description = db.Column(db.Text)
    image       = db.Column(db.String(256))
    is_featured = db.Column(db.Boolean,  default=False)
    created_at  = db.Column(db.DateTime, default=datetime.utcnow)

    @property
    def image_url(self):
        if self.image:
            return url_for('static', filename=self.image)
        return 'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=400&q=80'

    @property
    def in_stock(self):
        return self.units > 0


class Event(db.Model):
    __tablename__ = 'events'
    id         = db.Column(db.Integer, primary_key=True)
    date       = db.Column(db.Date,    nullable=False)
    topic      = db.Column(db.String(200), nullable=False)
    text       = db.Column(db.Text,    nullable=False)
    image_path = db.Column(db.String(256))
    created_at = db.Column(db.DateTime, default=datetime.utcnow)

    @property
    def image_url(self):
        if self.image_path:
            return url_for('static', filename=self.image_path)
        return 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=600&q=80'

    @property
    def is_upcoming(self):
        return self.date >= date.today()


class TopOrdered(db.Model):
    __tablename__ = 'top_ordered'
    id          = db.Column(db.Integer, primary_key=True)
    image       = db.Column(db.String(256))
    name        = db.Column(db.String(200), nullable=False)
    description = db.Column(db.Text)

    @property
    def image_url(self):
        if self.image:
            return url_for('static', filename=self.image)
        return 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=400&q=80'


class ProductRequest(db.Model):
    __tablename__ = 'product_requests'
    id           = db.Column(db.Integer, primary_key=True)
    name         = db.Column(db.String(200), nullable=False)
    phone        = db.Column(db.String(20),  nullable=False)
    email        = db.Column(db.String(120), nullable=False)
    quantity     = db.Column(db.Integer, nullable=False)
    location     = db.Column(db.String(200), nullable=False)
    product_name = db.Column(db.String(200), nullable=False)
    status       = db.Column(db.String(20),  default='Pending')
    request_type = db.Column(db.String(10),  default='available')
    request_date = db.Column(db.Date, default=date.today)
    client_id    = db.Column(db.Integer, db.ForeignKey('users.id'), nullable=True)

    @property
    def status_class(self):
        return {'Pending': 'badge-warning', 'Approved': 'badge-success',
                'Rejected': 'badge-danger'}.get(self.status, 'badge-muted')


class ClientMessage(db.Model):
    __tablename__ = 'client_messages'
    id         = db.Column(db.Integer, primary_key=True)
    name       = db.Column(db.String(200), nullable=False)
    email      = db.Column(db.String(120), nullable=False)
    subject    = db.Column(db.String(300), nullable=False)
    message    = db.Column(db.Text, nullable=False)
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
    is_read    = db.Column(db.Boolean, default=False)
    
    # AI Autoresponder fields
    category   = db.Column(db.String(50), default='General')
    ai_status  = db.Column(db.String(50), default='Pending')
    ai_draft   = db.Column(db.Text)

# ─────────────────────────────────────────────────────────────
# Helpers
# ─────────────────────────────────────────────────────────────

def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS


def save_upload(file, subfolder='general'):
    if file and allowed_file(file.filename):
        ext         = file.filename.rsplit('.', 1)[1].lower()
        unique_name = f"{uuid.uuid4().hex}.{ext}"
        folder      = os.path.join(app.config['UPLOAD_FOLDER'], subfolder)
        os.makedirs(folder, exist_ok=True)
        file.save(os.path.join(folder, unique_name))
        return f"uploads/{subfolder}/{unique_name}"
    return None


def login_required(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        if 'user_id' not in session or session.get('role') != 'client':
            flash('Please log in to continue.', 'warning')
            return redirect(url_for('auth_login'))
        return f(*args, **kwargs)
    return decorated


def admin_required(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        if 'user_id' not in session or session.get('role') != 'admin':
            flash('Admin access required.', 'danger')
            return redirect(url_for('admin_login'))
        return f(*args, **kwargs)
    return decorated


def send_status_email(req_obj, status):
    try:
        if not app.config.get('MAIL_USERNAME'):
            return False
        subject = f"Feeds Kenya — Your Request has been {status}"
        if status == 'Approved':
            detail = "We will arrange delivery to your location shortly. Our team will be in touch."
        else:
            detail = "Unfortunately we cannot fulfill this request right now. Please try again later or contact us directly."
        body = (
            f"Dear {req_obj.name},\n\n"
            f"Your product request has been {status.lower()}.\n\n"
            f"Request Details\n"
            f"  Product : {req_obj.product_name}\n"
            f"  Quantity: {req_obj.quantity}\n"
            f"  Location: {req_obj.location}\n"
            f"  Status  : {status}\n\n"
            f"{detail}\n\n"
            f"Thank you for using Feeds Kenya.\n\n"
            f"Best regards,\nFeeds Kenya Team\n"
            f"feedskenya@gmail.com | +254 717 927 780"
        )
        msg = Message(subject, recipients=[req_obj.email], body=body)
        mail.send(msg)
        return True
    except Exception as e:
        app.logger.error(f"Mail error: {e}")
        return False

# ─────────────────────────────────────────────────────────────
# Context Processors
# ─────────────────────────────────────────────────────────────

@app.context_processor
def inject_globals():
    unread = 0
    if session.get('role') == 'admin':
        unread = ClientMessage.query.filter_by(is_read=False).count()
    return dict(now=datetime.utcnow(), unread_messages=unread)

# ─────────────────────────────────────────────────────────────
# AUTH ROUTES
# ─────────────────────────────────────────────────────────────

@app.route('/login', methods=['GET', 'POST'])
def auth_login():
    if 'user_id' in session:
        return redirect(url_for('admin_dashboard') if session.get('role') == 'admin' else url_for('client_home'))
    if request.method == 'POST':
        ident    = request.form.get('username', '').strip()
        password = request.form.get('password', '')
        user     = User.query.filter(
            ((User.username == ident) | (User.email == ident)) & (User.role == 'client')
        ).first()
        if user and user.check_password(password):
            session.update({'user_id': user.id, 'username': user.username,
                            'role': 'client', 'profile_picture': user.profile_picture})
            flash(f'Welcome back, {user.username}!', 'success')
            return redirect(url_for('client_home'))
        flash('Invalid username or password.', 'danger')
    return render_template('auth/login.html')


@app.route('/signup', methods=['GET', 'POST'])
def auth_signup():
    if request.method == 'POST':
        username = request.form.get('username', '').strip()
        email    = request.form.get('email', '').strip()
        phone    = request.form.get('phone_number', '').strip()
        password = request.form.get('password', '')
        confirm  = request.form.get('confirm_password', '')
        if password != confirm:
            flash('Passwords do not match.', 'danger')
            return render_template('auth/signup.html')
        if User.query.filter((User.username == username) | (User.email == email)).first():
            flash('Username or email already exists.', 'danger')
            return render_template('auth/signup.html')
        pic = save_upload(request.files.get('profile_picture'), 'profiles')
        user = User(username=username, email=email, phone_number=phone,
                    profile_picture=pic or '', role='client')
        user.set_password(password)
        db.session.add(user)
        db.session.commit()
        flash('Account created! Please log in.', 'success')
        return redirect(url_for('auth_login'))
    return render_template('auth/signup.html')


@app.route('/logout')
def auth_logout():
    session.clear()
    flash('You have been logged out.', 'info')
    return redirect(url_for('auth_login'))


@app.route('/admin/login', methods=['GET', 'POST'])
def admin_login():
    if session.get('role') == 'admin':
        return redirect(url_for('admin_dashboard'))
    if request.method == 'POST':
        ident    = request.form.get('username', '').strip()
        password = request.form.get('password', '')
        user     = User.query.filter(
            ((User.username == ident) | (User.email == ident)) & (User.role == 'admin')
        ).first()
        if user and user.check_password(password):
            session.update({'user_id': user.id, 'username': user.username,
                            'role': 'admin', 'profile_picture': user.profile_picture})
            return redirect(url_for('admin_dashboard'))
        flash('Invalid admin credentials.', 'danger')
    return render_template('auth/admin_login.html')


@app.route('/admin/signup', methods=['GET', 'POST'])
def admin_signup():
    if request.method == 'POST':
        username = request.form.get('username', '').strip()
        email    = request.form.get('email', '').strip()
        phone    = request.form.get('phone_number', '').strip()
        password = request.form.get('password', '')
        confirm  = request.form.get('confirm_password', '')
        if password != confirm:
            flash('Passwords do not match.', 'danger')
            return render_template('auth/admin_signup.html')
        if User.query.filter((User.username == username) | (User.email == email)).first():
            flash('Username or email already exists.', 'danger')
            return render_template('auth/admin_signup.html')
        pic = save_upload(request.files.get('profile_picture'), 'profiles')
        user = User(username=username, email=email, phone_number=phone,
                    profile_picture=pic or '', role='admin')
        user.set_password(password)
        db.session.add(user)
        db.session.commit()
        flash('Admin account created!', 'success')
        return redirect(url_for('admin_login'))
    return render_template('auth/admin_signup.html')


@app.route('/admin/logout')
def admin_logout():
    session.clear()
    return redirect(url_for('admin_login'))

# ─────────────────────────────────────────────────────────────
# CLIENT ROUTES
# ─────────────────────────────────────────────────────────────

@app.route('/')
def client_home():
    featured  = Product.query.filter_by(is_featured=True).limit(6).all()
    top_prods = TopOrdered.query.limit(4).all()
    events    = Event.query.filter(Event.date >= date.today()).order_by(Event.date).limit(3).all()
    stats = {
        'total_requests': ProductRequest.query.count(),
        'total_clients':  User.query.filter_by(role='client').count(),
        'hosted_events':  Event.query.count(),
    }
    return render_template('client/home.html', featured=featured,
                           top_prods=top_prods, events=events, stats=stats)


@app.route('/products')
def client_products():
    search = request.args.get('q', '').strip()
    page   = request.args.get('page', 1, type=int)
    query  = Product.query
    if search:
        query = query.filter(Product.name.ilike(f'%{search}%'))
    products = query.order_by(Product.name).paginate(page=page, per_page=12, error_out=False)
    return render_template('client/products.html', products=products, search=search)


@app.route('/products/<int:product_id>')
def client_product_detail(product_id):
    product = Product.query.get_or_404(product_id)
    related = Product.query.filter(Product.id != product_id).limit(4).all()
    return render_template('client/product_detail.html', product=product, related=related)


@app.route('/products/<int:product_id>/request', methods=['POST'])
@login_required
def client_request_product(product_id):
    product  = Product.query.get_or_404(product_id)
    quantity = request.form.get('quantity', 1, type=int)
    location = request.form.get('location', '').strip()
    user     = User.query.get(session['user_id'])

    if quantity < 1:
        flash('Quantity must be at least 1.', 'danger')
        return redirect(url_for('client_product_detail', product_id=product_id))

    if product.units >= quantity:
        product.units -= quantity
        req_type = 'available'
        flash(f'Request submitted for {product.name}. We will contact you shortly.', 'success')
    else:
        req_type = 'missing'
        flash(f'Insufficient stock. Your request has been added to the waiting list.', 'warning')

    req = ProductRequest(
        name=user.username, phone=user.phone_number or '', email=user.email,
        quantity=quantity, location=location, product_name=product.name,
        status='Pending', request_type=req_type, client_id=user.id
    )
    db.session.add(req)
    db.session.commit()
    return redirect(url_for('client_orders'))


@app.route('/request-missing', methods=['POST'])
@login_required
def client_request_missing():
    user = User.query.get(session['user_id'])
    req  = ProductRequest(
        name=user.username, phone=user.phone_number or '', email=user.email,
        quantity=request.form.get('quantity', 1, type=int),
        location=request.form.get('location', '').strip(),
        product_name=request.form.get('product', '').strip(),
        status='Pending', request_type='missing', client_id=user.id
    )
    db.session.add(req)
    db.session.commit()
    flash('Request recorded. We will notify you when the product is available.', 'success')
    return redirect(url_for('client_orders'))


@app.route('/orders')
@login_required
def client_orders():
    user   = User.query.get(session['user_id'])
    orders = (ProductRequest.query
              .filter_by(client_id=user.id)
              .order_by(ProductRequest.request_date.desc())
              .all())
    return render_template('client/orders.html', orders=orders)


@app.route('/events')
def client_events():
    page   = request.args.get('page', 1, type=int)
    events = Event.query.order_by(Event.date.desc()).paginate(page=page, per_page=9, error_out=False)
    return render_template('client/events.html', events=events)


@app.route('/events/<int:event_id>')
def client_event_detail(event_id):
    event   = Event.query.get_or_404(event_id)
    related = Event.query.filter(Event.id != event_id).order_by(Event.date.desc()).limit(3).all()
    return render_template('client/event_detail.html', event=event, related=related)


@app.route('/contact', methods=['GET', 'POST'])
def client_contact():
    if request.method == 'POST':
        msg = ClientMessage(
            name    = request.form.get('name',    '').strip(),
            email   = request.form.get('email',   '').strip(),
            subject = request.form.get('subject', '').strip(),
            message = request.form.get('message', '').strip()
        )
        db.session.add(msg)
        db.session.commit()
        
        # Trigger Smart AI Autoresponder
        try:
            from smart_ai_autoresponder import process_message_with_ai
            process_message_with_ai(msg)
        except Exception as e:
            app.logger.error(f"AI autoresponder failed: {e}")

        flash('Message sent! We will get back to you within 24 hours.', 'success')
        return redirect(url_for('client_contact'))
    return render_template('client/contact.html')

# ─────────────────────────────────────────────────────────────
# ADMIN ROUTES
# ─────────────────────────────────────────────────────────────

@app.route('/admin')
@app.route('/admin/dashboard')
@admin_required
def admin_dashboard():
    stats = {
        'total_requests':  ProductRequest.query.filter_by(request_type='available').count(),
        'total_clients':   User.query.filter_by(role='client').count(),
        'hosted_events':   Event.query.count(),
        'pending':         ProductRequest.query.filter_by(status='Pending').count(),
        'approved':        ProductRequest.query.filter_by(status='Approved').count(),
        'unread_messages': ClientMessage.query.filter_by(is_read=False).count(),
        'total_products':  Product.query.count(),
    }
    recent_requests = (ProductRequest.query
                       .order_by(ProductRequest.request_date.desc()).limit(6).all())
    upcoming_events = (Event.query
                       .filter(Event.date >= date.today())
                       .order_by(Event.date).limit(5).all())
    recent_users    = (User.query.filter_by(role='client')
                       .order_by(User.created_at.desc()).limit(5).all())
    top_prods       = TopOrdered.query.limit(3).all()
    featured        = Product.query.filter_by(is_featured=True).limit(6).all()
    return render_template('admin/dashboard.html', stats=stats,
                           recent_requests=recent_requests, upcoming_events=upcoming_events,
                           recent_users=recent_users, top_prods=top_prods, featured=featured)


@app.route('/admin/requests')
@admin_required
def admin_requests():
    status_f = request.args.get('status', 'all')
    type_f   = request.args.get('type',   'available')
    query    = ProductRequest.query.filter_by(request_type=type_f)
    if status_f != 'all':
        query = query.filter_by(status=status_f)
    reqs = query.order_by(ProductRequest.request_date.desc()).all()
    counts = {
        'available': ProductRequest.query.filter_by(request_type='available').count(),
        'missing':   ProductRequest.query.filter_by(request_type='missing').count(),
        'pending':   ProductRequest.query.filter_by(status='Pending').count(),
        'approved':  ProductRequest.query.filter_by(status='Approved').count(),
        'rejected':  ProductRequest.query.filter_by(status='Rejected').count(),
    }
    return render_template('admin/requests.html', requests=reqs,
                           status_f=status_f, type_f=type_f, counts=counts)


@app.route('/admin/requests/<int:req_id>/approve', methods=['POST'])
@admin_required
def admin_approve_request(req_id):
    req = ProductRequest.query.get_or_404(req_id)
    req.status = 'Approved'
    db.session.commit()
    sent = send_status_email(req, 'Approved')
    flash(f'Request approved.{" Email sent to client." if sent else ""}', 'success')
    return redirect(url_for('admin_requests', type=req.request_type))


@app.route('/admin/requests/<int:req_id>/reject', methods=['POST'])
@admin_required
def admin_reject_request(req_id):
    req = ProductRequest.query.get_or_404(req_id)
    req.status = 'Rejected'
    db.session.commit()
    sent = send_status_email(req, 'Rejected')
    flash(f'Request rejected.{" Email sent to client." if sent else ""}', 'info')
    return redirect(url_for('admin_requests', type=req.request_type))


@app.route('/admin/products')
@admin_required
def admin_products():
    products    = Product.query.order_by(Product.name).all()
    top_ordered = TopOrdered.query.all()
    return render_template('admin/products.html', products=products, top_ordered=top_ordered)


@app.route('/admin/products/add', methods=['POST'])
@admin_required
def admin_add_product():
    name        = request.form.get('name', '').strip()
    units       = request.form.get('units', 0, type=int)
    description = request.form.get('description', '').strip()
    is_featured = 'is_featured' in request.form
    image_path  = save_upload(request.files.get('image'), 'products')
    db.session.add(Product(name=name, units=units, description=description,
                           image=image_path, is_featured=is_featured))
    db.session.commit()
    flash(f'Product "{name}" added.', 'success')
    return redirect(url_for('admin_products'))


@app.route('/admin/products/<int:pid>/delete', methods=['POST'])
@admin_required
def admin_delete_product(pid):
    product = Product.query.get_or_404(pid)
    db.session.delete(product)
    db.session.commit()
    flash('Product deleted.', 'info')
    return redirect(url_for('admin_products'))


@app.route('/admin/products/<int:pid>/edit', methods=['POST'])
@admin_required
def admin_edit_product(pid):
    product = Product.query.get_or_404(pid)
    product.name        = request.form.get('name', product.name).strip()
    product.units       = request.form.get('units', product.units, type=int)
    product.description = request.form.get('description', product.description).strip()
    product.is_featured = 'is_featured' in request.form
    new_image = save_upload(request.files.get('image'), 'products')
    if new_image:
        product.image = new_image
    db.session.commit()
    flash(f'Product "{product.name}" updated.', 'success')
    return redirect(url_for('admin_products'))


@app.route('/admin/top-ordered/add', methods=['POST'])
@admin_required
def admin_add_top_ordered():
    name        = request.form.get('name', '').strip()
    description = request.form.get('description', '').strip()
    image_path  = save_upload(request.files.get('image'), 'products')
    db.session.add(TopOrdered(name=name, description=description, image=image_path))
    db.session.commit()
    flash('Top ordered item added.', 'success')
    return redirect(url_for('admin_products'))


@app.route('/admin/top-ordered/<int:tid>/delete', methods=['POST'])
@admin_required
def admin_delete_top_ordered(tid):
    db.session.delete(TopOrdered.query.get_or_404(tid))
    db.session.commit()
    flash('Item removed.', 'info')
    return redirect(url_for('admin_products'))


@app.route('/admin/events')
@admin_required
def admin_events():
    events = Event.query.order_by(Event.date.desc()).all()
    return render_template('admin/events.html', events=events)


@app.route('/admin/events/add', methods=['POST'])
@admin_required
def admin_add_event():
    try:
        event_date = datetime.strptime(request.form.get('date', ''), '%Y-%m-%d').date()
    except ValueError:
        flash('Invalid date format.', 'danger')
        return redirect(url_for('admin_events'))
    topic      = request.form.get('topic', '').strip()
    text       = request.form.get('text',  '').strip()
    image_path = save_upload(request.files.get('image'), 'events')
    db.session.add(Event(topic=topic, text=text, date=event_date, image_path=image_path))
    db.session.commit()
    flash(f'Event "{topic}" added.', 'success')
    return redirect(url_for('admin_events'))


@app.route('/admin/events/<int:eid>/delete', methods=['POST'])
@admin_required
def admin_delete_event(eid):
    db.session.delete(Event.query.get_or_404(eid))
    db.session.commit()
    flash('Event deleted.', 'info')
    return redirect(url_for('admin_events'))


@app.route('/admin/mail')
@admin_required
def admin_mail():
    messages    = ClientMessage.query.order_by(ClientMessage.created_at.desc()).all()
    admin_user  = User.query.get(session['user_id'])
    recent_users = (User.query.filter_by(role='client')
                   .order_by(User.created_at.desc()).limit(8).all())
    ClientMessage.query.filter_by(is_read=False).update({'is_read': True})
    db.session.commit()
    return render_template('admin/mail.html', messages=messages,
                           admin_user=admin_user, recent_users=recent_users)


@app.route('/admin/mail/<int:msg_id>/reply', methods=['POST'])
@admin_required
def admin_reply_message(msg_id):
    msg_obj = ClientMessage.query.get_or_404(msg_id)
    reply_body = request.form.get('reply_body', '').strip()
    if not reply_body:
        flash('Reply content cannot be empty.', 'danger')
        return redirect(url_for('admin_mail'))
    
    try:
        subject = f"Re: {msg_obj.subject}"
        email_msg = Message(subject, recipients=[msg_obj.email], body=reply_body)
        mail.send(email_msg)
        msg_obj.ai_status = 'Replied'
        msg_obj.ai_draft = reply_body
        db.session.commit()
        flash('Reply sent successfully.', 'success')
    except Exception as e:
        app.logger.error(f"Failed to send email: {e}")
        flash(f'Failed to send email: {e}', 'danger')
    return redirect(url_for('admin_mail'))


@app.route('/admin/report')
@admin_required
def admin_report():
    date_filter   = request.args.get('date_filter', 'all')
    status_filter = request.args.get('status', 'all')
    type_filter   = request.args.get('type',   'available')
    today         = date.today()

    query = ProductRequest.query.filter_by(request_type=type_filter)
    if status_filter != 'all':
        query = query.filter_by(status=status_filter)
    if date_filter == 'today':
        query = query.filter(ProductRequest.request_date == today)
    elif date_filter == 'yesterday':
        query = query.filter(ProductRequest.request_date == today - timedelta(days=1))
    elif date_filter == 'week':
        query = query.filter(ProductRequest.request_date >= today - timedelta(days=7))
    elif date_filter == 'month':
        query = query.filter(ProductRequest.request_date >= today - timedelta(days=30))

    reqs = query.order_by(ProductRequest.request_date.desc()).all()
    return render_template('admin/report.html', requests=reqs,
                           date_filter=date_filter, status_filter=status_filter,
                           type_filter=type_filter)


@app.route('/admin/users')
@admin_required
def admin_users():
    users = User.query.filter_by(role='client').order_by(User.created_at.desc()).all()
    return render_template('admin/users.html', users=users)

# ─────────────────────────────────────────────────────────────
# API ENDPOINTS
# ─────────────────────────────────────────────────────────────

@app.route('/api/products')
def api_products():
    products = Product.query.all()
    return jsonify([{
        'id': p.id, 'name': p.name, 'units': p.units,
        'description': p.description, 'in_stock': p.in_stock
    } for p in products])


@app.route('/api/admin/stats')
@admin_required
def api_admin_stats():
    return jsonify({
        'total_requests': ProductRequest.query.count(),
        'total_clients':  User.query.filter_by(role='client').count(),
        'hosted_events':  Event.query.count(),
        'pending':        ProductRequest.query.filter_by(status='Pending').count(),
    })

# ─────────────────────────────────────────────────────────────
# DATABASE INIT
# ─────────────────────────────────────────────────────────────

def init_db():
    db.create_all()
    for folder in ['products', 'events', 'profiles', 'general']:
        os.makedirs(os.path.join(app.config['UPLOAD_FOLDER'], folder), exist_ok=True)
    if not User.query.filter_by(role='admin').first():
        admin = User(username='admin', email='admin@feedskenya.com',
                     phone_number='+254 717 927 780', role='admin')
        admin.set_password('admin123')
        db.session.add(admin)
        db.session.commit()
        print("✓ Default admin: admin / admin123")


if __name__ == '__main__':
    with app.app_context():
        init_db()
    app.run(host='0.0.0.0', port=5000, debug=True)
