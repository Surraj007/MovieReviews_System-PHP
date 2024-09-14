<?php
session_start();
require 'db.php';

$movie_id = $_GET['id'];

// Fetch all movie in details
$sql = "SELECT * FROM movies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$movie = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch the all movie reviews
$sql = "SELECT reviews.*, users.username FROM reviews JOIN users ON reviews.user_id = users.id WHERE movie_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$reviews = $stmt->get_result();
$stmt->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($movie['title']); ?> Reviews</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <h1><?php echo htmlspecialchars($movie['title']); ?></h1>
    <p>Genre: <?php echo htmlspecialchars($movie['genre']); ?></p>
    <p>Release Year: <?php echo htmlspecialchars($movie['release_year']); ?></p>

    <h3>Reviews</h3>
    <div class="reviews">
        <?php while ($review = $reviews->fetch_assoc()): ?>
            <div class="review">
                <p><strong><?php echo htmlspecialchars($review['username']); ?>:</strong></p>
                <p>Rating: <?php echo $review['rating']; ?>/5</p>
                <p><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <a href="add_review.php?movie_id=<?php echo $movie_id; ?>">Add Review</a> <br>
<a href="add_movie.php">Back to add movie</a> <br>
<a href="index.php">Home</a>
</body>
</html>
