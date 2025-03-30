# Animal Bite Management System

## Overview
This project is a full-stack web application utilizing **Nuxt** for the frontend, **Bun** as the package manager and runtime, **DaisyUI with Tailwind CSS** for styling, and **Laravel** for the backend.

## Technologies Used
### Frontend:
- [**Nuxt3**](https://nuxt.com/) - Vue-based framework for SSR and SSG.
- [**Bun**](https://bun.sh/) - Fast JavaScript runtime and package manager.
- [**DaisyUI**](https://daisyui.com/) - UI component library built on Tailwind CSS.
- [**Tailwind CSS**](https://tailwindcss.com/) - Utility-first CSS framework.
- [**Lucide Vue Next**](https://lucide.dev/guide/packages/lucide-vue-next) - Lucide icon library for Vue 3 applications.

### Backend:
- [**Laravel**](https://laravel.com/) - PHP framework for building APIs.
- [**MySQL**](https://www.mysql.com/) - Database for storing application data.

## Getting Started

### Prerequisites
Ensure you have the following installed on your system:
- [Bun](https://bun.sh/)
- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [MySQL](https://www.mysql.com/)

### Setup

#### Frontend (Nuxt + Bun)
```sh
# Clone the repository
git clone https://github.com/y3eet/animal-bite-management-system.git
cd animal-bite-management-system/frontend

# Install dependencies using Bun
bun install

# Start development server
bun run dev
```

#### Backend (Laravel)
```sh
cd ../backend

# Install dependencies
composer install

# Copy environment variables
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env file
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# Run migrations
php artisan migrate

# Start the development server
php artisan serve

# Seed database
php artisan db:seed
php artisan db:seed --class=PatientSeeder
```
