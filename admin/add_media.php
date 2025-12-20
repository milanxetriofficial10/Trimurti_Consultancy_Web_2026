<?php
require '../db/config.php';

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $description = $_POST['description'];

    // Base upload directory (relative to this file)
    $baseDir = __DIR__ . '/uploads/';
    $imageDir = $baseDir . 'images/';
    $videoDir = $baseDir . 'videos/';
    $audioDir = $baseDir . 'audio/';

    // Create folders if not exists
    if (!is_dir($imageDir)) mkdir($imageDir, 0755, true);
    if (!is_dir($videoDir)) mkdir($videoDir, 0755, true);
    if (!is_dir($audioDir)) mkdir($audioDir, 0755, true);

    // File names
    $image_path = null;
    $video_path = null;
    $audio_path = null;

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $image_path = 'uploads/images/' . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imageDir . $imageName);
    }

    if (!empty($_FILES['video']['name'])) {
        $videoName = time() . '_' . basename($_FILES['video']['name']);
        $video_path = 'uploads/videos/' . $videoName;
        move_uploaded_file($_FILES['video']['tmp_name'], $videoDir . $videoName);
    }

    if (!empty($_FILES['audio']['name'])) {
        $audioName = time() . '_' . basename($_FILES['audio']['name']);
        $audio_path = 'uploads/audio/' . $audioName;
        move_uploaded_file($_FILES['audio']['tmp_name'], $audioDir . $audioName);
    }

    // Insert into DB
    $stmt = $conn->prepare(
        "INSERT INTO media_gallery (name, description, video, image, audio) 
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssss", $name, $description, $video_path, $image_path, $audio_path);
    $stmt->execute();

    echo "<p style='color:green;'>Media added successfully!</p>";
}
?>

<h2>Add Media</h2>

<form method="post" enctype="multipart/form-data">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Description:</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Video:</label><br>
    <input type="file" name="video" accept="video/*"><br><br>

    <label>Image:</label><br>
    <input type="file" name="image" accept="image/*"><br><br>

    <label>Audio:</label><br>
    <input type="file" name="audio" accept="audio/*"><br><br>

    <button type="submit" name="submit">Add Media</button>
</form>
