
# 🧾 Laravel Invoice Generator

A Laravel application to generate invoices dynamically with client details, items, totals, and downloadable PDFs. Ideal for freelancers and small businesses to automate invoice creation.

---

## ✨ Features

- 🧍 Add client info and billing details.
- 📦 Add invoice line items dynamically.
- 📄 Export invoice as PDF.
- 🧾 Automatic tax and total calculations.

---

## 🚀 Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/salmanpatnee/Laravel_Invoice_Generator.git
cd Laravel_Invoice_Generator
```

### 2. Install dependencies

```bash
composer install
```

### 3. Setup environment

- Copy `.env.example` to `.env`
- Set your database details

```bash
php artisan key:generate
php artisan migrate
```

### 4. Serve the application

```bash
php artisan serve
```

---

## 🛠️ Tech Stack

- 🧱 Laravel 8+
- 📄 DomPDF (for PDF generation)
- 🗃️ MySQL

---

## 📄 License

MIT License

---

## 👤 Author

**Salman Patnee**  
- GitHub: [@salmanpatnee](https://github.com/salmanpatnee)
