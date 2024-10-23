<?php
session_start();


if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}


$games = [];
if (file_exists('../model/games.csv')) {
    $games = array_map('str_getcsv', file('../model/games.csv'));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> 
    <title>Games</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <h2>Game List</h2>
    <ul class="game-list">
    <?php foreach ($games as $game): ?>
        <li class="game-item">
            <h3><?php echo htmlspecialchars($game[0]); ?></h3>
            <p>Genre: <?php echo htmlspecialchars($game[1]); ?></p>
            <p>Platform: <?php echo htmlspecialchars($game[2]); ?></p>
            <img src="<?php echo htmlspecialchars($game[3]); ?>" alt="<?php echo htmlspecialchars($game[0]); ?>" class="game-image">
        </li>
    <?php endforeach; ?>
</ul>
</html>
