# Route Map

This document summarizes the main routes in the project.

## Public and Auth Routes

| Method | URI | Name | Access |
|---|---|---|---|
| GET | / | - | Redirect to login |
| GET | /login | login | Guest |
| POST | /login | - | Guest |
| POST | /logout | logout | Authenticated |
| GET | /register | register | Guest |
| POST | /register | - | Guest |
| GET | /forgot-password | password.request | Guest |
| POST | /forgot-password | password.email | Guest |
| GET | /reset-password/{token} | password.reset | Guest |
| POST | /reset-password | password.store | Guest |
| GET | /verify-email | verification.notice | Authenticated |
| GET | /verify-email/{id}/{hash} | verification.verify | Authenticated |
| POST | /email/verification-notification | verification.send | Authenticated |

## User Routes

| Method | URI | Name | Access |
|---|---|---|---|
| GET | /products | products.index | Authenticated |
| GET | /products/{product} | products.show | Authenticated |
| GET | /cart | cart.index | Authenticated |
| POST | /cart/{product}/add | cart.add | Authenticated |
| PATCH | /cart/{product} | cart.update | Authenticated |
| DELETE | /cart/{product} | cart.remove | Authenticated |
| GET | /checkout | checkout.index | Authenticated |
| POST | /checkout | checkout.store | Authenticated |
| POST | /orders/{order}/reorder | orders.reorder | Authenticated |
| GET | /profile | profile.edit | Authenticated |
| PATCH | /profile | profile.update | Authenticated |
| DELETE | /profile | profile.destroy | Authenticated |

## Admin Routes

| Method | URI | Name | Access |
|---|---|---|---|
| GET | /dashboard | dashboard | Authenticated + Verified + Admin |
| GET | /orders | orders.index | Authenticated + Admin |
| PATCH | /orders/{order}/status | orders.update-status | Authenticated + Admin |
| GET | /products/create | products.create | Authenticated + Admin |
| POST | /products | products.store | Authenticated + Admin |
| GET | /products/{product}/edit | products.edit | Authenticated + Admin |
| PUT/PATCH | /products/{product} | products.update | Authenticated + Admin |
| DELETE | /products/{product} | products.destroy | Authenticated + Admin |

## Notes

- The dashboard is intentionally admin-only.
- Product listing and details are available to all authenticated users.
- Checkout uses cash on delivery.
