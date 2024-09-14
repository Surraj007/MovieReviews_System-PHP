<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

//  all movies here
$sql = "SELECT * FROM movies";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie Reviews</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Movie Reviews</h1>
    <a href="add_movie.php">Add New Movie</a> 

    <div class="movies">
        <?php while ($movie = $result->fetch_assoc()): ?>
            <div class="movie">
                <h3><?php echo htmlspecialchars($movie['title']); ?> (<?php echo $movie['release_year']; ?>)</h3>
                <p>Genre: <?php echo htmlspecialchars($movie['genre']); ?></p>
                <a href="movie_detail.php?id=<?php echo $movie['id']; ?>">View Reviews</a>
            </div>
        <?php endwhile; ?>
    </div>
    <a href="logout.php">Logout</a>
</body>
</html>
