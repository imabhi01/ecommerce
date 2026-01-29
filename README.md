# Learn Grow Digital - E-Commerce Platform

> A modern, full-featured e-commerce platform built with Laravel 11, Tailwind CSS, and Docker. Featuring automated CI/CD deployments and enterprise-grade architecture.

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://docker.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)


## 🌐 Live Demo


**Production Site:** [https://learngrowdigital.co.uk](https://learngrowdigital.co.uk)

---

## 📖 About

Learn Grow Digital is a comprehensive e-commerce solution designed for modern online retail. Built with cutting-edge technologies and best practices, it provides a robust foundation for selling products online with features like product management, shopping cart, secure checkout, and order tracking.

### Why This Project?

- **Modern Stack**: Laravel 11 + Tailwind CSS + Alpine.js
- **Containerized**: Fully Dockerized for consistent environments
- **Automated Deployments**: CI/CD with GitHub Actions
- **Production Ready**: SSL/HTTPS, optimized assets, caching
- **Scalable Architecture**: Microservices-ready design
- **Developer Friendly**: Clean code, well-documented, easy to extend

---

## ✨ Features

### 🛍️ Customer Features

- **Product Browsing**
  - Browse products by category
  - Advanced search and filtering
  - Product details with images and descriptions
  - Related product recommendations

- **Shopping Experience**
  - Add to cart functionality
  - Real-time cart updates
  - Wishlist management
  - Product reviews and ratings

- **Checkout Process**
  - Secure checkout flow
  - Multiple payment options (ready for integration)
  - Order confirmation emails
  - Guest checkout support

- **Account Management**
  - User registration and authentication
  - Order history
  - Profile management
  - Address book

### 👨‍💼 Admin Features

- **Dashboard**
  - Sales analytics and reports
  - Real-time order notifications
  - Inventory tracking
  - Customer insights

- **Product Management**
  - CRUD operations for products
  - Category management
  - Image uploads
  - Bulk operations

- **Order Management**
  - Order processing workflow
  - Status updates
  - Invoice generation
  - Shipping management

### 🔧 Technical Features

- **Performance**
  - Optimized database queries
  - Asset minification and bundling
  - Browser caching
  - CDN-ready

- **Security**
  - HTTPS/SSL encryption
  - CSRF protection
  - XSS prevention
  - SQL injection protection
  - Secure password hashing

- **DevOps**
  - Docker containerization
  - Automated CI/CD pipeline
  - Zero-downtime deployments
  - Health monitoring

- **Developer Experience**
  - Hot module replacement (HMR)
  - Code linting and formatting
  - Git hooks for quality checks
  - Comprehensive error logging

---

## 🛠️ Technology Stack

### Backend

| Technology | Version | Purpose |
|------------|---------|---------|
| **Laravel** | 11.x | PHP Framework - MVC architecture |
| **PHP** | 8.3 | Server-side language |
| **MySQL** | 8.0 | Relational database |
| **Composer** | 2.x | PHP dependency management |

### Frontend

| Technology | Version | Purpose |
|------------|---------|---------|
| **Tailwind CSS** | 3.x | Utility-first CSS framework |
| **Alpine.js** | 3.x | Lightweight JavaScript framework |
| **Vite** | 5.x | Frontend build tool & bundler |
| **Blade** | - | Laravel templating engine |

### Infrastructure

| Technology | Version | Purpose |
|------------|---------|---------|
| **Docker** | Latest | Containerization |
| **Docker Compose** | Latest | Multi-container orchestration |
| **Apache** | 2.4 | Web server (in container) |
| **GitHub Actions** | - | CI/CD pipeline |
| **Certbot** | Latest | SSL certificate management |

### Development Tools

- **NPM** - Node.js package manager
- **Git** - Version control
- **PHPUnit** - PHP testing framework
- **Laravel Pint** - Code style fixer
- **Laravel Debugbar** - Development debugging

---

## 📋 Prerequisites

### Required Software

#### For Local Development
- **Docker Desktop** (v20.10+)
  - Download: [docker.com/products/docker-desktop](https://docker.com/products/docker-desktop)
- **Git** (v2.30+)
  - Download: [git-scm.com](https://git-scm.com)
- **Node.js** (v20.x LTS) & NPM
  - Download: [nodejs.org](https://nodejs.org)
- **Composer** (v2.x)
  - Download: [getcomposer.org](https://getcomposer.org)

#### For Production Deployment
- **Linux Server** (Ubuntu 22.04+ or Debian 11+)
- **Domain Name** with DNS configured
- **SSH Access** to server
- **Minimum Server Requirements**:
  - 2 CPU cores
  - 4GB RAM
  - 20GB SSD storage
  - Ubuntu 22.04 LTS

### Optional Tools
- **TablePlus** or **MySQL Workbench** - Database management
- **Postman** - API testing
- **VS Code** - Code editor (with recommended extensions)

---

## 🚀 Installation & Setup

### Method 1: Local Development (Non-Docker)

Perfect for quick development and testing.

#### Step 1: Clone Repository
```bash