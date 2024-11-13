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
$game = null;
if (isset($_GET['game_id'])) {
    $game_id = $_GET['game_id'];
    $query = "SELECT * FROM game WHERE game_id = :game_id";
    $stmt = $db->prepare($query);
    $stmt->execute([':game_id' => $game_id]);
    $game = $stmt->fetch(PDO::FETCH_ASSOC);
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $platform = $_POST['platform'];
    $image = $_FILES['image'];
    if ($image['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../view/images/';
        $uploadFile = $uploadDir . basename($image['name']);
        if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
            $newImage = $image['name'];
        } else {
            echo "Error uploading image.";
        }
    } else {
        $newImage = $game['image'];
    }
    $qry = "UPDATE game SET name = :name, genre = :genre, platform = :platform, image = :image WHERE game_id = :game_id";
    $stmt = $db->prepare($qry);
    $stmt->execute([
        ':name' => $name,
        ':genre' => $genre,
        ':platform' => $platform,
        ':image' => $newImage,
        ':game_id' => $game_id
    ]);
    echo "Game updated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../view/styles.css">
    <title><?php echo $game ? "Edit Game" : "Add Game"; ?></title>
</head>
<body>
    <h1><?php echo $game ? "Edit Game" : "Add a New Game"; ?></h1>

    <form method="post" enctype="multipart/form-data">
        <label for="name">Game Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $game['name'] ?? ''; ?>" required>

        <label for="genre">Genre:</label>
        <input type="text" name="genre" id="genre" value="<?php echo $game['genre'] ?? ''; ?>" required>

        <label for="platform">Platform:</label>
        <input type="text" name="platform" id="platform" value="<?php echo $game['platform'] ?? ''; ?>" required>

        <label for="image">Image:</label>
        <input type="file" name="image" id="image" accept="image/*">

        <?php if (!empty($game['image'])): ?>
            <p>Current Image: 
                <img src="../view/images/<?php echo htmlspecialchars($game['image']); ?>" alt="Current Game Image" style="max-width: 200px; height: auto;">
            </p>
        <?php endif; ?>
        <button type="submit"><?php echo $game ? "Update Game" : "Add Game"; ?></button>
    </form>
    <a href="../view/games.php" style="background-color: #28a745; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none;">Back to Game List</a>
</body>
</html>
