<?php
@include 'connection.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = $_POST['password'];
   $cpassword = $_POST['cpassword'];

   $errors = [];

   // Check if user already exists by email
   $select = "SELECT * FROM user_form WHERE email = '$email'";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $errors[] = 'User with this email already exists!';
   }

   // Password match check
   if($password !== $cpassword){
      $errors[] = 'Passwords do not match!';
   }

   // If no errors, insert user
   if(empty($errors)){
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $insert = "INSERT INTO user_form (name, email, password, user_type) VALUES ('$name', '$email', '$hashed_password', 'user')";
      if(mysqli_query($conn, $insert)){
         header('location:login_form.php');
         exit();
      } else {
         $errors[] = 'Failed to register user. Please try again.';
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
   <title>Register Form</title>
   <link rel="stylesheet" href="assets/css/login.css" />
</head>
<body>

<div class="form-container">

   <form action="" method="post">
      <h3>Register now</h3>
      <?php
      if(!empty($errors)){
         foreach($errors as $error_msg){
            echo '<span class="error-msg">'.$error_msg.'</span>';
         }
      }
      ?>
      <input type="text" name="name" required placeholder="Enter your name" />
      <input type="email" name="email" required placeholder="Enter your email" />
      <input type="password" name="password" required placeholder="Enter your password" />
      <input type="password" name="cpassword" required placeholder="Confirm your password" />
      <input type="submit" name="submit" value="Register now" class="form-btn" />
      <p>Already have an account? <a href="login_form.php">Login now</a></p>
   </form>

</div>

</body>
</html>
