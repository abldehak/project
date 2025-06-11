<?php
include_once('includes/config.php');

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($con, "DELETE FROM contact_messages WHERE id = $id");
    echo "<script>alert('Message deleted successfully!');</script>";
    echo "<script>window.location.href='admin-messages.php';</script>";
    exit();
}

// Fetch messages
$sql = "SELECT cm.*, uf.name AS user_name 
        FROM contact_messages cm 
        LEFT JOIN user_form uf ON cm.user_id = uf.user_id 
        ORDER BY cm.created_at DESC";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Contact Messages - Admin Panel</title>
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
                <h1 class="mt-4">Contact Messages</h1>
                <div class="card mb-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['user_name'] ?? 'Guest'); ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td>
                                        <a href="admin-messages.php?delete=<?php echo $row['id']; ?>" 
                                        onclick="return confirm('Are you sure you want to delete this message?');"
                                        title="Delete"
                                        class="text-primary">
                                        <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once('includes/footer.php'); ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>
