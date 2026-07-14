# Bookstore

A full-featured online bookstore built with Laravel, featuring book browsing, a shopping cart, Stripe-powered checkout, order tracking, and a full admin panel.

## Features

- **Catalog** — browse books by category, search by title/author, view book details.
- **Cart & checkout** — add books to cart and pay via Stripe.
- **Orders** — customers can view their order history; each order moves through `pending → paid → shipped → delivered`, or can be `cancelled` (which automatically restores stock).
- **Reviews** — customers can rate and comment on books.
- **Authentication & roles** — separate `admin` and `customer` roles.
- **Admin panel** — manage books, categories, orders, and users from a dedicated dashboard.

## Tech stack

- PHP 8.2+ / Laravel 11
- MySQL
- Stripe (`stripe/stripe-php`) for payments
- Tailwind CSS + Vite for the front end
- GD extension for generated placeholder book covers

## Local setup

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate
```

Update `.env` with your local database credentials (`DB_*`), then:

```bash
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

Visit `http://127.0.0.1:8000`.

### Seeded accounts

| Role     | Email                       | Password   |
|----------|------------------------------|------------|
| Admin    | admin@suzanajaneva.com       | `password` |
| Customer | customer@example.com         | `password` |

### Stripe

Set `STRIPE_KEY` and `STRIPE_SECRET` in `.env` with test keys from your [Stripe dashboard](https://dashboard.stripe.com/test/apikeys). If left blank/placeholder, checkout falls back to a dev mode that skips payment.

## Deployment

Live at [bookstore.suzanajaneva.com](https://bookstore.suzanajaneva.com), served via nginx + PHP-FPM on Ubuntu, with SSL via Let's Encrypt.
