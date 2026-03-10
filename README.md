# FarsanHub — Project Documentation

> **Farsan House Management Portal**
> Business Management Portal
> Built with Laravel 9 · MySQL · DomPDF · Maatwebsite Excel

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Tech Stack](#2-tech-stack)
3. [Project Structure](#3-project-structure)
4. [Database Schema](#4-database-schema)
5. [Authentication & Roles](#5-authentication--roles)
6. [Routes Reference](#6-routes-reference)
7. [Controllers](#7-controllers)
8. [Models & Relationships](#8-models--relationships)
9. [Excel Exports](#9-excel-exports)
10. [PDF Receipt Generation](#10-pdf-receipt-generation)
11. [Middleware](#11-middleware)
12. [Multi-Language Support](#12-multi-language-support)
13. [Multi-User Architecture](#13-multi-user-architecture)
14. [Views & Blade Structure](#14-views--blade-structure)
15. [Helper Functions](#15-helper-functions)
16. [Form Request Validation](#16-form-request-validation)
17. [Key Dependencies (composer.json)](#17-key-dependencies-composerjson)
18. [Environment Configuration](#18-environment-configuration)
19. [Module Feature Summary](#19-module-feature-summary)
20. [Security Architecture](#20-security-architecture)
21. [Performance Optimizations](#21-performance-optimizations)
22. [Changelog](#22-changelog)

---

## 1. Project Overview

**FarsanHub** is a multi-user admin portal built for **Brahmani Khandvi & Farsan House** — a Gujarati snacks business located in Vadodara, Gujarat. The portal digitizes and manages the day-to-day business operations including customer records, product catalog, order tracking, purchase order tracking, expense management, image content, and monthly reporting.

**Business Address:**
Shop No-06, Arkview Tower, near Hari Om Subhanpura Water Tank,
Subhanpura, Vadodara, Gujarat – 390021

**Key Capabilities:**

| Module | What it does |
|---|---|
| Customers | Manage customer/shop profiles with geo-location |
| Products | Maintain product catalog with base pricing and unit (kg/Nang) |
| Customer Pricing | Set customer-specific product prices overriding base price |
| Orders (Sales) | Record and track daily sales orders with live total preview |
| Purchase Orders | Record and track product purchase orders from suppliers |
| Expenses | Log business expenses by purpose and date |
| Content | Upload and manage shop/product images |
| Reports | Export all modules to Excel & PDF receipts by month |
| Maps | Visualize customer locations on Leaflet map |

---

## 2. Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 9.19 |
| Language | PHP 8.x |
| Database | MySQL (database: `farsanhub`) |
| Frontend | Bootstrap 5, FontAwesome, SweetAlert2 |
| Date Picker | Flatpickr (global, `dd-mm-yyyy` display) |
| Maps | Leaflet.js |
| PDF Generation | barryvdh/laravel-dompdf ^3.1 |
| Excel Export | maatwebsite/excel ^3.1 |
| JS Validation | proengsoft/laravel-jsvalidation ^4.9 |
| Translation | stichoza/google-translate-php ^5.2 |
| HTTP Client | guzzlehttp/guzzle ^7.2 |
| Authentication | Laravel Session Auth + Google OAuth (Socialite) |
| Timezone | Asia/Kolkata |
| Locale | `en` (English) / `gu` (Gujarati) |

---

## 3. Project Structure

```
farsanhub/
├── app/
│   ├── Exports/
│   │   ├── CustomerExport.php
│   │   ├── ProductExport.php
│   │   ├── OrderExport.php
│   │   ├── PurchaseOrderExport.php
│   │   └── ExpenseExport.php
│   ├── Helpers/
│   │   └── helpers.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   └── Admin/
│   │   │       ├── AdminController.php
│   │   │       ├── CustomerController.php
│   │   │       ├── ProductController.php
│   │   │       ├── OrderController.php
│   │   │       ├── PurchaseOrderController.php
│   │   │       ├── ExpenseController.php
│   │   │       ├── ContentController.php
│   │   │       └── ReportController.php
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   ├── SecurityHeaders.php
│   │   │   └── SetLocale.php
│   │   └── Requests/
│   │       └── Admin/
│   │           └── ChangePasswordRequest.php
│   └── Models/
│       ├── User.php
│       ├── Customer.php
│       ├── Product.php
│       ├── ProductPrice.php
│       ├── Order.php
│       ├── PurchaseOrder.php
│       ├── Expense.php
│       └── Content.php
├── database/
│   └── migrations/
│       ├── create_users_table.php
│       ├── create_customers_table.php
│       ├── create_products_table.php
│       ├── create_orders_table.php
│       ├── create_expenses_table.php
│       ├── create_contents_table.php
│       ├── add_performance_indexes.php
│       ├── add_unit_to_products_table.php
│       ├── create_product_prices_table.php 
│       └── create_purchase_orders_table.php
├── resources/
│   ├── lang/
│   │   ├── en/portal.php
│   │   └── gu/portal.php
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── customer/
│       │   ├── product/
│       │   ├── order/
│       │   ├── purchase-order/         
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── view.blade.php
│       │   ├── expense/
│       │   ├── content/
│       │   ├── monthly-report/
│       │   │   ├── index.blade.php
│       │   │   └── order-pdf.blade.php
│       │   └── parts/
│       ├── auth/
│       ├── layouts/
│       │   ├── app.blade.php
│       │   └── web.blade.php
│       └── module/
│           └── change-password.blade.php
└── routes/
    └── web.php
```

---

## 4. Database Schema

### `users`
| Column | Type | Notes |
|---|---|---|
| id | BIGINT (PK) | Auto-increment |
| name | VARCHAR | User's display name |
| email | VARCHAR (unique) | Login email |
| google_id | VARCHAR (unique) | Google account ID — nullable, set on first Google login ← **NEW** |
| password | VARCHAR | Bcrypt hashed — **nullable** for Google-only accounts ← **UPDATED** |
| is_admin | BOOLEAN | `true` = can login to portal |
| email_verified_at | TIMESTAMP | Nullable |
| remember_token | VARCHAR | Nullable |
| created_at / updated_at | TIMESTAMP | |

---

### `customers`
| Column | Type | Notes |
|---|---|---|
| id | BIGINT (PK) | |
| user_id | BIGINT (FK → users) | Multi-user isolation |
| customer_name | VARCHAR | |
| customer_number | VARCHAR | Phone number |
| shop_name | VARCHAR | |
| shop_address | VARCHAR | |
| city | VARCHAR | |
| customer_email | VARCHAR | |
| customer_image | VARCHAR | File path |
| shop_image | VARCHAR | File path |
| status | VARCHAR | Active/Inactive |
| latitude | VARCHAR | For map display |
| longitude | VARCHAR | For map display |
| deleted_at | TIMESTAMP | Soft delete |
| created_at / updated_at | TIMESTAMP | |

---

### `products`
| Column | Type | Notes |
|---|---|---|
| id | BIGINT (PK) | |
| user_id | BIGINT (FK → users) | Multi-user isolation |
| product_name | VARCHAR | |
| product_base_price | DECIMAL | Default price (overridden by product_prices) |
| unit | VARCHAR(20) | `kg` or `Nang` — default `kg` ← **NEW** |
| status | VARCHAR | Active/Inactive |
| product_image | VARCHAR | File path |
| deleted_at | TIMESTAMP | Soft delete |
| created_at / updated_at | TIMESTAMP | |

---

### `product_prices`
| Column | Type | Notes |
|---|---|---|
| id | BIGINT (PK) | |
| user_id | BIGINT (FK → users) | Multi-user isolation |
| product_id | BIGINT (FK → products) | |
| customer_id | BIGINT (FK → customers) | |
| price | DECIMAL(10,2) | Customer-specific override price |
| created_at / updated_at | TIMESTAMP | |

> **Logic:** When creating/editing an order, the system checks `product_prices` for a customer-specific price. If none exists, `product_base_price` is used. (`COALESCE` in SQL)

---

### `orders`
| Column | Type | Notes |
|---|---|---|
| id | BIGINT (PK) | |
| user_id | BIGINT (FK → users) | Multi-user isolation |
| customer_id | BIGINT (FK → customers) | |
| product_id | BIGINT (FK → products) | |
| order_quantity | DECIMAL(8,2) | Supports decimal (e.g. 2.5 kg) |
| order_price | DECIMAL(10,2) | Auto-resolved: customer price or base price |
| order_date | DATE | Explicit date field ← **UPDATED** |
| status | VARCHAR | |
| created_at / updated_at | TIMESTAMP | |

> **Note:** Order total = `order_quantity × order_price` (calculated at runtime, not stored)

---

### `purchase_orders`
| Column | Type | Notes |
|---|---|---|
| id | BIGINT (PK) | |
| user_id | BIGINT (FK → users) | Multi-user isolation |
| customer_id | BIGINT (FK → customers) | Used as supplier/party reference |
| product_id | BIGINT (FK → products) | |
| order_quantity | DECIMAL(8,2) | Quantity purchased |
| order_price | DECIMAL(10,2) | Manual purchase rate (not auto-filled) |
| order_date | DATE | Purchase date |
| status | VARCHAR | Nullable |
| created_at / updated_at | TIMESTAMP | |

> **Key difference from sales orders:** Purchase rate is manually entered (not auto-resolved from customer pricing), since purchase prices are negotiated at time of buying.

---

### `expenses`
| Column | Type | Notes |
|---|---|---|
| id | BIGINT (PK) | |
| user_id | BIGINT (FK → users) | Multi-user isolation |
| amount | VARCHAR | Expense amount |
| purpose | VARCHAR | Category/reason |
| comment | VARCHAR | Additional notes |
| date | DATE | Expense date |
| deleted_at | TIMESTAMP | Soft delete |
| created_at / updated_at | TIMESTAMP | |

---

### `contents`
| Column | Type | Notes |
|---|---|---|
| id | BIGINT (PK) | |
| image | VARCHAR | File path |
| upload_date | DATE | |
| created_at / updated_at | TIMESTAMP | |

> **Note:** Content is global — NOT isolated by user_id.

---

## 5. Authentication & Roles

FarsanHub supports two login methods: **email/password** and **Google OAuth** (via Laravel Socialite). Only users with `is_admin = true` in the `users` table can access the portal regardless of login method.

**Email/Password Login Flow:**
1. User visits `/admin` — login form is shown
2. Submits email + password
3. `AuthController@login` validates credentials
4. Checks `is_admin` flag — if false, login is rejected
5. On success: session regenerated, redirected to dashboard

**Google OAuth Login Flow:**
1. User clicks "Continue with Google" on login page
2. Redirected to Google's consent screen via `GET /auth/google`
3. Google redirects back to `GET /auth/google/callback`
4. `AuthController@handleGoogleCallback` retrieves Google profile
5. Looks up user by `google_id` first; falls back to matching by email
6. On first Google login: `google_id` is linked to the existing account
7. **No new accounts are created** — only pre-existing admin users can sign in via Google
8. Checks `is_admin` flag — if false, login is rejected
9. On success: session regenerated, redirected to dashboard

> **Security note:** Google login cannot be used to create new admin accounts. The user's email must already exist in the database with `is_admin = true`.

**Logout:**
POST `/logout` → invalidates session → redirects to home

**Password Change:**
Authenticated admin can change their password via `GET/POST /admin/changePassword`.
Validated by `ChangePasswordRequest` (requires current password + new password confirmation).

**Route Protection:**
All admin routes are guarded by two middleware layers:
```
auth        → must be logged in
admin       → AdminMiddleware: must have is_admin = true
```

---

## 6. Routes Reference

### Public Routes
| Method | URI | Middleware | Controller@Method | Name |
|---|---|---|---|---|
| GET | `/admin` | — | `AuthController@showLogin` | `login` |
| POST | `/login` | `throttle:5,1` | `AuthController@login` | `login.post` |
| POST | `/logout` | — | `AuthController@logout` | `logout` |
| GET | `/auth/google` | `throttle:10,1` | `AuthController@redirectToGoogle` | `auth.google` |
| GET | `/auth/google/callback` | `throttle:10,1` | `AuthController@handleGoogleCallback` | `auth.google.callback` |

> **Login is rate-limited:** Email login — 5 attempts/min per IP. Google OAuth — 10 requests/min per IP.

### Admin Routes (Middleware: `auth`, `admin`)

#### Dashboard & Utility
| Method | URI | Controller@Method | Name |
|---|---|---|---|
| GET | `/admin/dashboard` | `AdminController@dashboard` | `admin.dashboard` |
| GET | `/admin/lang/{locale}` | Closure (set locale) | `admin.lang` |
| GET | `/admin/leaflet-map` | `CustomerController@leafletMap` | `admin.leaflet-map` |
| GET | `/admin/changePassword` | `AdminController@changePassword` | `admin.changePassword` |
| POST | `/admin/changePassword` | `AdminController@changePasswordPost` | `admin.changePassword.save` |

#### Resource Routes (CRUD)
| Resource | Base URI | Controller | Route Prefix |
|---|---|---|---|
| Contents | `/admin/contents` | `ContentController` | `admin.contents` |
| Customers | `/admin/customer` | `CustomerController` | `admin.customer` |
| Products | `/admin/product` | `ProductController` | `admin.product` |
| Orders | `/admin/order` | `OrderController` | `admin.order` |
| Purchase Orders | `/admin/purchase-order` | `PurchaseOrderController` | `admin.purchase-order` ← **NEW** |
| Expenses | `/admin/expense` | `ExpenseController` | `admin.expense` |

#### Special Routes
| Method | URI | Controller@Method | Name |
|---|---|---|---|
| GET | `/admin/order/products-by-customer` | `OrderController@getProductsByCustomer` | `admin.order.products-by-customer` |
| GET | `/admin/purchase-order/products-by-customer` | `PurchaseOrderController@getProductsByCustomer` | `admin.purchase-order.products-by-customer` ← **NEW** |

#### Delete Routes
| Method | URI | Controller@Method | Name |
|---|---|---|---|
| DELETE | `/admin/contents` | `ContentController@destroy` | `admin.contents.destroy` |
| DELETE | `/admin/expense` | `ExpenseController@destroy` | `admin.expense.destroy` |
| DELETE | `/admin/customer` | `CustomerController@destroy` | `admin.customer.destroy` |
| DELETE | `/admin/product` | `ProductController@destroy` | `admin.product.destroy` |
| DELETE | `/admin/order` | `OrderController@destroy` | `admin.order.destroy` |
| DELETE | `/admin/purchase-order` | `PurchaseOrderController@destroy` | `admin.purchase-order.destroy` ← **NEW** |

#### Monthly Reports
| Method | URI | Controller@Method | Name |
|---|---|---|---|
| GET | `/admin/monthly-report` | `ReportController@index` | `admin.monthly-report.index` |
| GET | `/admin/monthly-report/order` | `ReportController@orderReport` | `admin.monthly-report.order` |
| GET | `/admin/monthly-report/purchase-order` | `ReportController@purchaseOrderReport` | `admin.monthly-report.purchase-order` ← **NEW** |
| GET | `/admin/monthly-report/customer` | `ReportController@customerReport` | `admin.monthly-report.customer` |
| GET | `/admin/monthly-report/product` | `ReportController@productReport` | `admin.monthly-report.product` |
| GET | `/admin/monthly-report/expense` | `ReportController@expenseReport` | `admin.monthly-report.expense` |

---

## 7. Controllers

### `AuthController`
**File:** `app/Http/Controllers/AuthController.php`

| Method | Description |
|---|---|
| `showLogin()` | Return login view |
| `login(Request)` | Validate credentials, check `is_admin`, redirect to dashboard |
| `redirectToGoogle()` | Redirect user to Google's OAuth consent screen |
| `handleGoogleCallback()` | Handle Google callback — match by `google_id` or email, link account, check `is_admin`, login |
| `logout(Request)` | Invalidate session, redirect to home |

---

### `AdminController`
**File:** `app/Http/Controllers/Admin/AdminController.php`

| Method | Description |
|---|---|
| `dashboard()` | Stats cards (customers, orders, products, revenue), chart data for last 6 months, recent orders, top customers |
| `changePassword()` | Show change password form |
| `changePasswordPost(ChangePasswordRequest)` | Validate current password, update with bcrypt |

---

### `CustomerController`
**File:** `app/Http/Controllers/Admin/CustomerController.php`

| Method | Description |
|---|---|
| `index(Request)` | Paginated list with search (name, phone, shop, city, address). AJAX support. |
| `create()` | Show create form |
| `store(Request)` | Store new customer, handle `customer_image` and `shop_image` uploads |
| `edit(Customer)` | Show edit form |
| `update(Request, Customer)` | Update fields; delete & replace old images if new ones uploaded |
| `destroy(Request)` | Soft-delete customer; delete associated images from disk |
| `leafletMap()` | Return all customers with lat/lng for Leaflet map view |

---

### `ProductController`
**File:** `app/Http/Controllers/Admin/ProductController.php`

| Method | Description |
|---|---|
| `index(Request)` | Paginated table list with search. AJAX support. |
| `create()` | Show create form with unit selector (kg / Nang) |
| `store(Request)` | Store product with `unit` field; image upload |
| `edit(Product)` | Show edit form with unit pre-filled |
| `update(Request, Product)` | Update product including `unit`; replace old image |
| `destroy(Request)` | Soft-delete product; delete image from disk |

**Changes:** Customer dropdown removed. `unit` field (`kg`/`Nang`) added to create/edit. Product list changed from card view to table view.

---

### `OrderController`
**File:** `app/Http/Controllers/Admin/OrderController.php`

| Method | Description |
|---|---|
| `index(Request)` | Paginated orders with joins (products+unit, customers). Filter by customer, date range. |
| `create()` | Form with customer & product dropdowns |
| `store(Request)` | Create order; auto-resolve `order_price` via `getEffectivePrice()` |
| `edit(Order)` | Show edit form; fetch products with effective price via LEFT JOIN |
| `update(Request, Order)` | Update order; re-resolve price from `getEffectivePrice()` |
| `destroy(Request)` | Hard delete order |
| `getProductsByCustomer(Request)` | AJAX: returns products with resolved price (customer-specific or base) |

**`getEffectivePrice($productId, $customerId)`** — Private method that checks `product_prices` table first, falls back to `product_base_price`.

---

### `PurchaseOrderControll
**File:** `app/Http/Controllers/Admin/PurchaseOrderController.php`

| Method | Description |
|---|---|
| `index(Request)` | Paginated list with joins (products+unit, customers). Filter by date, supplier. AJAX support. |
| `create()` | Form with party/supplier and product dropdowns |
| `store(Request)` | Validate and create purchase order with manual rate |
| `edit(PurchaseOrder)` | Show edit form; products with effective_price via LEFT JOIN |
| `update(Request, PurchaseOrder)` | Update fields including manual rate |
| `destroy(Request)` | Hard delete purchase order |
| `getProductsByCustomer(Request)` | AJAX: returns products with resolved price for pre-filling rate |

---

### `ReportController`
**File:** `app/Http/Controllers/Admin/ReportController.php`

| Method | Description |
|---|---|
| `index()` | Report page with month dropdowns for orders, purchase orders, expenses |
| `orderReport(Request)` | Export sales orders filtered by customer + month. Type: `excel` or `pdf` |
| `purchaseOrderReport(Request)` | Export purchase orders filtered by party + month → Excel ← **NEW** |
| `customerReport(Request)` | Export all customers to Excel |
| `productReport(Request)` | Export all products to Excel |
| `expenseReport(Request)` | Export expenses for selected month to Excel |

---

## 8. Models & Relationships

### `User`
```php
Traits: HasApiTokens, HasFactory, Notifiable
Fillable: name, email, password, google_id, is_admin
Casts: email_verified_at → datetime, is_admin → boolean
Methods: isAdmin() → bool
// google_id: nullable, linked on first Google OAuth login
// password: nullable to support Google-only accounts
```

### `Customer`
```php
Traits: HasFactory, SoftDeletes
Fillable: user_id, customer_name, customer_number, shop_name,
          shop_address, city, customer_email, customer_image,
          shop_image, status, latitude, longitude
```

### `Product`
```php
Traits: HasFactory, SoftDeletes
Fillable: user_id, product_name, product_base_price, unit, status, product_image
// 'unit' added — values: 'kg' | 'Nang', default: 'kg'
```

### `ProductPrices`
```php
Traits: HasFactory
Fillable: user_id, product_id, customer_id, price
Table: product_prices
```

### `Order`
```php
Traits: HasFactory
Fillable: user_id, customer_id, product_id, order_quantity, order_price, order_date, status
Relationships:
  customer() → belongsTo(Customer::class)
```

### `PurchaseOrders`
```php
Traits: HasFactory
Table: purchase_orders
Fillable: user_id, customer_id, product_id, order_quantity, order_price, order_date, status
Casts: order_date → date
```

### `Expense`
```php
Traits: HasFactory, SoftDeletes
Fillable: user_id, amount, purpose, comment, date, deleted_at
```

### `Content`
```php
Traits: HasFactory
Fillable: name, image, upload_date
Casts: upload_date → date
```

---

## 9. Excel Exports

All export classes implement `FromCollection`, `WithHeadings`, `WithStyles`, `WithEvents`.

### `CustomerExport`
**Columns:** Sr. No., Customer Name, Shop Name, Customer Mobile, Shop Address, City, Customer Email, Date
**Filter:** user_id = auth()->id()

### `ProductExport`
**Columns:** Sr. No., Product Name, Product Base Price, Date
**Filter:** user_id = auth()->id()

### `OrderExport`
**Constructor params:** `$customerId`, `$monthYear`
**Columns:** Sr. No., Customer Name, Shop Name, Product Name, Qty (unit), Unit Price, Total Amount, Date
**Features:**
- Resolves effective price (customer-specific or base)
- Calculates per-row total (qty × price)
- Appends **Grand Total** row at bottom (merged cells A–D)
- Bold header and grand total row
- Number formatting for price columns

### `PurchaseOrderExpo
**Constructor params:** `$customerId`, `$monthYear`
**Columns:** Sr. No., Party/Supplier, Shop Name, Product, Quantity, Purchase Rate, Total Amount, Date
**Features:**
- Filters by party (customer_id) and/or month
- Appends **Grand Total** row (total quantity + total amount)
- Bold header and grand total row

### `ExpenseExport`
**Constructor params:** `$monthYear`
**Columns:** Purpose, Amount, Comment, Date
**Filter:** Date range for selected month, user_id isolated

---

## 10. PDF Receipt Generation

**Template:** `resources/views/admin/monthly-report/order-pdf.blade.php`
**Engine:** DomPDF (barryvdh/laravel-dompdf)

### PDF Sections

| Section | Content |
|---|---|
| Top accent bar | Orange (#FF9933) brand color stripe |
| Header | Logo + company address (left) / Receipt title, number, date (right) |
| Bill To | Customer name, shop, phone, address, city, email (if specific customer selected) |
| Report period | Month/Year range, receipt number, generated timestamp |
| Summary strip | 4 stat boxes: Total Orders, Customers, Total Qty, Grand Total |
| Orders table | Dark header, alternating rows, columns: #, Customer, Product, Qty, Unit Price, Amount, Date |
| Totals section | Notes box (left) + breakdown table with dark grand-total row (right) |
| Footer | Copyright + company address |

### Variables Passed to PDF View

| Variable | Type | Description |
|---|---|---|
| `$orders` | Collection | Order rows (with joined customer + product data) |
| `$monthName` | string | e.g. "March 2026" |
| `$monthYear` | string | e.g. "2026-03" |
| `$totalOrderAmount` | float | Sum of all order totals |
| `$totalOrderQuantity` | float | Sum of all quantities |
| `$reportDate` | string | e.g. "04 Mar 2026, 02:30 PM" |
| `$logoPath` | string | Absolute path to `public/images/logo.png` |
| `$customerInfo` | Customer\|null | Full customer model if specific customer selected |
| `$receiptNo` | string | Auto-generated: `RCP-2026-0012` |

---

## 11. Middleware

### `AdminMiddleware`
**File:** `app/Http/Middleware/AdminMiddleware.php`
**Alias:** `admin` (registered in Kernel.php)

Checks if the authenticated user has `is_admin = true`. If not, redirects to home with an error flash message.

### `SecurityHeaders`
Injects HTTP security headers on every response:

| Header | Value |
|---|---|
| `X-Content-Type-Options` | `nosniff` |
| `X-Frame-Options` | `SAMEORIGIN` |
| `X-XSS-Protection` | `1; mode=block` |
| `Referrer-Policy` | `strict-origin-when-cross-origin` |
| `Permissions-Policy` | `camera=(), microphone=(), geolocation=(self)` |

### `SetLocale`
Reads `locale` from session and calls `App::setLocale($locale)`.

---

## 12. Multi-Language Support

**Supported Locales:** `en` (English), `gu` (Gujarati)

**Language Files:**
- `resources/lang/en/portal.php` — All UI labels in English
- `resources/lang/gu/portal.php` — All UI labels in Gujarati
- `resources/lang/en/messages.php` — Flash messages

**Switch Language:**
```
GET /admin/lang/en   → sets English
GET /admin/lang/gu   → sets Gujarati
```

---

## 13. Multi-User Architecture

FarsanHub supports multiple admin users where each user's data is **completely isolated**.

`customers`, `products`, `orders`, `purchase_orders`, and `expenses` tables all have a `user_id` foreign key.

Every query filters by `auth()->id()`, every `store()` sets `user_id = auth()->id()`, and every edit/delete verifies ownership via `abort_if($model->user_id !== auth()->id(), 403)`.

### Adding a New Admin User

```bash
php artisan tinker
User::create([
    'name'     => 'New Admin',
    'email'    => 'admin@example.com',
    'password' => bcrypt('password123'),
    'is_admin' => true,
]);
```

---

## 14. Views & Blade Structure

```
resources/views/
├── layouts/
│   ├── app.blade.php          → Main admin layout (sidebar, header, Flatpickr global init)
│   └── web.blade.php          → Public/auth layout
├── auth/
│   └── login.blade.php
├── admin/
│   ├── dashboard.blade.php    → Stats, 6-month charts, recent orders, top customers
│   ├── parts/
│   │   ├── header.blade.php
│   │   ├── sidebar.blade.php  → Desktop + mobile offcanvas menus
│   │   └── pagination.blade.php
│   ├── customer/
│   ├── product/               → Table view (not card view)
│   ├── order/
│   │   ├── index.blade.php    → Filters: date range, customer, search
│   │   ├── create.blade.php   → AJAX product load, live total preview
│   │   ├── edit.blade.php     → Pre-filled form, live total preview
│   │   └── view.blade.php     → AJAX partial, orange-themed table
│   ├── purchase-order/    
│   │   ├── index.blade.php    → Same filter/search pattern as orders
│   │   ├── create.blade.php   → Party + Product + manual Rate + live total
│   │   ├── edit.blade.php     → Pre-filled, live total updates
│   │   └── view.blade.php     → Orange-themed table partial
│   ├── expense/
│   ├── content/
│   └── monthly-report/
│       ├── index.blade.php    → 5 report cards in col-lg-4 grid
│       └── order-pdf.blade.php
└── module/
    └── change-password.blade.php
```

---

## 15. Helper Functions

**File:** `app/Helpers/helpers.php`

| Function | Description |
|---|---|
| `convertYmdToMdy($date)` | Convert `Y-m-d` → `m-d-Y` format |
| `encryptResponse($data, $key, $iv)` | AES-256-CBC encryption |
| `decryptAesResponse($data, $key, $iv)` | AES-256-CBC decryption |
| `plainAmount($formatted)` | Strip formatting from currency string |
| `formattedAmount($amount)` | Format number to 2 decimal places |
| `formatByGroups($number, $group)` | Group a number by spacing |

---

## 16. Form Request Validation

### `ChangePasswordRequest`

| Field | Rules |
|---|---|
| current_password | required, string, min:6 |
| password | required, string, min:6, confirmed |
| password_confirmation | required, string, min:6 |

---

## 17. Key Dependencies (composer.json)

### Production

| Package | Version | Purpose |
|---|---|---|
| `laravel/framework` | ^9.19 | Core framework |
| `laravel/sanctum` | ^3.0 | API token authentication |
| `barryvdh/laravel-dompdf` | ^3.1 | PDF generation (receipts) |
| `maatwebsite/excel` | ^3.1 | Excel file exports |
| `proengsoft/laravel-jsvalidation` | ^4.9 | Server-side rules in JS |
| `stichoza/google-translate-php` | ^5.2 | Google Translate API |
| `guzzlehttp/guzzle` | ^7.2 | HTTP client |
| `laravel/socialite` | ^5.24 | Google OAuth login (Socialite) |
| `laravel/tinker` | ^2.7 | Artisan REPL |

### Development

| Package | Purpose |
|---|---|
| `fakerphp/faker` | Fake data for seeding |
| `laravel/pint` | PHP code formatter |
| `phpunit/phpunit` | Unit testing |
| `spatie/laravel-ignition` | Debug error pages |

---

## 19. Module Feature Summary

### Customers Module
- Full CRUD with soft-delete
- Upload customer photo and shop photo
- Store latitude/longitude for map display
- Multi-user isolated
- Search: name, phone, shop name, city, address
- AJAX-powered pagination
- Leaflet map view shows all customer locations as markers

### Products Module
- Full CRUD with soft-delete
- **Table view** (replaced card view)
- **Unit field** (`kg` / `Nang`) — selectable on create/edit, shown dynamically on all order forms
- Customer dropdown removed — products are user-scoped, not customer-scoped
- Customer-specific pricing managed via separate `product_prices` table
- Product image upload with fallback to default logo
- Multi-user isolated

### Customer-Specific Pricing
- Set a different price per product per customer via the product edit form
- Prices are stored in `product_prices` table
- When creating a sales order: system auto-resolves price via `COALESCE(customer_price, base_price)`
- Price resolution handled by `OrderController@getEffectivePrice()`

### Orders (Sales) Module
- Full CRUD (hard delete)
- **AJAX product loading** based on selected customer (with resolved price)
- **Live total preview** — updates instantly as quantity or product changes (`Rate × Qty = Total`)
- `order_price` auto-resolved from customer-specific pricing or product base price
- Dynamic unit label (`kg` / `Nang`) pulled from product's `unit` field
- Filter by customer and/or date range
- Orange-themed responsive table view with totals row
- Multi-user isolated

### Purchase Orders Mod
- Full CRUD (hard delete)
- Record product purchases from suppliers/parties
- Party selected from existing customers list
- Product selected via AJAX (pre-fills suggested rate from product pricing)
- **Manual purchase rate entry** — rate is user-entered, not auto-resolved
- **Live total preview** — Rate × Qty = Total, updates on any change
- Dynamic unit label per product
- Filter by date range and party
- Same orange-themed table with totals row
- Multi-user isolated

### Expenses Module
- Full CRUD with soft-delete
- Track purpose, amount, comment, date
- Filter by month in reports
- Multi-user isolated

### Content Module
- Upload images with an upload date
- Global (shared across all users)

### Monthly Reports Module
- **Layout:** 5 report cards in responsive `col-12 col-lg-4` grid
- **Sales Orders** → Excel or PDF, filter by customer + month
- **Purchase Orders** → Excel, filter by party + month ← **NEW**
- **Expenses** → Excel, filter by month
- **Customers** → Excel (all customers)
- **Products** → Excel (all products)
- PDF uses professional invoice layout with DomPDF
- Validation: month must be selected before export

### Dashboard
- 4 stat cards: Total Customers, Total Orders, Total Products, This Month Revenue
- Monthly overview line chart (Revenue + Orders, last 6 months) — Chart.js
- Top products doughnut chart + horizontal bar
- Monthly quantity dispatched bar chart
- Recent orders table
- Top customers list
- All "View All" buttons fully responsive (visible on all screen sizes)

### Date Picker (Global)
- **Flatpickr** integrated globally in `app.blade.php`
- Applied to all `input[type="date"]` elements automatically
- Display format: `dd-mm-yyyy` (via `altInput` + `altFormat`)
- Submitted value stays `Y-m-d` for Laravel validation
- Custom `data-fp-onchange` attribute triggers named JS callbacks on date change

### Map Module
- Leaflet.js integration
- Plots all customers with lat/lng coordinates
- Interactive markers with customer info popup

### Change Password
- Validate current password before update
- Uses FormRequest validation class
- Password hashed with bcrypt

---

## 20. Security Architecture

### 20.1 Authentication Security

| Measure | Implementation |
|---|---|
| Admin-only access | `is_admin = true` flag checked by `AdminMiddleware` on every admin route |
| Session regeneration | Session ID regenerated on every login (both email and Google) and logout |
| Brute-force protection (email) | Login route: `throttle:5,1` — max 5 attempts per minute per IP |
| Brute-force protection (Google) | OAuth routes: `throttle:10,1` — max 10 requests per minute per IP |
| Password hashing | All passwords stored using bcrypt via `Hash::make()` |
| Current password verify | Change password requires current password confirmation |
| Google: no auto-registration | Google OAuth **cannot create new accounts** — user email must already exist with `is_admin = true` |
| Google: account linking | `google_id` is linked to existing account on first Google login — verified by matching email |
| Google: error logging | OAuth failures are logged via `Log::error()` without exposing error details to the user |
| Credentials storage | Google Client ID/Secret stored only in `.env` — never committed to version control |

### 20.2 Authorization (Ownership Checks)

```php
abort_if($model->user_id !== auth()->id(), 403);
```

Applied in `edit()`, `update()`, `destroy()` across all controllers including `PurchaseOrderController`.

### 20.3 Route Protection

All admin routes sit inside:
```
Route::prefix('admin')->middleware(['auth', 'admin'])
```

### 20.4 HTTP Security Headers

```
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: camera=(), microphone=(), geolocation=(self)
```

### 20.5 Input Validation

All form submissions are validated before processing:

| Module | Validated fields |
|---|---|
| Customer | name, shop, address, phone, email, city, image mime/size |
| Product | name, base_price, unit (in:kg,Nang), image mime/size, status |
| Order | customer, product, quantity (numeric min:0.01), date |
| Purchase Order | customer, product, quantity (numeric min:0.01), price (numeric min:0), date |
| Expense | amount, purpose |
| Change Password | current_password, new password (min:6, confirmed) |

### 20.6 CSRF Protection

All POST, PUT, PATCH, DELETE requests are protected by Laravel's built-in `VerifyCsrfToken` middleware.

---

## 21. Performance Optimizations

### 21.1 Database Indexes

| Table | Index | Type | Purpose |
|---|---|---|---|
| `customers` | `user_id` | Single | All customer list queries |
| `products` | `user_id` | Single | All product list queries |
| `orders` | `user_id` | Single | All order list queries |
| `orders` | `customer_id` | Single | Customer-filter on order list |
| `orders` | `(user_id, created_at)` | Composite | Monthly report date-range queries |
| `expenses` | `user_id` | Single | All expense list queries |
| `expenses` | `(user_id, date)` | Composite | Date-range expense filtering |

### 21.2 AJAX-Powered Lists

Order and Purchase Order indexes load table data via AJAX — search, pagination, and date filters all reload only the table partial without full page reload.

### 21.3 Optimized Price Resolution

Customer-specific pricing uses a single SQL `LEFT JOIN + COALESCE` rather than multiple PHP queries:

```php
DB::raw('COALESCE(product_prices.price, products.product_base_price) as effective_price')
```

### 21.4 Application Cache

```bash
php artisan config:cache   # Cache all config files
php artisan route:cache    # Cache compiled route list
php artisan view:cache     # Pre-compile all Blade templates
```

To clear caches:

```bash
php artisan optimize:clear
```

---

## 22. Changelog

### v1.4 — March 2026
- **NEW: Google OAuth Login** — "Continue with Google" button on login page (via `laravel/socialite`)
- **NEW: Google account linking** — `google_id` column added to `users` table; linked automatically on first Google login by email match
- **NEW: password nullable** — `users.password` is now nullable to support Google-only accounts
- **SECURITY: OAuth rate limiting** — Google auth routes protected with `throttle:10,1`
- **SECURITY: No auto-registration** — Google OAuth only allows pre-existing admin accounts; cannot create new users
- **SECURITY: Error logging** — Google callback failures logged via `Log::error()` without leaking details to the user
- **UI: Google button styling** — orange-themed (`#FF9933` border) button with hover glow, matching site theme; overrides global `a` tag styles

### v1.3 — March 2026
- **NEW: Purchase Orders module** — full CRUD, sidebar entry, routes, views, orange-themed table
- **NEW: Purchase Order Excel export** — in Reports module, filter by party + month
- **NEW: Customer-Specific Product Pricing** — `product_prices` table; price auto-resolved on order create/edit
- **NEW: Live Total Preview** — on Order and Purchase Order create/edit forms (Rate × Qty = Total, updates instantly)
- **UPDATED: Product Unit field** — `unit` column (`kg` / `Nang`); selector on create/edit; dynamic label on all order forms
- **UPDATED: Product listing** — changed from card view to responsive table view
- **UPDATED: Product forms** — removed customer dropdown; added unit selector
- **UPDATED: Reports layout** — redesigned with orange theme cards (`col-12 col-lg-4`); 5 report cards total
- **UPDATED: Flatpickr date picker** — globally integrated on all `input[type="date"]` elements; display as `dd-mm-yyyy`
- **UPDATED: Order list view** — orange-themed table with quantity pills, styled edit/delete buttons, totals row
- **UPDATED: Dashboard** — "View All" buttons now visible and responsive on all screen sizes
- **UPDATED: Sidebar** — Purchase Orders entry added to both desktop and mobile menus

### v1.2 — March 2026
- Dashboard redesigned with Chart.js charts (line, doughnut, bar)
- Revenue and order trend stats with month-over-month comparison
- Recent orders table on dashboard
- Top customers list on dashboard

### v1.1 — March 2026
- Multi-user data isolation architecture
- Security headers middleware
- Performance indexes migration
- Optimized month dropdown queries
- PDF receipt generation for orders
- Reports module with Excel + PDF export

### v1.0 — Initial Release
- Customer, Product, Order, Expense, Content CRUD modules
- Laravel session authentication with `is_admin` gate
- Multi-language support (English + Gujarati)
- Leaflet map for customer locations

---

*Documentation last updated: March 2026 — FarsanHub v1.4*
*© 2025–2026 Brahmani Khandvi & Farsan House. All rights reserved.*
