# 🧱 Task Management API – Laravel Application

A simple yet powerful **Task Management REST API** built with **Laravel**, featuring **role-based access control (RBAC)** using **Spatie Laravel Permission**.

---

## 🚀 Features

- 🔐 **Authentication** via Laravel Sanctum  
- 👥 **Role-based authorization** using **Spatie Permissions**
  - **Manager**: Full control (view, create, update, delete all tasks)
  - **User**: Can only view their own tasks and update their task status
- 🧩 **Tasks API** with parent–child relationships
- 🗂️ **Auto-generated API documentation** available at `/docs`
- 📦 **Postman collection** included for quick testing

---

## ⚙️ Installation & Setup

Follow these steps to set up the project locally.

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/yourusername/task-manager.git
cd task-manager
```

### 2️⃣ Install Dependencies

```bash
composer install
```

### 3️⃣ Environment Setup

Copy the example environment file and generate an app key:

```bash
cp .env.example .env
php artisan key:generate
```

> 📝 Make sure to update your `.env` file with your database credentials.

**Example `.env` setup:**
```env
APP_NAME="TaskManager"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=

SANCTUM_STATEFUL_DOMAINS=localhost
SESSION_DOMAIN=localhost
```

---

### 4️⃣ Run Database Migrations

```bash
php artisan migrate
```

---

### 5️⃣ Seed Initial Data

Seed the database with demo roles, users, and tasks:

```bash
php artisan db:seed
```

This will create:
- A **Manager** user
- A **User** user

---

### 6️⃣ Run the Application

```bash
php artisan serve
```

Now visit:
```
http://127.0.0.1:8000
```

---

## 📚 API Documentation

You can find the full API documentation at:

```
/docs
```

A **Postman collection** is also included in the repository for testing all endpoints.

---

## 🔒 Roles & Permissions Overview

| Role     | Permission Description |
|-----------|------------------------|
| **Manager** | Can view, create, update, and delete **any** task |
| **User** | Can view **only their own** tasks and update **only the status** |

---

## 🧩 Key Endpoints

| Method | Endpoint | Description | Access |
|---------|-----------|-------------|--------|
| `GET` | `/api/tasks` | List tasks | Manager: all, User: own |
| `POST` | `/api/tasks` | Create a new task | Manager only |
| `GET` | `/api/tasks/{id}` | View a single task | Manager: any, User: own |
| `PUT` | `/api/tasks/{id}` | Update task | Manager: full, User: status only |
| `DELETE` | `/api/tasks/{id}` | Delete task | Manager only |

---

## 🧠 Example Users (Seeded)

| Role | Email | Password |
|------|--------|-----------|
| **Manager** | manager@example.com | password |
| **User** | user@example.com | password |

> You can modify or create new users after seeding using Tinker or your preferred admin panel.

---

## 🧩 Tech Stack

- **Laravel 11+**
- **PHP 8.2+**
- **MySQL**
- **Spatie Laravel Permission**
- **Laravel Sanctum** (for API authentication)
- **Scribe** (for API documentation)

---

## 🧑‍💻 Development Notes

- All API routes are under the `/api` prefix.  
- Role and permission logic is handled by `spatie/laravel-permission`.  
- Policies and Gates enforce task access control.  
- Tasks support parent–child nesting and recursive relationships.  

---

## 📜 License

This project is open-source and available under the **MIT License**.

---

## 💡 Summary

1. Generate your `.env` file and Laravel app key.  
2. Run migrations and seeders.  
3. Access `/docs` for API reference.  
4. Use your Postman collection to test endpoints.  
5. Log in as **Manager** or **User** to explore role-based access.  

---

**Author:** SaadSleem  
**Framework:** Laravel  
**Version:** 12.x
