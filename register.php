<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo'w';
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $existingUser = $usersCollection->findOne(['username' => $username]);

    if ($existingUser) {
        echo "Username already exists!";
    } else {
        $result = $usersCollection->insertOne([
            'username' => $username,
            'password' => $password,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);

        if ($result->getInsertedCount() > 0) {
            echo "User registered successfully!";
        } else {
            echo "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <form method="POST" action="register.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
