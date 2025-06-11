<?php
include_once('includes/config.php');

if (!isset($_GET['u_id'])) {
    echo "<script>alert('No User ID provided.'); window.location.href='manage-user.php';</script>";
    exit;
}

$u_id = intval($_GET['u_id']);

// Process form submission
if (isset($_POST['submit'])) {
    $u_name = mysqli_real_escape_string($con, $_POST['username']);
    $u_email = mysqli_real_escape_string($con, $_POST['useremail']);

    // Update name and email only (password stays unchanged here)
    $sql = "UPDATE user_form SET name='$u_name', email='$u_email' WHERE user_id = '$u_id'";
    $update = mysqli_query($con, $sql);

    if ($update) {
        echo "<script>alert('User Details updated successfully.'); window.location.href='manage-user.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error updating user details.');</script>";
    }
}

// Fetch current user data
$query = mysqli_query($con, "SELECT * FROM user_form WHERE user_id='$u_id' LIMIT 1");
if (mysqli_num_rows($query) == 0) {
    echo "<script>alert('No user found with this ID.'); window.location.href='manage-user.php';</script>";
    exit;
}
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Update User - Astonish</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="assets/css/admin_styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include_once('includes/header.php'); ?>
<div id="layoutSidenav">
<?php include_once('includes/leftbar.php'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Update User</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Update User</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="post">
                            <div class="row">
                                <div class="col-4">User ID</div>
                                <div class="col-6">
                                    <input type="text" value="<?php echo htmlentities($user['user_id']); ?>" class="form-control" readonly>
                                </div>

                                <div class="col-4" style="margin-top:10px;">User Name</div>
                                <div class="col-6" style="margin-top:10px;">
                                    <input type="text" name="username" value="<?php echo htmlentities($user['name']); ?>" class="form-control" required>
                                </div>

                                <div class="col-4" style="margin-top:10px;">User Email</div>
                                <div class="col-6" style="margin-top:10px;">
                                    <input type="email" name="useremail" value="<?php echo htmlentities($user['email']); ?>" class="form-control" required>
                                </div>

                                <!-- Password update is not included here -->

                            </div>
                            <div class="row" style="margin-left:500px; margin-top:20px;">
                                <div class="col-2">
                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
<?php include_once('includes/footer.php'); ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="assets/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="assets/js/datatables-simple-demo.js"></script>
</body>
</html>
