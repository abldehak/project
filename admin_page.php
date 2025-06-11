<?php
session_start();
@include 'connection.php';

if (isset($_SESSION['admin_id'])) {
    // Already logged in
    header('Location: dashboard.php');
    exit();
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Query admin by email
    $query = "SELECT * FROM admins WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $admin = mysqli_fetch_assoc($result);

        // Verify password using password_verify()
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['admin_name'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Incorrect email or password!";
        }
    } else {
        $error = "Incorrect email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Login</title>
    <link rel="stylesheet" href="assets/css/login.css" />
</head>
<body>
<div class="form-container">
    <form action="" method="post">
        <h3>Admin Login</h3>
        <?php if (isset($error)) { ?>
            <span class="error-msg"><?php echo $error; ?></span>
        <?php } ?>
        <input type="email" name="email" required placeholder="Enter your email" />
        <input type="password" name="password" required placeholder="Enter your password" />
        <input type="submit" name="submit" value="Login now" class="form-btn" />
    </form>
</div>
</body>
</html>
