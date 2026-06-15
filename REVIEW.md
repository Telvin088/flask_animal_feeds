# Project Review: Feeds Kenya / AgriKenya

## Overview

**Feeds Kenya** (also referred to internally as **AgriKenya**) is a web-based agricultural animal feeds management and distribution platform targeting East Africa, primarily Kenya. The system connects an administrative team with farmers/clients who need access to animal feeds. Its core purpose is to manage the lifecycle of feed product requests — from a client submitting a request, to an admin approving or rejecting it and sending a confirmation email.

The application is split into two separate portals:

- `/administrator/` — The admin-facing dashboard and management panel
- `/clients/` — The client-facing landing page and request system

---

## Purpose & Goals

1. **Support farmers with free/subsidised animal feed distribution** — Clients can browse available products and submit requests. The system checks if stock is available before confirming a request.
2. **Admin oversight of all requests, clients, and content** — Admins have a full dashboard to view stats, manage requests (approve/reject), send email notifications, add/remove products and events, and view client messages.
3. **Communication channel** — Clients can send messages to the admin. Admins can send approval/rejection emails directly from the dashboard via SMTP (Gmail + PHPMailer).
4. **Content management** — Admins can post new products, events/blog posts, and curate the "top ordered products" list that appears publicly on the client landing page.

---

## Tech Stack (Current PHP Implementation)

| Layer | Technology |
|---|---|
| Language | PHP (mixed procedural + OOP) |
| Database | MySQL (two databases: `agrikenya_admin`, `agrikenya_clients`) |
| DB Library | MySQLi (raw) and PDO (mixed usage) |
| Email | PHPMailer (SMTP via Gmail) |
| Frontend | Vanilla HTML/CSS/JS + jQuery |
| Charts | Chart.js |
| Icons | Google Material Symbols, Font Awesome, Line Awesome |
| Fonts | Google Fonts (Oswald, Lato, Nunito Sans) |
| Hosting | Localhost / XAMPP-style setup (hardcoded `root`/no-password credentials) |

---

## Project Structure

```
/
├── administrator/          # Admin portal
│   ├── dashboard.php       # Main admin dashboard
│   ├── requests.php        # Manage client requests (approve/reject)
│   ├── mail.php            # View client messages + user accounts
│   ├── new.php             # Add/delete products, events, top-ordered items
│   ├── report.php          # Filterable report of all requests + print
│   ├── login.php           # Admin login form
│   ├── login_process.php   # Auth handler (PDO, password_verify)
│   ├── logout.php          # Session destroy
│   ├── signup_process.php  # Admin account creation
│   ├── db_connection.php   # PDO connection to agrikenya_admin
│   ├── send_email.php      # PHPMailer SMTP email sender
│   ├── save_product.php    # Upload + insert new product
│   ├── save_events.php     # Upload + insert new event
│   ├── save_topordered.php # Upload + insert top-ordered product
│   ├── save_status.php     # AJAX: update request status (Approved/Rejected)
│   ├── save_missing.php    # Handle missing-stock request status
│   ├── fetch_requests.php      # Mini table of last 5 requests (dashboard widget)
│   ├── fetch_requests2.php     # Full requests table with Approve/Reject buttons
│   ├── fetch_missing.php       # Missing-stock requests (widget)
│   ├── missing_email.php       # Full missing requests table with email
│   ├── missing_status.php      # Report view of missing requests
│   ├── fetch_messages.php      # Mini message list (dashboard widget)
│   ├── fetch_messages2.php     # Full scrollable message list (mail page)
│   ├── fetch_clients.php       # Recent client list (mail page sidebar)
│   ├── fetch_clients2.php      # Full user accounts table (dashboard)
│   ├── fetch_admin.php         # Admin profile info (mail page)
│   ├── fetch_adminProfile.php  # Admin profile picture row (dashboard)
│   ├── fetch_events.php        # Events list (dashboard widget)
│   ├── fetch_featured.php      # Featured products list (dashboard widget)
│   ├── fetch_topordered.php    # Top-ordered products list (dashboard widget)
│   ├── fetch_update.php        # Requests table with status column (report)
│   ├── fetchDashtop.php        # Top product mini-card (dashboard)
│   ├── fetch_report.php        # Report data fetcher
│   ├── fetch_users.php         # User accounts data
│   ├── display_events.php      # Event display helper
│   ├── display_product.php     # Product display helper
│   ├── email.php               # Email-related helper
│   ├── dashboard.css           # Shared admin layout styles
│   ├── new.css                 # Styles for the New page
│   ├── requests.css            # Styles for the Requests page
│   ├── mail.css                # Styles for the Mail page
│   ├── dashboard.js            # Dashboard JS interactions
│   ├── expenses_graph.js       # Chart.js graph logic
│   ├── sql.sql                 # Full DB schema (both databases)
│   ├── phpmailer/              # PHPMailer library (bundled manually)
│   ├── products/               # Uploaded product images (80+ files)
│   └── profile_pictures/       # Admin profile pictures
│   └── uploads/                # General uploaded assets
│
├── clients/                # Client portal
│   ├── landing_page.php    # Main client page (about, services, portfolio, products)
│   ├── dash.php            # Client dashboard (appears unused/placeholder)
│   ├── login.php           # Client login form
│   ├── login_process.php   # Auth handler
│   ├── logout.php          # Session destroy
│   ├── signup_process.php  # Client account creation
│   ├── db_connection.php   # PDO connection to agrikenya_clients
│   ├── save_requests.php   # Submit a product request (checks & deducts stock)
│   ├── save_missing.php    # Submit a request for out-of-stock product
│   ├── save_messages.php   # Submit a contact/message to admin
│   ├── fetch_amount.php    # Fetch product stock quantity
│   ├── fetch_events.php    # Fetch events for blog/landing page
│   ├── fetch_featured.php  # Fetch featured products for landing page
│   ├── fetch_requests.php  # Fetch client's own requests
│   ├── fetch_topordered.php # Fetch top-ordered products for landing page
│   ├── landing_page.css    # Client landing page styles
│   ├── landing_page.js     # Client landing page JS
│   ├── success_page.php    # Success confirmation page
│   └── profile_pictures/   # Client profile pictures
```

---

## Database Schema

### Database: `agrikenya_admin`

| Table | Purpose | Key Columns |
|---|---|---|
| `users` | Admin accounts | `id`, `username`, `email`, `profile_picture`, `phone_number`, `password` |
| `new_products` | Product catalogue | `id`, `name`, `units` (stock qty), `description`, `image` |
| `new_events` | Events / blog posts | `event_id`, `date`, `topic`, `text`, `image_path` |
| `top_ordered` | Featured top-ordered products | `id`, `image`, `name`, `description` |
| `approved_report` | Approved request records | `name`, `email`, `phone`, `location`, `product`, `message` |

### Database: `agrikenya_clients`

| Table | Purpose | Key Columns |
|---|---|---|
| `users` | Client accounts | `id`, `username`, `email`, `profile_picture`, `phone_number`, `quantities`, `password` |
| `recent_requests` | Available-product requests | `request_id`, `name`, `phone`, `email`, `quantity`, `location`, `products`, `status`, `request_date` |
| `missing_requests` | Out-of-stock product requests | `request_id`, `name`, `phone`, `email`, `quantity`, `location`, `products`, `status`, `request_date` |
| `client_messages` | Contact messages from clients | `request_id`, `name`, `email`, `subject`, `message` |

---

## User Flows

### Client Flow
1. Client registers/logs in via `/clients/login.php`
2. Lands on `/clients/landing_page.php` — sees the About, Services, Portfolio, Testimonials, Featured Products, Blog/Events, and Contact sections
3. Can browse available products (fetched live from `agrikenya_admin.new_products`)
4. Submits a product request — system checks stock, deducts quantity, inserts into `recent_requests`
5. If product is out of stock, submits a "missing" request → goes into `missing_requests`
6. Can also send a contact message (name, email, subject, message) → stored in `client_messages`

### Admin Flow
1. Admin logs in via `/administrator/login.php`
2. Lands on `/administrator/dashboard.php` — sees stat cards (total requests, total clients, hosted events), recent requests, featured products, top-ordered products, client messages, user accounts table, upcoming events, and a "Top Countries" map widget
3. Navigates to **Requests** (`requests.php`) — views all requests in a table; can click Approve or Reject. This fires an AJAX call to `save_status.php` (updates DB) and another to `send_email.php` (sends approval/rejection email to client via Gmail SMTP)
4. Navigates to **Mail** (`mail.php`) — reads all client messages; sees recent client accounts and admin profile
5. Navigates to **New** (`new.php`) — adds new products (name, units/stock, description, image upload), new events (image, date, topic, body text), or new top-ordered items; can also delete records by name
6. Navigates to **Report** (`report.php`) — filterable (Today/Yesterday/Last Week) and printable view of all requests by status (Available/Not Available)

---

## Key Features

### Admin Portal
- Session-protected pages (all pages check `$_SESSION["user_id"]`)
- Stat cards showing total requests, total clients, hosted events
- Recent requests table with Approve/Reject buttons + email notification on action
- Separate view for "missing" (out-of-stock) requests
- Client messages inbox
- User account list with print functionality
- Product management: add (with image upload), delete
- Event management: add (with image upload), delete by topic
- Top-ordered products management: add, delete
- Printable/filterable report page
- "Top Countries" display (Kenya, Uganda, Tanzania, Somalia) with hardcoded percentages
- Chart.js line chart (hardcoded sample data for Clients, Expenses, Products)

### Client Portal
- Session-protected landing page
- Full marketing landing page: Hero, About, Services (6 cards), Portfolio, Testimonials, Featured Products (from DB), Blog/Events (from DB), Contact form
- Product availability check before request submission (real-time stock deduction)
- "Request" form for out-of-stock products (goes to `missing_requests`)
- Contact message form
- Summary stats (total projects/requests, hosted events, total clients) pulled live from DB

---

## Email System

- **Library**: PHPMailer (manually bundled, not via Composer)
- **SMTP**: Gmail (`smtp.gmail.com`, port 587, TLS)
- **Account**: `karimicharity086@gmail.com` (app password hardcoded in `send_email.php`)
- **Trigger**: When admin clicks Approve or Reject on a request, an AJAX call to `send_email.php` sends an email to the client with their request details and the approval/rejection message

---

## Known Issues & Code Quality Notes

1. **Hardcoded DB credentials everywhere** — `root` with no password repeated across dozens of files (`localhost`, `root`, `""`)
2. **Mixed DB libraries** — Some files use `PDO`, others use `mysqli` raw. No consistent abstraction layer
3. **SQL injection risks** — `save_product.php` uses raw string interpolation in an INSERT query (`"INSERT INTO ... VALUES ('$name', '$units', '$image', '$description')"`)
4. **Hardcoded email credentials** — Gmail app password stored in plain text in `send_email.php`
5. **Two databases** — Data is split across `agrikenya_admin` and `agrikenya_clients`, requiring dual connections in almost every file
6. **Duplicated boilerplate** — Every admin page repeats 3–4 separate DB connection blocks and the same navigation HTML
7. **Inline styles** — Nearly all styling is done via inline `style=""` attributes rather than CSS classes
8. **Hardcoded content** — Country percentages, chart data, testimonials, portfolio images are all hardcoded
9. **No CSRF protection** — Forms have no token validation
10. **Profile picture handling** — Insecure: filenames are not sanitised before being stored
11. **`quantities` field in clients** — Assigned a random number (1–100) at signup; purpose is unclear
12. **`approved_report` table** — Defined in schema but not visibly used in the codebase
13. **`dash.php`** — Exists in the clients folder but appears to be a placeholder and is not linked to

---

## Assets

- **80+ product images** in `administrator/products/` (PNG/JPG, named with hex IDs)
- **Profile pictures** for both admin and client users in their respective `profile_pictures/` folders
- **Misc uploads** in `administrator/uploads/` (banner/feed images, SVG icons)
- **`zipFile.zip`** — Present in the project root; contents unknown

---

## Summary

Feeds Kenya is a two-portal, MySQL-backed PHP web application for managing agricultural animal feed distribution in Kenya. The admin side is a full management dashboard (products, events, requests, messages, reports). The client side is a marketing/request landing page for farmers. The core business logic involves inventory-aware product requests, admin approval workflows, and transactional email notifications. The codebase is functional but tightly coupled, with no framework, significant duplication, hardcoded credentials, and mixed database APIs throughout — making it a strong candidate for a clean rewrite in a structured framework like Python Flask.
