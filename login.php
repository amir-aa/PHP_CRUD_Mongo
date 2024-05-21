<?php
require 'db.php';
require 'secure_session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $usersCollection->findOne(['username' => $username]);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = (string) $user['_id'];
        $_SESSION['username'] = (string) $username;
        header("Location: protected.php");
        exit;
    } else {
        echo "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
