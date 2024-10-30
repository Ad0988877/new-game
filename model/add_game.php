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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $platform = $_POST['platform'];
    $image = $_FILES['image'];

    if ($image['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '/view/images/'; 
        $uploadFile = $uploadDir . basename($image['name']);
        
        if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
            $qry = "INSERT INTO game (name, genre, platform, image) VALUES (:name, :genre, :platform, :image)";
            $stmt = $db->prepare($qry);
            $stmt->execute([
                ':name' => $name,
                ':genre' => $genre,
                ':platform' => $platform,
                ':image' => $image['name'] 
            ]);
            echo "Game added successfully!";
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "Error with image upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/view/styles.css">
    <title>Add Game</title>
</head>
<body>
    <h1>Add a New Game</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="name">Game Name:</label>
        <input type="text" name="name" id="name" required>
        
        <label for="genre">Genre:</label>
        <input type="text" name="genre" id="genre" required>
        
        <label for="platform">Platform:</label>
        <input type="text" name="platform" id="platform" required>
        
        <label for="image">Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required>

        <button type="submit">Add Game</button>
    </form>
    <a href="../view/games.php" style="background-color: #28a745; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none;">Full Game list</a>
</body>
</html>
