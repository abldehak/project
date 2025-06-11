<?php 
include_once('includes/config.php');

// For deleting    
if(isset($_GET['del']) && isset($_GET['u_id'])){
    $u_id = intval($_GET['u_id']);
    mysqli_query($con, "DELETE FROM user_form WHERE user_id ='$u_id'");
    echo "<script>alert('User Deleted');</script>";
    echo "<script>window.location.href='manage-user.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Astonish - Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="assets/css/admin_styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<?php include_once('includes/header.php');?>
<div id="layoutSidenav">
<?php include_once('includes/leftbar.php');?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Manage Users</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Manage Users</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        User Details
                    </div>
                    <div class="card-body table-responsive">
                        <table id="datatablesSimple" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr. no.</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sr. no.</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php 
                            $query = mysqli_query($con, "SELECT * FROM user_form ORDER BY user_id ASC");
                            $cnt = 1;
                            while($row = mysqli_fetch_assoc($query)) { ?>    
                                <tr>
                                    <td><?php echo htmlentities($cnt);?></td>
                                    <td><?php echo htmlentities($row['user_id']);?></td> 
                                    <td><?php echo htmlentities($row['name']);?></td> 
                                    <td><?php echo htmlentities($row['email']);?></td>  
                                    <td>
                                        <a href="update-user.php?u_id=<?php echo $row['user_id']; ?>"><i class="fas fa-edit"></i></a> | 
                                        <a href="manage-user.php?u_id=<?php echo $row['user_id']; ?>&del=delete" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            <?php $cnt++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    <?php include_once('includes/footer.php');?>
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
