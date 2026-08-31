# Mupaka Shamba Letu (MSL)

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat-square&logo=alpine.js)](https://alpinejs.dev)
[![Tests Status](https://img.shields.io/badge/Tests-42%20passed%20(217%20assertions)-brightgreen?style=flat-square)](tests)
[![Code Style](https://img.shields.io/badge/Code_Style-Laravel_Pint-blue?style=flat-square)](https://laravel.com/docs/pint)

**Mupaka Shamba Letu** is a multilingual cross-border trade information management system designed for the Great Lakes region (**DR Congo**, **Rwanda**, and **Burundi**). The platform operationalizes the **NEXUS approach** by connecting humanitarian support, long-term economic resilience for small-scale cross-border traders (AVECs/FPCTS), and peacebuilding through transparent market data, currency exchange monitoring, travel requirement guides, and cross-border grievance reporting.

---

## Key Features

### 1. Public Information Portal
- **Interactive Home Page (`/`)**:
  - Hero slider with automatic rotation, pause on hover, navigation controls, and pagination indicators.
  - Quick-access feature cards for market prices, forex rates, and grievance submission.
  - Scroll-triggered animated impact statistic counters (`6000+ FPCTS`, `4500+ AVECs`, `2300+ Plaintes/Feedback`, `800+ Jeunes Entrepreneurs`).
  - Interactive **Leaflet.js** map centered on the Great Lakes cross-border region (Lake Kivu, Goma, Bukavu, Rubavu, Rusizi, Cibitoke) with country-coded pins and styled popups.
  - Flash news and event carousel powered by Alpine.js.
  - Partner showcase (Swiss Confederation, Sweden Sverige, International Alert).
  - Floating smooth-scroll *Back to Top* button.
- **About Page (`/a-propos`)**:
  - Detailed overview of the project's NEXUS methodology (Humanitarian, Development, and Peacebuilding pillars).
  - Branded header banner (`breadcomb.png`) and lightweight breadcrumbs.
- **News & Announcements (`/actualites` & `/actualites/{slug}`)**:
  - Category filters (*Flash*, *Événements*, *Communiqués de presse*).
  - Detailed article view with structured content, thematic warning callouts, and social sharing links (X, LinkedIn, Facebook).

### 2. Authentication & Multi-Country Access Control
- **Flexible Login**: Authenticate using **Email**, **Username**, or **Phone Number**.
- **Role-Based Access Control (RBAC)**: Managed via `spatie/laravel-permission` with dedicated permissions for Super Admins, Country Admins, Data Collectors, Traders, and Viewers.
- **Multi-Country Data Isolation**: `EnsureCountryAccess` middleware enforcing country-level scope with persistent session filters and country switcher.

### 3. Trade & Market Monitoring (`/msl/...`)
- **Daily Commodity Prices**: Track retail and wholesale commodity prices across regional border markets with automated price comparison and trend visualization.
- **Forex & Currency Converter**: Real-time tracking of official and bureau exchange rates with an interactive currency converter tool.
- **Cross-Border Mobility & Border Posts**: Real-time status of border crossings (open, restricted, closed), travel documentation requirements, and local border liaison officers.
- **Grievance & Claims Mechanism**: End-to-end incident submission, categorization (harassment, illegal taxation, delays), status tracking (*Nouveau*, *En cours*, *Résolu*, *Rejeté*), and resolution workflows.
- **Data Collection & Submissions**: Dedicated submission queues and history tracking for field data collectors.
- **Reporting & Export**: Comprehensive trend analytics for commodity price fluctuations, exchange rates, and grievance resolution rates.

### 4. Internationalization & Settings
- **Multilingual Support**: French (`fr`, default), Kiswahili (`sw`), and English (`en`) with runtime language switcher and translated dynamic entities (`HasTranslations` trait).
- **Master Data Management**: Full CRUD for Countries, Currencies, Measurement Units, Commodity Categories, Market Locations, and Document Types.

---

## Technology Stack

| Layer | Technology |
|---|---|
| **Backend Framework** | [Laravel 12.x](https://laravel.com) |
| **Language & Runtime** | [PHP 8.2+](https://php.net) |
| **Authentication** | [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze) (Extended with multi-identifier login) |
| **Authorization & RBAC** | [spatie/laravel-permission](https://spatie.be/docs/laravel-permission) |
| **Frontend Templates** | Laravel Blade Components (`<x-public-layout>`, `<x-msl-layout>`, `<x-breadcrumb>`) |
| **Styling & Design** | [Tailwind CSS](https://tailwindcss.com), [Poppins Font](https://fonts.bunny.net/family/poppins) |
| **JavaScript & Reactivity** | [Alpine.js](https://alpinejs.dev), [Vite 7](https://vitejs.dev) |
| **Mapping Engine** | [Leaflet.js](https://leafletjs.com) with custom OpenStreetMap tiles |
| **Testing** | [PHPUnit 11](https://phpunit.de) (42 test suites, 217 assertions) |
| **Code Formatting** | [Laravel Pint](https://laravel.com/docs/pint) |

---

## Project Structure

```text
msl-app/
├── app/
│   ├── Concerns/              # Shared traits (HasTranslations, ResolvesCountryFilter)
│   ├── Enums/                 # Business enums (BorderStatus, ClaimStatus, etc.)
│   ├── Http/
│   │   ├── Controllers/       # Resource and custom controllers
│   │   ├── Middleware/        # Country access control middleware
│   │   └── Requests/          # Form request validations (e.g. LoginRequest)
│   ├── Models/                # Eloquent models with relationships and translation links
│   ├── Policies/              # Authorization policies
│   ├── Services/              # Domain services (DashboardService, ClaimService, etc.)
│   └── View/Components/       # Blade layout and UI components
├── config/
│   ├── msl.php                # Navigation, sections, and permission mappings
│   └── permission.php         # Spatie RBAC configuration
├── database/
│   ├── migrations/            # Database schema definitions
│   └── seeders/               # Role, permission, country, market, and admin seeders
├── lang/
│   └── fr/                    # French localization files
├── public/
│   └── images/                # Project branding, logos, partner assets, and banners
├── resources/
│   ├── css/                   # Tailwind base styles and map styling
│   ├── js/                    # Alpine.js and client bootstrapping
│   └── views/
│       ├── components/        # Reusable UI components (breadcrumbs, stat-cards, modals)
│       ├── layouts/           # Layout wrappers (public, msl, guest, app)
│       ├── pages/             # Public pages (about, news, news-show)
│       ├── msl/               # Internal modules (commodities, forex, claims, etc.)
│       └── welcome.blade.php  # Public homepage
├── routes/
│   ├── web.php                # Public and authenticated route definitions
│   └── auth.php               # Breeze authentication routes
└── tests/
    └── Feature/               # PHPUnit feature test suite
```

---

## Getting Started

### Prerequisites
- **PHP** >= 8.2 with `pdo`, `mbstring`, `openssl`, `curl`, `gd`, `xml`, and `sqlite3` or `mysql` extensions
- **Composer** (v2.x)
- **Node.js** (v18+) & **npm**

### Installation

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd msl-app
   ```

2. **Install PHP and Node dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Configure the environment file**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run migrations and seed default data**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Build frontend assets**:
   ```bash
   npm run build
   ```

6. **Start the local development server**:
   ```bash
   php artisan serve
   ```
   *Or run Vite and the Laravel server concurrently:*
   ```bash
   npm run dev
   ```

---

## Default Seeded Credentials

When seeded with `MslSeeder`, the following Super Admin user is provisioned:

| Role | Identifier / Email | Password | Access Scope |
|---|---|---|---|
| **Super Admin** | `admin@msl.org` | `password` | Global (All Countries & Modules) |

*Note: You can log in using either the email (`admin@msl.org`), the user name (`Super Admin`), or a registered phone number.*

---

## Running Tests & Quality Checks

### Run Test Suite
```bash
php artisan test --compact
```
*(42 tests, 217 assertions covering public pages, authentication, authorization, filters, and internal modules)*

### Code Formatting with Pint
```bash
vendor/bin/pint
```

---

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
