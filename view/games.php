<?php
$dsn = "mysql:host=localhost;dbname=games";
$username = "root";
$password = "";

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}

$query = "SELECT * FROM game";
$games = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);

if (empty($games)) {
    echo "No games found in the database.";
    exit;
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
    <h1>Game List</h1>
    <a href="../model/add_game.php" style="background-color: #28a745; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none;">Add a New Game</a>
    <ul class="game-list">
        <?php foreach ($games as $game): ?>
            <li class="game-item">
                <h3><?php echo $game['name']; ?></h3>
                <p>Genre: <?php echo $game['genre']; ?></p>
                <p>Platform: <?php echo $game['platform']; ?></p>
                <img src="images/<?php echo $game['image']; ?>" alt="<?php echo $game['name']; ?>" class="game-image">
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
