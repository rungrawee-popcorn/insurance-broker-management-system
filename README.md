# Insurance Broker Management System (IBMS)

## Project Overview

Insurance Broker Management System (IBMS) is a web-based application designed to manage insurance broker operations.

The system helps manage customers, insurance companies, insurance policies, renewals, dashboards, reports, and export functionality.

The project focuses on CRUD operations, authentication, searching, reporting, and document export features.

---

# Tech Stack

## Backend

- Laravel 13
- PHP 8.3
- Laravel Breeze
- Eloquent ORM
- Middleware

## Frontend

- Blade Template
- Tailwind CSS
- JavaScript
- AJAX
- Chart.js

## Database

- MySQL

## Packages

- maatwebsite/excel
- barryvdh/laravel-dompdf

---

# Features

## Authentication

- User registration
- Login / Logout
- Password management
- Profile management

---

# Customer Management

Features:

- Create customer
- View customer list
- Update customer information
- Delete customer
- Search customer
- Form validation
- Soft delete support

---

# Insurance Company Management

Features:

- Create insurance company
- View company information
- Update company information
- Delete company
- Form validation
- Soft delete support

---

# Policy Management

Features:

- Create insurance policy
- View policy details
- Update policy information
- Delete policy
- Search policy
- Filter policy status
- Policy renewal functionality

Policy status:

- Active
- Expired
- Expiring

---

# Dashboard

Dashboard provides summary information:

- Total customers
- Total companies
- Total policies
- Policy status summary
- Insurance data overview

---

# Reporting System

## Customer Report

Features:

- Customer summary
- Customer searching
- Export report

Export formats:

- Excel
- PDF

## Policy Report

Features:

- Policy summary
- Policy status chart
- Policy searching
- Export report

Export formats:

- Excel
- PDF

---

# Export System

## Excel Export

Implemented using:

- Laravel Excel (maatwebsite/excel)

Supported exports:

- Customer Report
- Policy Report

## PDF Export

Implemented using:

- Laravel DomPDF

Supported exports:

- Customer Report
- Policy Report

---

# Database Features

Implemented:

- Eloquent relationships
- Foreign key relationships
- Soft Delete
- Data validation
- Relational data management

---

# Installation

## 1. Clone Repository

```bash
git clone https://github.com/rungrawee-popcorn/insurance-broker-management-system.git
```

Go to project folder:

```bash
cd insurance-broker-management-system
```

---

## 2. Install Dependencies

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

---

## 3. Environment Setup

Copy environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

## 4. Database Configuration

Update `.env` file:

```
DB_DATABASE=ibms
DB_USERNAME=root
DB_PASSWORD=
```

---

## 5. Run Migration

```bash
php artisan migrate
```

---

## 6. Run Application

Start Laravel server:

```bash
php artisan serve
```

Start Vite development server:

```bash
npm run dev
```

Open:

```
http://127.0.0.1:8000
```

---

# Main Routes

```
/dashboard

/customers

/companies

/policies

/reports/customers

/reports/policies
```
