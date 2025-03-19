<?php
// Display all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Include database connection
require_once 'includes/config/database.php';

// Basic authentication with database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    try {
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND status = 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && $password === $user['password']) { // In production, use password_verify() with hashed passwords
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            
            // Log login activity
            $stmt = $conn->prepare("INSERT INTO activity_log (user_id, description, action) VALUES (?, ?, ?)");
            $stmt->execute([
                $user['id'],
                "User logged in successfully",
                "login"
            ]);
            
            // Redirect based on role
            switch ($user['role']) {
                case 'admin':
                    header("Location: pages/admin/dashboard.php");
                    break;
                case 'sales':
                    header("Location: pages/sales/dashboard.php");
                    break;
                case 'staff':
                    header("Location: pages/staff/dashboard.php");
                    break;
                default:
                    header("Location: index.php");
            }
            exit();
        } else {
            $error_message = "Invalid username or password!";
            
            // Log failed login attempt
            if ($user) {
                $stmt = $conn->prepare("INSERT INTO activity_log (user_id, description, action) VALUES (?, ?, ?)");
                $stmt->execute([
                    $user['id'],
                    "Failed login attempt",
                    "login_failed"
                ]);
            }
        }
    } catch (PDOException $e) {
        $error_message = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System - Login</title>
    <style>
    :root {
        --primary-color: #6C63FF;
        --secondary-color: #4CAF50;
        --background-dark: #1A1A1A;
        --background-light: #2D2D2D;
        --text-primary: #FFFFFF;
        --text-secondary: #B3B3B3;
        --danger-color: #FF5252;
        --success-color: #4CAF50;
        --warning-color: #FFC107;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        background-color: var(--background-dark);
        color: var(--text-primary);
        line-height: 1.6;
    }

    .login-container {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--background-dark) 0%, var(--background-light) 100%);
    }

    .login-card {
        background: var(--background-light);
        padding: 2.5rem;
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 400px;
    }

    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-header h1 {
        font-size: 2rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-secondary);
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--background-dark);
        border-radius: 8px;
        background: var(--background-dark);
        color: var(--text-primary);
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.2);
    }

    .btn {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
        width: 100%;
    }

    .btn-primary:hover {
        background: #5650e6;
        transform: translateY(-1px);
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .alert-danger {
        background: rgba(255, 82, 82, 0.1);
        color: var(--danger-color);
        border: 1px solid var(--danger-color);
    }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Inventory Management</h1>
                <p style="color: var(--text-secondary);">Sign in to your account</p>
            </div>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>

            <div style="margin-top: 1.5rem; text-align: center; color: var(--text-secondary);">
                <p>Demo Credentials:</p>
                <small>Admin: admin/admin</small><br>
                <small>Sales: sales/sales</small><br>
                <small>Staff: staff/staff</small>
            </div>
        </div>
    </div>
</body>
</html> 