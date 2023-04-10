<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotelReviewsDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM reviews WHERE id = '$id'";
        $conn->query($sql);
    } elseif (isset($_POST['add'])) {
        $visitor_name = $_POST['visitor_name'];
        $review = $_POST['review'];

        // Handle file upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo = $target_file;
            $sql = "INSERT INTO reviews (visitor_name, review, photo) VALUES ('$destination_name', '$review', '$photo')";
            $conn->query($sql);
        } else {
            echo "Error uploading the image.";
        }
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $visitor_name = $_POST['visitor_name'];
        $photo = $_POST['photo'];
        $review = $_POST['review'];

        $sql = "UPDATE reviews SET visitor_name='$visitor_name', review='$review', photo='$photo' WHERE id='$id'";
        $conn->query($sql);
    }
}

$sql = "SELECT * FROM reviews";
$result = $conn->query($sql);

if (!$result) {
    echo "Error: " . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reviews</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function editReview(id, visitor_name, review, photo) {
            document.getElementById("editForm").style.display = "block";
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_visitor_name").value = visitor_name;
            document.getElementById("edit_photo").value = photo;
            document.getElementById("edit_review").value = review;
        }
    </script>
<body>
<nav>
        <div class="brand-logo">
        <a href="index.php">HOTEL REVIEW</a>
        </div>
        <a href="index.php">Login</a>
        <a href="registration.php">Sign Up</a>
        <a href="data.php">View Content</a>
    </nav>

    <form action="data.php" method="POST" enctype="multipart/form-data">
        <label for="add_review" class=addreview>ADD REVIEW</label>
        <label for="hotel_name">Hotel Name:</label>
        <input type="text" name="hotel_name" id="hotel_name" required>
        <br>
        <label for="photo">Photo:</label>
        <input type="file" name="photo" id="photo" required>
        <br>
        <label for="review">Review:</label>
        <textarea name="review" id="review" required></textarea>
        <br>
        <input type="submit" name="add" value="Add Review">
    </form>

    <form id="editForm" action="data.php" method="POST" style="display: none;">
        <input type="hidden" name="id" id="edit_id">
        <label for="edit_hotel_name">Hotel Name:</label>
        <input type="text" name="destination_name" id="edit_destination_name" required>
        <br>
        <label for="edit_review">Review:</label>
        <textarea name="review" id="edit_review" required></textarea>
        <br>
        <label for="edit_photo">Photo URL:</label>
        <input type="text" name="photo" id="edit_photo" required>
        <br>
        <br>
        <input type="submit" name="edit" value="Edit Review">
    </form>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<button onclick=\"editReview('" . $row['id'] . "','" . addslashes($row['hotel_name']) . "','" . addslashes($row['review']) . "','" . $row['photo'] . "')\">Edit</button>";
            echo "<h2>" . $row['hotel_name'] . "</h2>";
            echo "<img src='" . $row['photo'] . "' alt='" . $row['hotel_name'] . "' width='600'>";
            echo "<p>" . $row['review'] . "</p>";
            echo "<form action='data.php' method='POST'>";
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
            echo "<input type='submit' name='delete' value='Delete'>";
            echo "</form>";
            echo "</div>";
        }
} else {
    echo "No review posted yet!";
}
$conn->close();
?>
</body>
</html>