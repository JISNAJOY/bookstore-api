# Bookstore API - Symfony Version

This is the **Symfony (PHP) implementation** of the Bookstore REST API project.  
It provides full **CRUD operations** for managing books.

---

##  Tech Stack
- Symfony 6 (PHP framework)
- Doctrine ORM (database layer)
- Serializer Component (JSON responses)
- SQLite/MySQL (configurable in `.env`)

---

## Installation

1. Clone the repo and go to Symfony folder:
```bash
cd symfony-version
```
2. Install dependencies:
```bash
composer install
```
3. Configure database in .env file:
For SQLite (default):

DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"

For MySQL:

DATABASE_URL="mysql://user:password@127.0.0.1:3306/bookstore"

4. Create and run migrations:
```bash
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```
Run Server
If you have Symfony CLI:
```bash
symfony server:start

```
If not, run with PHP built-in server:
```bash
php -S 127.0.0.1:8000 -t public

```
API will be available at:
 http://127.0.0.1:8000/books

Populate Demo Data
To insert some initial book entries, run:
```bash
php add_books.php
```
## API Endpoints
| Method | Endpoint      | Description      |
| ------ | ------------- | ---------------- |
| GET    | `/books`      | Fetch all books  |
| GET    | `/books/{id}` | Fetch book by ID |
| POST   | `/books`      | Create new book  |
| PUT    | `/books/{id}` | Update book      |
| DELETE | `/books/{id}` | Delete book      |

Example Book JSON
{
  "title": "The Pragmatic Programmer",
  "author": "Andrew Hunt",
  "year": 1999,
  "price": 19.99
}

Features

Clean RESTful structure
JSON request/response format
Database migrations with Doctrine
Easy setup with Symfony + Composer
