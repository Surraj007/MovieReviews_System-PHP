<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_year = $_POST['release_year'];

    $sql = "INSERT INTO movies (title, genre, release_year) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $genre, $release_year);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Movie</title>
</head>
<a href="index.php">Home</a>
<body>
    <h2>Add New Movie</h2>
    <form method="post">
        <label>Title:</label><input type="text" name="title" required><br>
        <label>Genre:</label><input type="text" name="genre" required><br>
        <label>Release Year:</label><input type="number" name="release_year" required><br>
        <input type="submit" value="Add Movie">
    </form>
    
</body>
</html>
