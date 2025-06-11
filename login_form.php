<?php
@include 'connection.php';
session_start();

$error = [];

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);

   $select = "SELECT * FROM user_form WHERE email = '$email' AND password = '$pass'";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_assoc($result);

      // Set session variables for logged in user
      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['user_name'] = $row['name'];

      // Redirect to user homepage (change as needed)
      header('location:index.php');
      exit();

   } else {
      $error[] = 'Incorrect email or password!';
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Login Form</title>
   <link rel="stylesheet" href="assets/css/login.css" />
</head>
<body>

<div class="form-container">

   <form action="" method="post">
      <h3>Login now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error_msg){
            echo '<span class="error-msg">'.$error_msg.'</span>';
         }
      }
      ?>
      <input type="email" name="email" required placeholder="Enter your email" />
      <input type="password" name="password" required placeholder="Enter your password" />
      <input type="submit" name="submit" value="Login now" class="form-btn" />
      <p>Don't have an account? <a href="register_form.php">Register now</a></p>
      <a href="index.php" style="font-size: 15px; line-height:50px; color:black;">
         <span style="text-decoration:underline;">Home</span>
      </a>
   </form>

</div>

</body>
</html>
