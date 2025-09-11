# Task Manager – Laravel API + Vue 3 Frontend

A modern full-stack task management application built to showcase professional development skills with **Laravel 12** (API) and **Vue 3** (frontend). Features secure authentication, real-time task management, and data visualization.

## ✨ Features

### 🔐 Authentication & Security
- **User Registration & Login** with Laravel Sanctum
- **Sanctum Personal Access Tokens** (stateless API tokens)
- **Password Hashing** with bcrypt
- **Input Validation** on all endpoints
- **CORS Configuration** for secure cross-origin requests
- **Authorization** - Users can only access their own tasks

### 📋 Task Management
- **Create, Read, Update, Delete** tasks
- **Real-time Status Toggle** (pending ↔ done)
- **Task Validation** and error handling
- **Responsive Task List** with modern UI

### 📊 Data Visualization
- **Interactive Chart.js pie chart** showing task status distribution
- **Real-time Updates** when tasks change
- **Chart.js Integration** for professional data visualization

### 🎨 User Experience
- **Responsive Design**
- **Loading States** and error handling
- **Modern UI Components** with hover effects
- **Mobile-friendly** interface
- **Clean, Professional Layout**

## 🛠 Tech Stack

### Backend
- **Laravel 12** - Latest PHP framework
- **Laravel Sanctum 4.2** - API authentication
- **PHP 8.2+** - Modern PHP with latest features
- **SQLite** - Lightweight database for development
- **Eloquent ORM** - Database abstraction layer

### Frontend
- **Vue 3.5.18** - Latest Vue.js with Composition API
- **TypeScript** - Type-safe JavaScript
- **Vite** - Fast build tool and dev server
- **Vue Router 4** - Client-side routing
- **Axios** - HTTP client for API communication
- **Chart.js 4.4** - Data visualization library

### Development Tools
- **ESLint** - Code linting
- **Prettier** - Code formatting
- **Vitest** - Unit testing (can be added)
- **Playwright** - E2E testing (can be added)

## 🚀 Getting Started

### Prerequisites
- **PHP 8.2+** with Composer
- **Node.js 20.19.0+** with npm
- **Git** for version control

### Installation & Setup

#### 1. Clone the Repository
```powershell
cd "C:\DEV"
git clone https://github.com/GeoffAAA/laravel-vue-task-manager.git
cd "laravel-vue-task-manager"
```

#### 2. Backend Setup (Laravel API)
```powershell
cd tasks-api
copy .env.example .env

# Create SQLite database file (default DB in this repo)
New-Item -ItemType File -Path ".\database\database.sqlite" -Force | Out-Null

composer install --no-interaction --prefer-dist
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
**API Server:** http://localhost:8000

#### 3. Frontend Setup (Vue 3)
```powershell
cd ..\tasks-frontend
npm ci
npx vite
```
**Frontend Server:** http://localhost:5173

> API base URL is configured in `tasks-frontend/src/axios.js` as `http://localhost:8000/api`. If you change API port/host, update it there or use an environment variable approach.

### macOS Setup (Alternative)

#### 1. Clone the Repository
```bash
cd "$HOME/Dev"
git clone https://github.com/GeoffAAA/laravel-vue-task-manager.git
cd laravel-vue-task-manager
```

#### 2. Backend Setup (Laravel API)
```bash
cd tasks-api
cp .env.example .env

# Create SQLite database file (default DB in this repo)
mkdir -p database
touch database/database.sqlite

composer install --no-interaction --prefer-dist
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

#### 3. Frontend Setup (Vue 3)
```bash
cd ../tasks-frontend
npm ci
npx vite
```

### 🎯 Usage Guide

1. **Register** a new account or **Login** with existing credentials
2. **Create Tasks** using the "Add New Task" form
3. **Toggle Status** between pending and done by clicking the status indicator
4. **Delete Tasks** using the delete button (with confirmation)
5. **View Analytics** in the interactive pie chart
6. **Logout** when finished

### 🔧 Development Commands

#### Backend
```bash
cd tasks-api
php artisan serve          # Start development server
php artisan migrate        # Run database migrations
php artisan migrate:fresh   # Reset database
composer audit            # Check for security vulnerabilities
```

#### Frontend
```bash
cd tasks-frontend
npx --yes vite            # Start development server
npx --yes vite build      # Build for production
npx --yes npm audit       # Check for security vulnerabilities
npx --yes npm run lint    # Run code linting
```

## 📡 API Documentation

### Authentication Endpoints
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| `POST` | `/api/register` | Register new user | ❌ |
| `POST` | `/api/login` | Login user | ❌ |
| `POST` | `/api/logout` | Logout user | ✅ |

### Task Management Endpoints
| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| `GET` | `/api/tasks` | Get user's tasks | ✅ |
| `POST` | `/api/tasks` | Create new task | ✅ |
| `PUT` | `/api/tasks/{id}` | Update task | ✅ |
| `DELETE` | `/api/tasks/{id}` | Delete task | ✅ |

### Request/Response Examples

#### Register User
```json
POST /api/register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}

Response:
{
  "token": "1|abc123...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

#### Create Task
```json
POST /api/tasks
Authorization: Bearer 1|abc123...

{
  "title": "Complete project documentation"
}

Response:
{
  "id": 1,
  "title": "Complete project documentation",
  "status": "pending",
  "user_id": 1,
  "created_at": "2024-01-15T10:30:00.000000Z",
  "updated_at": "2024-01-15T10:30:00.000000Z"
}
```

## 🔒 Security Features

- **JWT Token Authentication** - Stateless, secure API access
- **Password Hashing** - bcrypt encryption for user passwords
- **Input Validation** - Server-side validation on all endpoints
- **CORS Protection** - Configured for secure cross-origin requests
- **Authorization** - Users can only access their own data
- **SQL Injection Protection** - Eloquent ORM prevents SQL injection
- **XSS Protection** - No raw HTML rendering in Vue components

## 🏗️ Architecture

### Backend (Laravel)
- **MVC Pattern** - Models, Views (API responses), Controllers
- **RESTful API** - Standard HTTP methods and status codes
- **Middleware** - Authentication, CORS, and request handling
- **Database Migrations** - Version-controlled database schema
- **Eloquent ORM** - Object-relational mapping for database operations

### Frontend (Vue 3)
- **Component-Based Architecture** - Reusable, modular components
- **Composition API** - Modern Vue 3 reactive system
- **Vue Router** - Client-side routing and navigation guards
- **Axios Interceptors** - Automatic token attachment and error handling
- **Reactive State Management** - Real-time UI updates

## 🚀 Deployment

### Production Considerations
- **Environment Variables** - Move sensitive data to `.env` files
- **HTTPS** - Use SSL certificates for secure communication
- **Database** - Switch from SQLite to PostgreSQL/MySQL
- **Caching** - Implement Redis for session and data caching
- **Rate Limiting** - Add API rate limiting for production
- **Monitoring** - Set up logging and error tracking

### Build Commands
```bash
# Frontend Production Build
cd tasks-frontend
npx --yes vite build

# Serve through Laravel (optional)
# Copy dist/ contents to tasks-api/public/app/
```

## 📝 Project Structure

```
Laravel API + Vue 3 Frontend/
├── tasks-api/                 # Laravel Backend
│   ├── app/
│   │   ├── Http/Controllers/  # API Controllers
│   │   └── Models/           # Eloquent Models
│   ├── database/migrations/   # Database Schema
│   ├── routes/api.php        # API Routes
│   └── config/               # Configuration Files
├── tasks-frontend/           # Vue 3 Frontend
│   ├── src/
│   │   ├── components/       # Vue Components
│   │   ├── views/           # Page Components
│   │   ├── router/          # Vue Router Config
│   │   └── axios.js         # API Client
│   └── package.json         # Dependencies
└── README.md                # This file
```

## 🎯 Demo Purpose

This project demonstrates:
- **Full-Stack Development** - Complete API + SPA application
- **Modern Frameworks** - Latest Laravel 12 and Vue 3
- **Security Best Practices** - Authentication, validation, CORS
- **Professional UI/UX** - Responsive design with Tailwind CSS
- **Data Visualization** - Chart.js integration
- **Type Safety** - TypeScript implementation
- **Development Workflow** - Modern tooling and best practices

Perfect for showcasing professional web development skills to potential employers or clients!
