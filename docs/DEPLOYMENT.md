# Deployment Guide

This project is a Laravel app with server-rendered Blade views and Vite assets.

## 1) Required Environment Variables

Set these values in production:

- APP_ENV=production
- APP_DEBUG=false
- APP_URL=https://your-domain.com
- APP_KEY=base64:... (generate with php artisan key:generate --show)
- DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
- SESSION_DRIVER=database
- CACHE_STORE=database
- QUEUE_CONNECTION=database

## 2) Server Requirements

- PHP 8.2+
- Composer
- Node.js 18+ and npm
- MySQL or PostgreSQL (recommended for production)
- Web server (Nginx or Apache)

## 3) Production Build Steps

Run these commands on the server:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

If your deployment flow already runs seeders elsewhere, skip db:seed.

## 4) File and Folder Permissions

Ensure web server can write to:

- storage/
- bootstrap/cache/

## 5) Security Checklist

- Change default admin password immediately.
- Use HTTPS only.
- Disable debug mode.
- Review CORS and trusted proxy settings if behind a load balancer.

## 6) Suggested First Login

After deployment:

- Log in as admin.
- Verify products and stock values.
- Create a normal user and test full cart -> checkout flow.
- Confirm order status updates from admin panel.

## 7) Useful Commands

```bash
php artisan optimize:clear
php artisan test
php artisan storage:link
```
