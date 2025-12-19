<?php
require '../db/config.php'; // your DB connection

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $description = $_POST['description'];

    // File uploads
    $video = $_FILES['video']['name'];
    $image = $_FILES['image']['name'];
    $audio = $_FILES['audio']['name'];

    // File paths
    $video_path = $video ? 'uploads/videos/'.$video : null;
    $image_path = $image ? 'uploads/images/'.$image : null;
    $audio_path = $audio ? 'uploads/audio/'.$audio : null;

    // Move uploaded files
    if($video) move_uploaded_file($_FILES['video']['tmp_name'], $video_path);
    if($image) move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    if($audio) move_uploaded_file($_FILES['audio']['tmp_name'], $audio_path);

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO media_gallery (name, description, video, image, audio) VALUES (?, ?, ?, ?, ?)");
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
