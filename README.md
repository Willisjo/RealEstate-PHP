# RealEstate-PHP

A real estate property listing system built with **PHP** and **MySQL**, with a public site for
visitors and a separate admin panel for managing content.

Originally a learning project by Suraj Kumar Vishwakarma (CodeAstro), shared here as-is.

## Features

**Public site**
- Browse properties by grid / state, with property detail pages and image galleries
- Advanced property search and a mortgage/EMI calculator
- Agent listing, about, contact and feedback pages
- User registration, login and profile management
- Logged-in users can submit, edit and delete their own property listings

**Admin panel** (`/admin`)
- Dashboard with charts and statistics
- Manage properties, states, cities, agents and builders
- Manage user accounts and administrators
- Manage about page content, contact messages and feedback

## Requirements

- PHP 7.4+ (built for PHP 5.6 / 7.4)
- MySQL or MariaDB
- Apache (XAMPP / WAMP / Laragon)

## Setup

1. Copy the project folder into your web server root, e.g. `C:\xampp\htdocs\RealEstate-PHP`.
2. Start Apache and MySQL.
3. Create a database named `realestatephp` and import `DATABASE FILE/realestatephp.sql`
   (phpMyAdmin → Import, or `mysql -u root realestatephp < "DATABASE FILE/realestatephp.sql"`).
4. If your database credentials differ from the defaults, edit `config.php` and `admin/config.php`.
5. Open `http://localhost/RealEstate-PHP/` for the site and
   `http://localhost/RealEstate-PHP/admin/` for the admin panel.

Default database connection: host `localhost`, user `root`, empty password.

## Demo admin login

| Field    | Value             |
| -------- | ----------------- |
| Email    | `admin@gmail.com` |
| Password | `admin`           |

Registration for regular users and agents is available from the public site.

## Project structure

```
├── admin/            Admin panel (CRUD pages, assets, uploads)
├── css/ js/ fonts/   Public site styles, scripts and icon fonts
├── images/           Public site images
├── include/          Shared header and footer
├── DATABASE FILE/    MySQL dump (realestatephp.sql)
├── *.php             Public pages (index, property, login, register, ...)
└── config.php        Database connection
```

## Notes

- Uploaded property images are stored under `admin/property/` and `admin/user/`.
- The site is written with procedural `mysqli` and inline SQL; it is a demo/learning project and
  is not hardened for production use.
