<?php
session_start();
@include 'connection.php'; // connection.php should create $conn mysqli connection

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = [];

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM admins WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Show database error
        $error[] = "Database query failed: " . mysqli_error($conn);
    } else {
        if (mysqli_num_rows($result) > 0) {
            $admin = mysqli_fetch_assoc($result);
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['name']; // Use 'name' from your table
            header('Location: dashboard.php');
            exit();
        } else {
            $error[] = "Incorrect email or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Admin Login</title>
   <link rel="stylesheet" href="assets/css/login.css" />
</head>
<body>

<div class="form-container">

   <form action="" method="post">
      <h3>Admin Login</h3>

      <?php
      if (!empty($error)) {
         foreach ($error as $err) {
            echo '<span class="error-msg">' . htmlspecialchars($err) . '</span><br>';
         }
      }
      ?>

      <input type="email" name="email" required placeholder="Enter your email" />
      <input type="password" name="password" required placeholder="Enter your password" />
      <input type="submit" name="submit" value="Login now" class="form-btn" />
    
      <a href="index.php" style="font-size: 15px; line-height:50px; color:black;">
         <span style="text-decoration:underline;">Home</span>
      </a>
   </form>

</div>

</body>
</html>
