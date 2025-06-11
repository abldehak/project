<?php
include('includes/config.php'); // make sure this connects to your database

session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = mysqli_real_escape_string($con, $_POST['name']);
    $email   = mysqli_real_escape_string($con, $_POST['email']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // Get user ID from session if logged in
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : NULL;

    // Insert into DB with user_id
    $query = "INSERT INTO contact_messages (name, email, subject, message, user_id)
              VALUES ('$name', '$email', '$subject', '$message', " . ($user_id !== NULL ? $user_id : 'NULL') . ")";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Message sent successfully.');window.location.href='contact.php';</script>";
    } else {
        echo "<script>alert('Failed to send message.');window.location.href='contact.php';</script>";
    }
}
?>
