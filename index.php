<?php
session_start();

$errMsg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['passwd'])) {
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "hotelReviewsDB";

    // Connect to the database
    $db_conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check connection
    if ($db_conn->connect_error) {
        die("Connection failed: " . $db_conn->connect_error);
    }

    $email = $_POST['email'];
    $passwd = $_POST['passwd'];

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$passwd'";
    $res = $db_conn->query($query);

    if ($res && $res->num_rows > 0) {
        $_SESSION['email'] = $email;
        header("Location: data.php");
        exit;
    } else {
        $errMsg = "Invalid email or password.";
    }

    $db_conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    if (!empty($errMsg)) {
        echo "<p style='color: red;'>" . $errMsg . "</p>";
    }
    ?>
    <div>
    <br>
    <form action="index.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="passwd">Password:</label>
        <input type="password" name="passwd" id="passwd" required>
        <br>
        <input type="submit" value="Login">
    </form>
    </div>
</body>
</html>
