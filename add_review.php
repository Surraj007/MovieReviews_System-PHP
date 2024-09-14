<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$movie_id = $_GET['movie_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];

    $sql = "INSERT INTO reviews (user_id, movie_id, rating, review_text) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $_SESSION['user_id'], $movie_id, $rating, $review_text);

    if ($stmt->execute()) {
        header("Location: movie_detail.php?id=$movie_id");
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
    <title>Add Review</title>
</head>
<body>
    <h2>Add Review</h2>
    <form method="post">
        <label>Rating (1-5):</label><input type="number" name="rating" min="1" max="5" required><br>
        <label>Review Text:</label><textarea name="review_text" required></textarea><br>
        <input type="submit" value="Add Review">
    </form>
    <a href="index.php">Home page</a>
</body>
</html>
