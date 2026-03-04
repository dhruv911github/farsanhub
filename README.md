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

---

## 1. Project Overview

**FarsanHub** is a multi-user admin portal built for **Brahmani Khandvi & Farsan House** — a Gujarati snacks business located in Vadodara, Gujarat. The portal digitizes and manages the day-to-day business operations including customer records, product catalog, order tracking, expense management, image content, and monthly reporting.

**Business Address:**
Shop No-06, Arkview Tower, near Hari Om Subhanpura Water Tank,
Subhanpura, Vadodara, Gujarat – 390021

**Key Capabilities:**

| Module | What it does |
|---|---|
| Customers | Manage customer/shop profiles with geo-location |
| Products | Maintain product catalog with base pricing |
| Orders | Record and track daily orders (quantity × price) |
| Expenses | Log business expenses by purpose and date |
| Content | Upload and manage shop/product images |
| Reports | Export data to Excel & PDF receipts by month |
| Maps | Visualize customer locations on Leaflet map |

---

## 2. Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 9.19 |
| Language | PHP 8.x |
| Database | MySQL (database: `farsanhub`) |
| Frontend | Bootstrap 5, FontAwesome, SweetAlert2 |
| Maps | Leaflet.js |
| PDF Generation | barryvdh/laravel-dompdf ^3.1 |
| Excel Export | maatwebsite/excel ^3.1 |
| JS Validation | proengsoft/laravel-jsvalidation ^4.9 |
| Translation | stichoza/google-translate-php ^5.2 |
| HTTP Client | guzzlehttp/guzzle ^7.2 |
| Authentication | Laravel Session Auth (built-in) |
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
│       ├── Order.php
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
│       └── add_performance_indexes.php
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
| password | VARCHAR | Bcrypt hashed |
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
| status | VARCHAR | active/inactive |
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
| product_base_price | INTEGER | Auto-fills order price |
| status | VARCHAR | active/inactive |
| product_image | VARCHAR | File path |
| deleted_at | TIMESTAMP | Soft delete |
| created_at / updated_at | TIMESTAMP | |

---

### `orders`
| Column | Type | Notes |
|---|---|---|
| id | BIGINT (PK) | |
| user_id | BIGINT (FK → users) | Multi-user isolation |
| customer_id | BIGINT (FK → customers) | |
| product_id | BIGINT (FK → products) | |
| order_quantity | DECIMAL(8,2) | In KG |
| order_price | INTEGER | Unit price per KG |
| status | VARCHAR | delivered/pending/cancelled |
| created_at / updated_at | TIMESTAMP | |

> **Note:** Order total = `order_quantity × order_price` (calculated at runtime, not stored)

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

FarsanHub uses Laravel's built-in session-based authentication. Only users with `is_admin = true` in the `users` table can access the portal.

**Login Flow:**
1. User visits `/` — redirected to login form
2. Submits email + password
3. `AuthController@login` validates credentials
4. Checks `is_admin` flag — if false, login is rejected
5. On success: session regenerated, redirected to dashboard

**Logout:**
POST `/logout` → invalidates session → redirects to login

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
| GET | `/` | — | `AuthController@showLogin` | `login` |
| POST | `/login` | `throttle:5,1` | `AuthController@login` | `login.post` |
| POST | `/logout` | — | `AuthController@logout` | `logout` |

> **Login is rate-limited** to 5 attempts per minute per IP to prevent brute-force attacks.

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
| Expenses | `/admin/expense` | `ExpenseController` | `admin.expense` |

Each resource provides: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`

#### Delete Routes (inside `auth` + `admin` middleware group)
| Method | URI | Controller@Method | Name |
|---|---|---|---|
| DELETE | `/admin/contents` | `ContentController@destroy` | `admin.contents.destroy` |
| DELETE | `/admin/expense` | `ExpenseController@destroy` | `admin.expense.destroy` |
| DELETE | `/admin/customer` | `CustomerController@destroy` | `admin.customer.destroy` |
| DELETE | `/admin/product` | `ProductController@destroy` | `admin.product.destroy` |
| DELETE | `/admin/order` | `OrderController@destroy` | `admin.order.destroy` |

> All delete routes are protected by `auth` + `admin` middleware. Each `destroy()` method additionally verifies that the record belongs to the authenticated user (`user_id = auth()->id()`) before deletion.

#### Monthly Reports
| Method | URI | Controller@Method | Name |
|---|---|---|---|
| GET | `/admin/monthly-report` | `ReportController@index` | `admin.monthly-report.index` |
| GET | `/admin/monthly-report/order` | `ReportController@orderReport` | `admin.monthly-report.order` |
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
| `logout(Request)` | Invalidate session, redirect to login |
| `showRegister()` | Return register view (route currently commented out) |
| `register(Request)` | Create new admin user (route currently commented out) |

---

### `AdminController`
**File:** `app/Http/Controllers/Admin/AdminController.php`

| Method | Description |
|---|---|
| `dashboard()` | Fetch content count, render dashboard |
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

**Search Fields:** customer_name, customer_number, shop_name, city, shop_address

---

### `ProductController`
**File:** `app/Http/Controllers/Admin/ProductController.php`

| Method | Description |
|---|---|
| `index(Request)` | Paginated list with search. AJAX support. |
| `create()` | Show create form |
| `store(Request)` | Store product with image upload; fallback to logo.png |
| `edit(Product)` | Show edit form |
| `update(Request, Product)` | Update product; replace old image if new one uploaded |
| `destroy(Request)` | Soft-delete product; delete image from disk |

**Search Fields:** product_name, product_base_price

---

### `OrderController`
**File:** `app/Http/Controllers/Admin/OrderController.php`

| Method | Description |
|---|---|
| `index(Request)` | Paginated orders with joins (products, customers). Filter by customer, date range. |
| `create()` | Form with customer & product dropdowns |
| `store(Request)` | Create order; auto-set `order_price` from product's `product_base_price` |
| `edit(Order)` | Show edit form with current values |
| `update(Request, Order)` | Update order fields |
| `destroy(Request)` | Hard delete order |

**Filters:** customer_id, date range (from/to)
**Search:** product_name, customer_name, shop_name

---

### `ExpenseController`
**File:** `app/Http/Controllers/Admin/ExpenseController.php`

| Method | Description |
|---|---|
| `index(Request)` | Paginated expenses with search |
| `create()` | Show create form |
| `store(Request)` | Store expense record |
| `edit(Expense)` | Show edit form |
| `update(Request, Expense)` | Update expense |
| `destroy(Request)` | Soft-delete expense |

**Search Fields:** purpose, comment, date

---

### `ContentController`
**File:** `app/Http/Controllers/Admin/ContentController.php`

| Method | Description |
|---|---|
| `index()` | List all content (latest first, paginated) |
| `create()` | Show create form |
| `store(Request)` | Upload image with upload_date |
| `edit(Content)` | Show edit form |
| `update(Request, Content)` | Update content; replace old image if new one uploaded |
| `destroy(Request)` | Delete content record and image from disk |

---

### `ReportController`
**File:** `app/Http/Controllers/Admin/ReportController.php`

| Method | Description |
|---|---|
| `index()` | Report landing page with customer dropdown and month/year dropdowns |
| `orderReport(Request)` | Export orders filtered by customer + month. Type: `excel` or `pdf` |
| `customerReport(Request)` | Export all customers to Excel |
| `productReport(Request)` | Export all products to Excel |
| `expenseReport(Request)` | Export expenses for selected month to Excel |

**PDF Export Logic:**
- Filter orders by customer_id and/or month_year
- Calculate `order_quantity × order_price` per row
- Generate receipt number: `RCP-{YEAR}-{COUNT}`
- Load logo from `public/images/logo.png`
- Render `admin.monthly-report.order-pdf` blade template
- Return as downloadable PDF named `{Month-Year}-Order-Report.pdf`

---

## 8. Models & Relationships

### `User`
```php
Traits: HasApiTokens, HasFactory, Notifiable
Fillable: name, email, password, is_admin
Casts: email_verified_at → datetime, is_admin → boolean
Methods: isAdmin() → bool
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
Fillable: user_id, product_name, product_base_price, status, product_image
```

### `Order`
```php
Traits: HasFactory
Fillable: user_id, customer_id, product_id, order_quantity, order_price, status

Relationships:
  customer() → belongsTo(Customer::class)
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

All export classes implement `FromCollection`, `WithHeadings`, `WithStyles`.

### `CustomerExport`
**Columns:** Sr. No., Customer Name, Shop Name, Customer Mobile, Shop Address, City, Customer Email, Date
**Filter:** user_id = auth()->id()

### `ProductExport`
**Columns:** Sr. No., Product Name, Product Base Price, Date
**Filter:** user_id = auth()->id()

### `OrderExport`
**Constructor params:** `$customerId`, `$monthYear`
**Columns:** Sr. No., Customer Name, Shop Name, Product Name, Qty (KG), Unit Price, Total Amount, Date
**Features:**
- Calculates per-row total (qty × price)
- Appends **Grand Total** row at bottom (merged cells A–D)
- Bold header and grand total row
- Number formatting for price columns
- Filters by customer and/or month

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
| Top accent bar | Amber (#d97706) brand color stripe |
| Header | Logo + company address (left) / Receipt title, number, date (right) |
| Bill To | Customer name, shop, phone, address, city, email (if specific customer selected) |
| Report period | Month/Year range, receipt number, generated timestamp |
| Summary strip | 4 stat boxes: Total Orders, Customers, Total Qty, Grand Total |
| Orders table | Dark header, alternating rows, columns: #, Customer, Product, Qty, Unit Price, Amount, Date |
| Totals section | Notes box (left) + breakdown table with dark grand-total row (right) |
| Footer | Copyright + company address |
| Bottom accent bar | Matching amber stripe |

### Variables Passed to PDF View

| Variable | Type | Description |
|---|---|---|
| `$orders` | Collection | Order rows (with joined customer + product data) |
| `$monthName` | string | e.g. "March 2026" |
| `$monthYear` | string | e.g. "2026-03" |
| `$totalOrderAmount` | float | Sum of all order totals |
| `$totalOrderQuantity` | float | Sum of all quantities (KG) |
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

```php
if (!auth()->check() || !auth()->user()->is_admin) {
    return redirect('/')->with('error', 'Access denied.');
}
```

### `SecurityHeaders`
**File:** `app/Http/Middleware/SecurityHeaders.php`
**Applied to:** Global middleware stack (every request)

Injects HTTP security headers on every response to harden the application against common browser-level attacks.

| Header | Value | Protection |
|---|---|---|
| `X-Content-Type-Options` | `nosniff` | Prevents MIME-type sniffing |
| `X-Frame-Options` | `SAMEORIGIN` | Prevents clickjacking (iframe embedding) |
| `X-XSS-Protection` | `1; mode=block` | Enables browser XSS filter |
| `Referrer-Policy` | `strict-origin-when-cross-origin` | Controls referrer data leakage |
| `Permissions-Policy` | `camera=(), microphone=(), geolocation=(self)` | Restricts browser feature access |

### `SetLocale`
**File:** `app/Http/Middleware/SetLocale.php`
**Applied to:** Global / web middleware group

Reads `locale` from session and calls `App::setLocale($locale)`.
Language is switched via route: `GET /admin/lang/{locale}` → stores in session.

---

## 12. Multi-Language Support

**Supported Locales:** `en` (English), `gu` (Gujarati)

**Language Files:**
- `resources/lang/en/portal.php` — All UI labels in English
- `resources/lang/gu/portal.php` — All UI labels in Gujarati
- `resources/lang/en/messages.php` — Flash messages
- `resources/lang/en/validation.php` — Validation error messages

**Usage in Blade:**
```blade
{{ trans('portal.customer_name') }}
{{ @trans('portal.orders') }}
```

**Switch Language:**
```
GET /admin/lang/en   → sets English
GET /admin/lang/gu   → sets Gujarati
```

**Key Translation Keys (portal.php):**

| Key | English | Gujarati |
|---|---|---|
| dashboard | Dashboard | ડૅશબૉર્ડ |
| customers | Customers | ગ્રાહક |
| products | Products | ઉત્પાદન |
| orders | Orders | ઓર્ડર |
| expenses | Expenses | ખર્ચ |
| reports | Reports | અહેવાલ |
| customer_name | Customer Name | ગ્રાહક નામ |
| shop_name | Shop Name | દુકાન નામ |
| order_quantity | Order Quantity | ઓર્ડર જથ્થો |

---

## 13. Multi-User Architecture

FarsanHub supports multiple admin users where each user's data is **completely isolated**.

### How Isolation Works

**Database Level:**
`customers`, `products`, `orders`, and `expenses` tables all have a `user_id` foreign key.

**Query Level:**
Every query in every controller filters by the authenticated user:
```php
Customer::where('user_id', auth()->id())->get();
Product::where('user_id', auth()->id())->get();
Order::where('user_id', auth()->id())->get();
Expense::where('user_id', auth()->id())->get();
```

**Store Level:**
Every `store()` method sets `user_id = auth()->id()` on creation.

**Exception — Content:**
The `contents` table does NOT have `user_id`. All users share the same content/images.

### Adding a New Admin User

Since registration routes are commented out, new users must be created via:
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
│   ├── app.blade.php          → Main admin layout (sidebar, header, footer)
│   └── web.blade.php          → Public/auth layout
├── auth/
│   ├── login.blade.php        → Login page
│   └── register.blade.php     → Register page (route disabled)
├── admin/
│   ├── dashboard.blade.php    → Dashboard with stats
│   ├── leaflet-map.blade.php  → Customer geo-location map
│   ├── location-map.blade.php → Alternate map view
│   ├── parts/
│   │   ├── header.blade.php   → Top navigation bar
│   │   ├── sidebar.blade.php  → Left navigation menu
│   │   └── pagination.blade.php
│   ├── customer/
│   │   ├── index.blade.php    → Customer list with search
│   │   ├── create.blade.php   → Add customer form
│   │   ├── edit.blade.php     → Edit customer form
│   │   └── view.blade.php     → AJAX partial view
│   ├── product/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── view.blade.php
│   ├── order/
│   │   ├── index.blade.php    → Orders with date/customer filter
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── view.blade.php
│   ├── expense/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── view.blade.php
│   ├── content/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── view.blade.php
│   └── monthly-report/
│       ├── index.blade.php    → Report export selection page
│       └── order-pdf.blade.php → PDF receipt template (DomPDF)
├── module/
│   └── change-password.blade.php
└── parts/
    ├── header.blade.php
    ├── sidebar.blade.php
    └── footer.blade.php
```

---

## 15. Helper Functions

**File:** `app/Helpers/helpers.php`
Auto-loaded via `composer.json` → `autoload.files`

| Function | Signature | Description |
|---|---|---|
| `convertYmdToMdy` | `($date)` | Convert `Y-m-d` → `m-d-Y` format |
| `encryptResponse` | `($data, $key, $iv)` | AES-256-CBC encryption |
| `decryptAesResponse` | `($data, $key, $iv)` | AES-256-CBC decryption |
| `plainAmount` | `($formatted)` | Strip formatting from currency string |
| `formattedAmount` | `($amount)` | Format number to 2 decimal places |
| `formatByGroups` | `($number, $group)` | Group a number by spacing |

---

## 16. Form Request Validation

### `ChangePasswordRequest`
**File:** `app/Http/Requests/Admin/ChangePasswordRequest.php`

| Field | Rules |
|---|---|
| current_password | required, string, min:6 |
| password | required, string, min:6, confirmed |
| password_confirmation | required, string, min:6 |

Custom error messages are mapped to language file keys (e.g. `messages.current_password_incorrect`).

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
- Product image upload with fallback to default logo
- Base price used as default in order creation
- Multi-user isolated
- Search: name, base price

### Orders Module
- Full CRUD (hard delete)
- Auto-fills price from selected product's `product_base_price`
- Filter by customer and/or date range
- Total calculated at runtime (qty × price)
- Joins products and customers for display
- Multi-user isolated

### Expenses Module
- Full CRUD with soft-delete
- Track purpose, amount, comment, date
- Filter by month in reports
- Multi-user isolated

### Content Module
- Upload images with an upload date
- Global (shared across all users)
- Displayed on dashboard

### Monthly Reports Module
- **Order Report** → Excel or PDF, filter by customer + month
- **Customer Report** → Excel (all customers)
- **Product Report** → Excel (all products)
- **Expense Report** → Excel (filter by month)
- PDF uses professional invoice layout with DomPDF
- Validation: month must be selected before PDF export

### Map Module
- Leaflet.js integration
- Plots all customers with lat/lng coordinates
- Interactive markers with customer info popup

### Change Password
- Validate current password before update
- Uses FormRequest validation class
- Password hashed with bcrypt

---

---

## 20. Security Architecture

This section documents all security hardening measures implemented in FarsanHub.

### 20.1 Authentication Security

| Measure | Implementation |
|---|---|
| Admin-only access | `is_admin = true` flag checked by `AdminMiddleware` on every admin route |
| Session regeneration | Session ID regenerated on every login and logout to prevent session fixation |
| Brute-force protection | Login route: `throttle:5,1` — max 5 attempts per minute per IP (HTTP 429 on breach) |
| Password hashing | All passwords stored using bcrypt via `Hash::make()` |
| Current password verify | Change password requires current password confirmation via `ChangePasswordRequest` |

### 20.2 Authorization (Ownership Checks)

Every mutating operation (edit, update, delete) verifies that the record belongs to the currently authenticated user. Attempting to access another user's record returns **HTTP 403 Forbidden**.

```php
// Applied in edit(), update(), and destroy() across all controllers
abort_if($model->user_id !== auth()->id(), 403);

// Applied in destroy() methods
$model = Model::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
```

| Controller | Methods protected |
|---|---|
| `CustomerController` | `edit`, `update`, `destroy` |
| `ProductController` | `edit`, `update`, `destroy` |
| `OrderController` | `edit`, `update`, `destroy` |
| `ExpenseController` | `edit`, `update`, `destroy` |

### 20.3 Route Protection

All admin routes sit inside a middleware group:
```
Route::prefix('admin')->middleware(['auth', 'admin'])
```

Previously, the 5 delete routes existed **outside** this group (unauthenticated access was possible). They are now correctly placed inside the protected group.

### 20.4 Storage File Cleanup

When a record with an attached file is deleted, the associated file is also removed from disk to prevent storage leakage.

| Controller | Files deleted on destroy |
|---|---|
| `CustomerController` | `customer_image`, `shop_image` (public disk) |
| `ProductController` | `product_image` (public disk, skips default logo URL) |
| `ContentController` | `image` (public disk) |

File replacement on update also deletes the old file before storing the new one.

### 20.5 HTTP Security Headers

Every HTTP response includes the following headers (via `SecurityHeaders` middleware):

```
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: camera=(), microphone=(), geolocation=(self)
```

### 20.6 Input Validation

All form submissions are validated before processing:

| Module | Validated fields |
|---|---|
| Customer | name, shop, address, phone (10-digit regex), email, city, image mime/size |
| Product | name, base_price, image mime/size, status |
| Order | customer, product, quantity (numeric) |
| Expense | amount, purpose |
| Content | image mime/size, upload_date (date format) |
| Change Password | current_password, new password (min:6, confirmed) |

### 20.7 Data Isolation (Multi-User)

All user-scoped data is isolated at both query and write level:

- **Read:** Every `SELECT` filters `WHERE user_id = auth()->id()`
- **Write:** Every `INSERT` sets `user_id = auth()->id()`
- **Modify/Delete:** Ownership verified with `abort_if` before any change
- **Dropdowns:** Order create/edit forms only show the current user's products and customers

### 20.8 CSRF Protection

All POST, PUT, PATCH, DELETE requests are protected by Laravel's built-in CSRF middleware (`VerifyCsrfToken`) via the `web` middleware group.

---

## 21. Performance Optimizations

### 21.1 Database Indexes

Migration `2026_03_04_000001_add_performance_indexes.php` adds indexes that dramatically speed up all user-scoped queries and date-range report queries.

| Table | Index | Type | Purpose |
|---|---|---|---|
| `customers` | `user_id` | Single | All customer list queries |
| `products` | `user_id` | Single | All product list queries |
| `orders` | `user_id` | Single | All order list queries |
| `orders` | `customer_id` | Single | Customer-filter on order list |
| `orders` | `product_id` | Single | JOIN performance with products |
| `orders` | `(user_id, created_at)` | Composite | Monthly report date-range queries |
| `expenses` | `user_id` | Single | All expense list queries |
| `expenses` | `(user_id, date)` | Composite | Date-range expense filtering |

### 21.2 Optimized Month Dropdown Query

**Before:** All order/expense rows were fetched into PHP, then months were extracted and deduplicated in memory.

**After:** Month grouping is done at the database level with a single efficient query:

```php
// Before (loads all rows into PHP)
Order::select('created_at')->where('user_id', auth()->id())->get()
    ->map(...)->unique('value')->sortByDesc('sort_date')

// After (one DB query, no PHP processing)
Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as value, DATE_FORMAT(created_at, '%M-%Y') as label")
    ->where('user_id', auth()->id())
    ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m')")
    ->orderByRaw("DATE_FORMAT(created_at, '%Y-%m') DESC")
    ->get();
```

### 21.3 Dropdown Scope Fixes

Order create/edit forms previously loaded ALL products and ALL customers from the database regardless of user. Now filtered by `user_id`:

```php
// Before
Product::all()
Customer::all()

// After
Product::select('product_name', 'id')->where('user_id', auth()->id())->get()
Customer::select('shop_name', 'customer_name', 'id')->where('user_id', auth()->id())->get()
```

### 21.4 Application Cache

Run the following after every deployment for maximum performance:

```bash
php artisan config:cache   # Cache all config files into one file
php artisan route:cache    # Cache compiled route list
php artisan view:cache     # Pre-compile all Blade templates
```

To clear caches (e.g. during development):

```bash
php artisan optimize:clear
```

---

*Documentation last updated: March 2026 — FarsanHub v1.1*
*© 2025–2026 Brahmani Khandvi & Farsan House. All rights reserved.*
