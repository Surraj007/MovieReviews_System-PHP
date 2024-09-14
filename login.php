<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password);
    
    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            header("Location: index.php");
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "No user found with that email!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<center>
<body>
    <h2>Login</h2>
    <form method="post">
        <label>Email:</label><input type="email" name="email" required><br>
        <label>Password:</label><input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form> 
    <br>
    <a href="register.php">Register</a>
    </center>
</body>
</html>
