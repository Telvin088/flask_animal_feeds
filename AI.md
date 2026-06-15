# AI.md — Feeds Kenya Flask Transformation Log

> **Project**: Feeds Kenya / AgriKenya PHP → Flask rewrite
> **Goal**: A humanized, polished mini e-commerce style agricultural platform
> **Stack**: Python Flask · SQLAlchemy · SQLite · Jinja2 · Vanilla CSS/JS
> **Design**: Playfair Display + DM Sans · Forest Green `#1B4332` + Warm Gold `#D4A017` · Lucide Icons

---

## Phase Overview

| Phase | Title | Status |
|-------|-------|--------|
| 1 | Foundation & Setup | ✅ Done |
| 2 | Design System | ✅ Done |
| 3 | Authentication Templates | ✅ Done |
| 4 | Client Portal — All Pages | ✅ Done |
| 5 | Admin Portal — Base + Dashboard + Requests | ✅ Done |
| 6 | Admin Portal — Products, Events, Mail, Report, Users | 🔄 In Progress |
| 7 | Workflow Setup & Package Installation | ⏳ Pending |
| 8 | Testing & Smoke Run | ⏳ Pending |

---

## ✅ Phase 1 — Foundation & Setup

**Files created:**
- `requirements.txt` — Flask, Flask-SQLAlchemy, Flask-Mail, Werkzeug, gunicorn, python-dotenv
- `app.py` — Complete Flask backend (all models + all routes)

**Backend architecture in `app.py`:**
- **Models**: `User`, `Product`, `Event`, `TopOrdered`, `ProductRequest`, `ClientMessage`
- **User roles**: Single `users` table with `role` field (`'client'` / `'admin'`)
- **Auth routes**: `/login`, `/signup`, `/logout`, `/admin/login`, `/admin/signup`, `/admin/logout`
- **Client routes**: `/`, `/products`, `/products/<id>`, `/products/<id>/request`, `/request-missing`, `/orders`, `/events`, `/events/<id>`, `/contact`
- **Admin routes**: `/admin/dashboard`, `/admin/requests`, `/admin/products`, `/admin/events`, `/admin/mail`, `/admin/report`, `/admin/users` + all CRUD sub-routes
- **Helpers**: `login_required`, `admin_required` decorators · `save_upload()` · `send_status_email()` · context processor for `now` and `unread_messages`
- **DB init**: `init_db()` creates tables + upload folders + default admin `admin / admin123`

**Directory structure created:**
```
templates/auth/    templates/client/    templates/admin/
static/css/        static/js/
static/uploads/products/  events/  profiles/
```

---

## ✅ Phase 2 — Design System

**Files created:**
- `static/css/main.css` — Full client-side design system (~700 lines)
- `static/css/admin.css` — Admin layout (sidebar + topbar + components, ~300 lines)
- `static/js/main.js` — Mobile nav, user dropdown, flash dismiss, qty buttons, modals, sidebar toggle, print

**Design decisions:**
| Token | Value |
|-------|-------|
| Primary | `#1B4332` — deep forest green |
| Primary Mid | `#2D6A4F` |
| Accent | `#D4A017` — warm amber/gold |
| Background | `#FAFAF8` — warm off-white parchment |
| Heading font | `Playfair Display` (serif — warm, editorial) |
| Body font | `DM Sans` (humanized sans-serif) |
| Icons | Lucide Icons (via CDN) |
| Border radius | 12px cards, 8px inputs, full-pill buttons |
| Shadows | Green-tinted (not pure black) |

**Key CSS components built:** buttons (6 variants), forms, cards, badges, flash messages, navbar, footer, auth layout, hero, services grid, product grid, events grid, stats bar, contact layout, empty states, pagination, modals, testimonial, CTA section.

---

## ✅ Phase 3 — Authentication Templates

**Files created:**
- `templates/auth/login.html` — Two-column layout (image left, form right); client login
- `templates/auth/signup.html` — Two-column; registration with optional profile picture upload
- `templates/auth/admin_login.html` — Standalone centered card over dark green/image background
- `templates/auth/admin_signup.html` — Admin registration form

---

## ✅ Phase 4 — Client Portal (All Pages)

**Files created:**
- `templates/base.html` — Client base: sticky navbar (logo, links, user dropdown/auth CTAs, mobile menu), flash messages container, footer (brand + social + 3-col links)

- `templates/client/home.html`
  - Hero: full viewport, dark overlay, italic serif headline, stats (requests/clients/events), dual CTAs
  - About: two-column text + image with floating gold "100% Free" badge
  - Services: 6-card grid (Feeds, Consultation, Events, Health Clinics, Subsidy, Community)
  - Featured Products: dynamic 6-product grid from `is_featured=True`
  - Stats Bar: 3-column green bar (total requests, clients, events)
  - Top Ordered: dynamic 4-item card grid from `TopOrdered` table
  - Events Preview: 3 upcoming events with date badges
  - Testimonial: quote + avatar + star rating
  - CTA: full-width dark green CTA (shown only to logged-out users)

- `templates/client/products.html`
  - Page header with breadcrumb
  - Live search bar (GET `?q=`)
  - Product grid (auto-fill, 12-per-page with pagination)
  - In-stock / out-of-stock badges
  - "Request a missing product" modal for logged-in clients

- `templates/client/product_detail.html`
  - Page header with breadcrumb chain
  - Two-column: image left, info right
  - Stock status indicator (green dot / red dot)
  - Quantity +/− stepper input
  - Request form (for in-stock) or waiting-list form (for out-of-stock)
  - Login prompt for guests
  - Related products section (4 cards)

- `templates/client/orders.html`
  - 3-stat strip (total / approved / pending)
  - Full orders table (product, qty, location, date, type, status badge)
  - "Request a missing product" modal button

- `templates/client/events.html`
  - Page header
  - Events grid with date tags, "Upcoming" badge, read more links
  - Pagination

- `templates/client/event_detail.html`
  - Two-column: full article left, sticky sidebar right
  - Sidebar: event details card (date, location, organiser) + related events
  - WhatsApp share button

- `templates/client/contact.html`
  - Two-column: contact details left (phone, email, location, hours), form right
  - Form fields: name, email, subject, message

---

## ✅ Phase 5 — Admin Portal (Base + Dashboard + Requests)

**Files created:**
- `templates/admin/base.html`
  - Fixed sidebar (256px) with logo, sectioned nav links (active highlighting with amber left-bar), unread badge on Messages, user info + logout footer
  - Sticky topbar (60px): page title, mail + requests icon buttons with notification dot
  - Inline flash messages below topbar
  - Mobile: sidebar slides in from left via `open` class, hamburger button in topbar

- `templates/admin/dashboard.html`
  - 4-stat cards (Total Requests, Pending, Clients, Unread Messages) with color-coded top bars
  - Recent Requests panel: mini table with inline Approve/Reject buttons
  - Upcoming Events panel: icon cards
  - Recent Clients panel: user row list with avatars
  - Platform Summary panel + Quick Actions panel

- `templates/admin/requests.html`
  - 5-count stat strip (Available / Waiting / Pending / Approved / Rejected)
  - Type filter tabs (Available Stock ↔ Waiting List)
  - Status filter tabs (All / Pending / Approved / Rejected)
  - Full requests table with confirm-protected Approve/Reject action buttons
  - Empty state

---

## 🔄 Phase 6 — Admin Portal Remaining Pages (IN PROGRESS)

**Still to create:**
- `templates/admin/products.html` — Product CRUD grid + Top Ordered section + Add forms
- `templates/admin/events.html` — Events list + Add form
- `templates/admin/mail.html` — Messages inbox + sender sidebar
- `templates/admin/report.html` — Filterable report table + print button
- `templates/admin/users.html` — Clients table with full details

---

## ⏳ Phase 7 — Workflow & Environment Setup

**Still to do:**
- Update `.replit` to add `run = "python app.py"` and configure the workflow
- `pip install -r requirements.txt` to install Python packages
- Verify `static/uploads/` subdirectories are auto-created by `init_db()`

---

## ⏳ Phase 8 — Testing & Smoke Run

**Still to do:**
- Start the Flask dev server and verify it starts without errors
- Confirm default admin `admin / admin123` is created
- Walk through: home → products → product detail → request (as client)
- Walk through: admin login → dashboard → approve request
- Verify flash messages, mobile nav, modals all function
- Check responsive layout on narrow viewport

---

## Key Design Decisions (Permanent Reference)

| Decision | Choice | Reason |
|----------|--------|--------|
| Database | Single SQLite via SQLAlchemy | Original used 2 MySQL DBs with hardcoded creds — unified + portable |
| User model | One table, `role` field | Original had separate admin/client tables — DRY |
| All backend | `app.py` only | Explicit user requirement — no blueprints |
| File uploads | `static/uploads/<subfolder>/uuid.ext` | UUID names prevent collisions |
| Image URLs | `@property image_url` on models | Falls back to Unsplash placeholder if no upload |
| Email | Flask-Mail via env vars | Original had hardcoded Gmail password |
| Fonts | Playfair Display + DM Sans | Warm, humanized — not AI/corporate |
| Colors | Forest green + warm gold | Agricultural, trustworthy, not sterile |

---

*Last updated: Phase 5 complete, Phase 6 in progress.*
