# NeoHadits

Welcome to **NeoHadits**, a modern, fast, and responsive Hadith collection portal built on PHP and MySQL. The interface features a premium glassmorphic visual style with zero-dependency Vanilla JavaScript interactivity.

---

## 📖 Table of Contents
- [Features](#-features)
- [Project Architecture](#-project-architecture)
- [Database Structure](#-database-structure)
- [Installation and Setup](#-installation-and-setup)
- [Configuration](#-configuration)
- [Key Files](#-key-files)
- [License](#-license)

---

## ✨ Features
- **Comprehensive Collection**: Access collections of Shahih Bukhari, Shahih Muslim, Sunan Abu Daud, Sunan Tarmidzi, Sunan Nasa'i, Sunan Ibnu Majah, Musnad Ahmad, Muwattha' Malik, and Sunan Ar Darimi.
- **Modern Glassmorphic Design**: Clean and responsive visual layout with blur effects, dynamic glowing color accents, customized form inputs, and sleek card components.
- **Dynamic Client-Side Theme Engine**: Switch theme accent colors instantly. The choices are saved into user sessions and applied via CSS custom properties (`--accent-color`) without reload-lag.
- **Zero-Dependency Vanilla JavaScript**: Fully migrated from jQuery to modern ES6+ JS (`fetch` requests, custom animations, and clean modular event loops).
- **Secure Configuration**: Environment variables loaded dynamically via local `.env` configuration (safely excluded from git tracking).

---

## 📂 Project Architecture
The workspace layout is structured as follows:
```text
neohadits/
├── css/
│   ├── neohadits.css          # Glassmorphic UI styles, variables, transitions
│   └── font-awesome.min.css   # Icon framework
├── db/
│   ├── ddl_neohadist.sql      # Schema definitions (CREATE TABLE statements)
│   ├── neohadits.v1.sql       # Full dump including schemas and raw dataset
│   ├── neohadits.v1.zip       # Compressed full sql database dump
│   └── *.sql                  # Individual datasets for tables (data-only inserts)
├── fonts/                     # Local asset font-face resources
├── img/                       # UI graphic assets and preload svg indicator
├── inc/
│   ├── config.php             # System constants, DB connector, and .env parser
│   ├── neohadits_ajax.php     # Server-side AJAX endpoint for Hadith searching
│   └── change.color.php       # Dynamic session state writer for theme colors
├── js/
│   └── neohadits_js.php       # Client-side Vanilla JS controllers and handlers
├── .env                       # Local environment configurations (git-ignored)
├── .gitignore                 # Exclusions configuration file
├── index.php                  # Client application entry point
├── GEMINI.md                  # Project overview documentation
└── README.md                  # Detailed README manual
```

---

## 🗄️ Database Structure

The project separates the raw relational structure from the database contents:
- **Core Schema**: [**`db/ddl_neohadist.sql`**](/db/ddl_neohadist.sql) contains the table definitions, relationships, and structure layout.
- **Split Table Datasets**: The `db/` folder contains individual table data inserts (e.g. [`db/biografi_imam.sql`](/db/biografi_imam.sql), [`db/tema_bukhari.sql`](/db/tema_bukhari.sql), etc.) stripped of schemas for modular imports.

### Initializing the Database
1. Connect to your local MySQL instance.
2. Create a new database:
   ```sql
   CREATE DATABASE neo_hadits CHARACTER SET utf8 COLLATE utf8_general_ci;
   ```
3. Import the main SQL schema dump:
   ```bash
   mysql -u root -p neo_hadits < db/ddl_neohadist.sql
   ```
4. Populate table data using the individual sql logs or import the full consolidated dump:
   ```bash
   mysql -u root -p neo_hadits < db/neohadits.v1.sql
   ```

---

## 🚀 Installation and Setup

### Prerequisites
- PHP 7.4 or later
- MySQL 5.7 / MariaDB 10.3 or later
- Local PHP Web Server environment (e.g., Laragon, XAMPP, or Docker)

### Setup Steps
1. Clone or download the repository into your web server's document root (e.g. `C:\laragon\www\neohadits` or `C:\xampp\htdocs\neohadits`).
2. Copy the `.env.example` configurations or create a new **`.env`** file directly in the root directory:
   ```env
   DB_HOST=localhost
   DB_USER=root
   DB_PASS=your_password
   DB_NAME=neo_hadits
   ```
3. Initialize the database schema and dataset using the guidelines under [Database Structure](#-database-structure).
4. Launch your local web server and open the browser at: `http://localhost/neohadits`.

---

## 🛠️ Configuration

The database loading system uses a built-in environment parser located in [`inc/config.php`](/inc/config.php). The configuration loader will detect the presence of the root [`.env`](/.env) file:
```php
//-- Load .env configuration
if (file_exists(dirname(__DIR__) . '/.env')) {
    $lines = file(dirname(__DIR__) . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    ...
}
```

It maps parameters into `$_ENV` and `getenv()` functions and falls back to standard default parameters if no local environment variables are found.

---

## 📦 Key Files
- [**`index.php`**](/index.php): Manages primary UI rendering, responsive container layouts, preset theme colors, and includes layout templates.
- [**`inc/config.php`**](/inc/config.php): System configuration core, defines application version details, and instantiates the `mysqli` database connection.
- [**`js/neohadits_js.php`**](/js/neohadits_js.php): Fast dynamic asynchronous interactions (theme switching, pagination lists, and instant modal handlers).
- [**`css/neohadits.css`**](/css/neohadits.css): Styling guidelines including customizable CSS root variables.

---

## 🕒 Changelog
All notable changes to the **NeoHadits** codebase are documented below:

[1.0.0] - 2026-08-05
### Refactored UI & UX (Modern Glassmorphic Look)
- **Glassmorphism Redesign**: Replaced the legacy `w3.css` framework with a custom responsive stylesheet [`css/neohadits.css`](/css/neohadits.css), introducing glass backdrop blurs, glowing card outlines, and modernized forms.
- **Dynamic Theme Accents**: Rebuilt the theme selection engine. Preset theme colors now directly target CSS variables (`--accent-color`), eliminating document re-requests. The active theme preset now displays a dynamic highlight state.
- **Dropdown Pill button**: Replaced the standard menu with a rounded pill button featuring an active theme-dot showing the selected color glow.
- **Click Toggling**: Transitioned the dropdown menus from hover-triggers to standard click-toggles that dismiss when clicking outside or toggling other active dropdowns.
- **Simplified Nav Header**: Removed the login button to clean up user navigation.

### Architecture & Scripting (Zero-Dependency Vanilla JS)
- **Vanilla JS Migration**: Refactored the core logic script [`js/neohadits_js.php`](/js/neohadits_js.php) using modern ES6+ features, standard DOM APIs, and the native `fetch` API.
- **Cleaned Dependencies**: Completely deleted the unused `js/jquery.min.js`, `css/w3.css`, and associated color theme stylesheets from the codebase.
- **HTML Cleanup**: Resolved nested `<select>` tagging syntax bugs inside index templates.

### Configuration & Security
- **Credentials Isolation**: Implemented a local [`.env`](/.env) loader inside config files to separate credentials from version-controlled logic.
- **Git Exclusions**: Added a [`.gitignore`](/.gitignore) file to prevent accidental pushes of sensitive parameters.

### Database & DDL Splits
- **Schema Separation**: Extracted table schemas from dataset records into a standalone DDL dump file [`db/ddl_neohadist.sql`](/db/ddl_neohadist.sql).
- **Split Dataset Files**: Divided table dumps into individual data-only INSERT SQL logs under the [`db/`](/db) directory, stripping database schemas from dataset inserts.

---

## 📄 License
This application is distributed under the terms of the GNU General Public License (GPL) version 2 or later. See standard GPL header documentation in source files for details.
