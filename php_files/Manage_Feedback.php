<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['vpmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

// Fetching all complaints from the database
$query = mysqli_query($con, "SELECT * FROM tblcomplaints_feedback");
$complaints = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Handling complaint status update
if (isset($_GET['resolve'])) {
    $complaint_id = $_GET['resolve'];

    // Update status to "Resolved"
    $update_query = mysqli_query($con, "UPDATE tblcomplaints_feedback SET ComplaintStatus = 'Resolved' WHERE ComplaintID = '$complaint_id'");
    
    if ($update_query) {
        echo "<script>alert('Complaint marked as resolved.');</script>";
        echo "<script>window.location.href ='Manage_Feedback.php';</script>";
    } else {
        echo "<script>alert('Error marking complaint as resolved. Please try again.');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Complaints</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Include Header and Sidebar -->
    <?php include_once('includes/sidebar.php'); ?>
    <?php include_once('includes/header.php'); ?>

    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Manage</strong> Complaints & Feedback
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Complaint ID</th>
                                        <th>Vehicle ID</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Date Submitted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($complaints as $complaint) { ?>
                                    <tr>
                                        <td><?php echo $complaint['ComplaintID']; ?></td>
                                        <td><?php echo $complaint['VehicleID']; ?></td>
                                        <td><?php echo $complaint['ComplaintDescription']; ?></td>
                                        <td><?php echo $complaint['ComplaintStatus']; ?></td>
                                        <td><?php echo $complaint['DateSubmitted']; ?></td>
                                        <td>
                                            <!-- Mark as Resolved Button -->
                                            <?php if ($complaint['ComplaintStatus'] == 'Pending') { ?>
                                                <a href="Manage_Feedback.php?resolve=<?php echo $complaint['ComplaintID']; ?>" class="btn btn-success" onclick="return confirm('Mark this complaint as resolved?');">Mark as Resolved</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include_once('includes/footer.php'); ?>

    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
