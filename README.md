# SemBark ShortUrl

---

# Requirements

Before setup, make sure you have installed:

* PHP >= 8.x
* Composer
* Node.js & NPM
* MySQL

---

# Project Setup

## 1. Setup Environment File

Rename `.env.example` to `.env`

### Linux / Mac

```bash
cp .env.example .env
```

### Windows

```bash
copy .env.example .env
```

---

## 2. Install Composer Dependencies

```bash
composer install
```

---

## 3. Install NPM Dependencies

```bash
npm install
npm run dev
```

---

## 4. Generate Application Key

```bash
php artisan key:generate
```

---

## 5. Configure Database

Update your database credentials inside `.env`

```env
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

---

## 6. Run Database Migration

```bash
php artisan migrate
```

---

## 7. Run Database Seeder

```bash
php artisan db:seed
```

---

# Super Admin Credentials

| Email                                                   | Password       |
| ------------------------------------------------------- | -------------- |
| [superadmin@sembark.com](mailto:superadmin@sembark.com) | sembark@123456 |

---

# Run Queue Worker

Queue worker is required for email jobs.

```bash
php artisan queue:work
```

---

# Run Development Server

```bash
php artisan serve
```

---

# Useful Commands

## Clear Cache

```bash
php artisan optimize:clear
```

## Retry Failed Jobs

```bash
php artisan queue:retry all
```

## View Failed Jobs

```bash
php artisan queue:failed
```

---

# Tech Stack

* Laravel
* MySQL
* Bootstrap
* JavaScript / jQuery
* Queue Jobs
* Vite

---

# Notes

* Make sure MySQL server is running before migration.
* Queue worker must remain active for email functionality.
* If frontend assets are missing, run:

```bash
npm run build
```

---
