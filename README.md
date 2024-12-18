# BlogPost Project 🚀

BlogPost is a web application built with the Yii2 framework, allowing users to write, publish, view, and manage blog posts. It supports multi-role functionality, including features for unauthorized users, authors, and administrators. 

---

## 🌟 Features

### For Unauthorized Users
- View published posts.
- Register for an account.
- Log in to the system.

### For Authors
- View posts.
- Create, edit, and delete their own posts (deleting does not remove associated comments).
- Submit posts for moderation.
- Like or dislike other users' posts.
- Comment on other users' posts.
- Reply to comments under their own posts.

### For Administrators
- Approve, reject, or publish posts.
- Delete posts.
- Delete comments.
- Temporarily or permanently block users.

---

## 🛠️ Installation Guide

Follow these steps to set up the BlogPost project locally:

### Prerequisites
- PHP 7.4 or higher
- Composer
- MySQL or MariaDB
- A web server (e.g., Apache or Nginx)

### Step 1: Clone the Repository
```bash
git clone https://github.com/your-username/BlogPost.git
cd BlogPost
```

### Step 2: Install Dependencies
Run the following command to install the required dependencies using Composer:
```bash
composer update
```

### Step 3: Configure the Database
1. Create a new database for the project in your MySQL/MariaDB instance:
   ```sql
   CREATE DATABASE blogpost CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Configure the database connection in the `config/db.php` file:
   ```php
   return [
       'class' => 'yii\db\Connection',
       'dsn' => 'mysql:host=localhost;dbname=blogpost',
       'username' => 'your_username',
       'password' => 'your_password',
       'charset' => 'utf8mb4',
   ];
   ```

### Step 4: Run Migrations
Run the following command to apply the database migrations:
```bash
php yii migrate
```
This will set up all the necessary tables for the application.

### Step 5: Start the Server
Use Yii's built-in server for local development:
```bash
php yii serve
```
Visit the application in your browser at `http://localhost:8080`.

---

## 🎭 User Roles & Functionality

### Unauthorized Users
- **View Posts**: Browse all published posts.
- **Register**: Sign up for a new account.
- **Log In**: Access the application with an account.

### Authors (Logged-in Users with the Author Role)
- **View Posts**: Access their posts and others' published posts.
- **Create Posts**: Write new posts and submit them for moderation.
- **Edit Posts**: Update the content of their posts.
- **Delete Posts**: Remove their own posts (comments remain unaffected).
- **Like/Dislike Posts**: Express preferences for others' posts.
- **Comment on Posts**: Leave comments on posts written by others.
- **Reply to Comments**: Respond to comments under their own posts.

### Administrators
- **Manage Posts**: Approve, reject, publish, or delete posts.
- **Manage Comments**: Delete any comment.
- **Block Users**: Temporarily or permanently block users for violations.

---

## 📂 Project Structure
The following directories are important for development:
- `controllers/`: Contains the controllers that handle requests.
- `models/`: Includes the data models for the application.
- `modules/`: Includes account and admin modules.
- `views/`: Holds the view templates for the frontend.
- `migrations/`: Contains migration files for database setup.

---

## 💡 Acknowledgments
Special thanks to the Yii2 framework and its contributors for providing a robust foundation for this project.

---

### 🎉 Start your journey with BlogPost today!
```
