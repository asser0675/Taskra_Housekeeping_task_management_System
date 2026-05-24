# HKPmanagement

Simple hotel/staff management application built with Laravel, Tailwind and Vite.

**Contents**
- **Setup**: install deps and start the app
- **Features**: what the app provides
- **Usage**: common developer commands
- **DB schema**: main tables and fields

**Setup**

- Requirements: PHP 8.x, Composer, MySQL or MariaDB (or other supported DB), Node.js (16+), npm or pnpm
- Copy the example env and configure database credentials:

  1. Copy `.env.example` to `.env` and update DB settings
 2. Install PHP dependencies:

```
composer install
```

3. Install frontend dependencies and build assets:

```
npm install
# dev
npm run dev
# or production build
npm run build
```

4. Generate app key, run migrations and seeders:

```
php artisan key:generate
php artisan migrate
php artisan db:seed
```

5. Start development server:

```
php artisan serve
```

**Features**

- User authentication and seeding
- Room management
- Task assignment and tracking for staff
- Issue reporting and tracking
- Hotel settings configuration
- Admin/staff views and basic UI components using Tailwind

**Usage (developer)**

- Run tests (Pest/PHPUnit):

```
./vendor/bin/pest
```

- Run a single test file or feature suite via Pest/PhpUnit as needed.

- Common artisan tasks:

```
php artisan migrate:fresh --seed
php artisan tinker
```

**Database / Schema (overview)**

The project keeps migrations in `database/migrations`. Key tables include:

- `users` — id, name, email, password, role, created_at, updated_at
- `rooms` — id, number, type, status, notes, created_at, updated_at
- `tasks` — id, title, description, room_id, assigned_to (user_id), status, due_at, created_at, updated_at
- `issues` — id, title, description, room_id, reported_by (user_id), status, created_at, updated_at
- `hotel_settings` — id, key, value, created_at, updated_at

See the `database/migrations` folder for precise column definitions and types.

**Useful paths**

- Migrations: `database/migrations`
- Seeders: `database/seeders`
- Models: `app/Models`
- Controllers: `app/Http/Controllers`
- Views: `resources/views`

**Notes**

- Adjust `.env` DB credentials before running migrations. If using Docker, map DB ports appropriately.
- If you need a more detailed ERD or exact column list, I can extract the full schema from the migrations and add it here.

---
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>    