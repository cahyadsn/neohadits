# NeoHadits Project Documentation

Welcome to **NeoHadits**, a PHP and MySQL based Hadith collection application.

## Table of Contents
- [Overview](#overview)
- [Project Structure](#project-structure)
- [Environment Variables](#environment-variables)
- [Database Schema](#database-schema)
- [Installation and Configuration](#installation-and-configuration)
- [Key Files](#key-files)
- [License](#license)

## Overview
**NeoHadits** is a modern, responsive web-based portal to view and search various collections of Hadiths. The supported collections include:
- Shahih Bukhari
- Shahih Muslim
- Sunan Abu Daud
- Sunan Tarmidzi
- Sunan Nasa'i
- Sunan Ibnu Majah
- Musnad Ahmad
- Muwattha' Malik
- Sunan Ar Darimi

## Project Structure
The repository structure is outlined below:
- **`css/`** - Frontend stylesheets containing the custom glassmorphism system:
  - [`css/neohadits.css`](file:///D:/laragon/repo/dev/neohadits/css/neohadits.css) (Core responsive glassmorphism styles and theme definitions)
  - [`css/font-awesome.min.css`](file:///D:/laragon/repo/dev/neohadits/css/font-awesome.min.css) (Icon library)
- **`db/`** - Database schema definition files:
  - [`neohadits.v1.sql`](file:///D:/laragon/repo/dev/neohadits/db/neohadits.v1.sql) (SQL dump)
  - `neohadits.v1.zip` (Compressed SQL dump)
- **`fonts/`** - Typography files.
- **`img/`** - Icons, preloader images, and graphics.
- **`inc/`** - Core backend inclusions, including:
  - [`inc/config.php`](file:///D:/laragon/repo/dev/neohadits/inc/config.php) (Database connection and environment loader)
  - [`inc/neohadits_ajax.php`](file:///D:/laragon/repo/dev/neohadits/inc/neohadits_ajax.php) (AJAX endpoint handling query processing)
  - [`inc/change.color.php`](file:///D:/laragon/repo/dev/neohadits/inc/change.color.php) (Theme selection state storage)
- **`js/`** - Client-side scripts:
  - [`js/neohadits_js.php`](file:///D:/laragon/repo/dev/neohadits/js/neohadits_js.php) (Pure Vanilla JS event handlers, fetch AJAX, and active dynamic theme logic)
- **`index.php`** - Main UI entry point styled in modern glassmorphic look.
- **`.env`** - Project environment file for sensitive credentials (git-ignored).
- **`.gitignore`** - Git configuration to ignore credentials/local environmental configurations.
- **`README.md`** - General repository details.

## Environment Variables
Database credentials are managed dynamically via a local [`.env`](file:///D:/laragon/repo/dev/neohadits/.env) file located in the root of the project:
```env
DB_HOST=localhost
DB_USER=root
DB_PASS=your_password
DB_NAME=neo_hadits
```

## Database Schema
The schema is stored in [`neohadits.v1.sql`](file:///D:/laragon/repo/dev/neohadits/db/neohadits.v1.sql) under the [`db/`](file:///D:/laragon/repo/dev/neohadits/db) folder.
To import the database:
1. Create a MySQL database named `neo_hadits` (or your preferred name).
2. Import the SQL file:
   ```bash
   mysql -u root -p neo_hadits < db/neohadits.v1.sql
   ```

## Installation and Configuration
1. Clone or download this repository to your PHP server document root (e.g., Laragon or XAMPP).
2. Create your own [`.env`](file:///D:/laragon/repo/dev/neohadits/.env) file in the root directory based on the environment variables guide above.
3. Open your browser and navigate to the project directory (e.g., `http://localhost/neohadits`).

## Key Files
- [`index.php`](file:///D:/laragon/repo/dev/neohadits/index.php) - Main entry page handles UI components, dynamic theme styling, and view routing.
- [`inc/config.php`](file:///D:/laragon/repo/dev/neohadits/inc/config.php) - Loads environmental configurations, manages application limits/constants, and initializes database connection via `mysqli`.
- [`js/neohadits_js.php`](file:///D:/laragon/repo/dev/neohadits/js/neohadits_js.php) - Vanilla JS script providing fast data fetches and UI interactions without external dependencies.
