<?php
session_start();

$errorMsg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['user_email']) && !empty($_POST['user_passwd'])) {
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "hotellReviewsDB";

    // Establish database connection
    $db_conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Verify connection
    if ($db_conn->connect_error) {
        die("Connection failed: " . $db_conn->connect_error);
    }

    $email = $_POST['user_email'];
    $passwd = $_POST['user_passwd'];

    $query = "INSERT INTO users (email, password) VALUES ('$email', '$passwd')";

    if ($db_conn->query($query) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        $errorMsg = "Error: " . $query . "<br>" . $db_conn->error;
    }

    $db_conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="brand-logo">
        <a href="index.php">HOTEL REVIEW</a>
        </div>
        <a href="index.php">Login</a>
        <a href="registration.php">Sign Up</a>
        <a href="data.php">View Content</a>
    </nav>

    <?php
    if (!empty($errorMsg)) {
        echo "<p style='color: red;'>" . $errorMsg . "</p>";
    }
    ?>
    <div>
    <br>
    <form action="registration.php" method="POST">
        <label for="user_email">Email:</label>
        <input type="email" name="user_email" id="user_email" required>
        <br>
        <label for="user_passwd">Password:</label>
        <input type="password" name="user_passwd" id="user_passwd" required>
        <br>
        <input type="submit" value="Sign Up">
    </form>
    </div>
</body>
</html>
