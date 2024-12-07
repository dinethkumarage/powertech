
<?php
include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerTech</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <a href="index.html" class="logo">PowerTech</a>
        <div class="nav-links">
            <a href="index.html">Home</a>
            <a href="#">Login</a>
        </div>
    </nav>
    <div class="login-container">
        <form class="login-form" action="login.php" method="POST">
            <h2>Login to Dashboard</h2>
            <div class="form-group">
                <label for="role">Select Role</label>
                <select id="role" name="role" required>
                    <option value="">Choose your role</option>
                    <option value="Admin">Admin</option>
                    <option value="Sales Representative">Sales Representative</option>
                </select>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-btn" name="submit">Login</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 PowerTech. All rights reserved.</p>
    </footer>
</body>
</html>
