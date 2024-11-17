<?php
session_start();
include('includes/dbconnection.php');

// Check if user is logged in
if (strlen($_SESSION['vpmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

// Handle complaint submission
if (isset($_POST['submit_complaint'])) {
    $vehicle_id = $_POST['vehicle_id'];
    $complaint_description = $_POST['complaint_description'];

    // Check if the VehicleID exists in tblvehicle
    $check_vehicle_query = "SELECT ID FROM tblvehicle WHERE ID = '$vehicle_id'";
    $check_vehicle_result = mysqli_query($con, $check_vehicle_query);

    // If the vehicle ID doesn't exist, show an error
    if (mysqli_num_rows($check_vehicle_result) == 0) {
        echo "<script>alert('Error: Vehicle ID does not exist.');</script>";
    } else {
        // Set the initial status as "Pending" when submitting a new complaint
        $complaint_status = 'Pending';

        // Insert complaint into the database
        $query = "INSERT INTO tblcomplaints_feedback (VehicleID, ComplaintDescription, ComplaintStatus, DateSubmitted) 
                  VALUES ('$vehicle_id', '$complaint_description', '$complaint_status', NOW())";
        $result = mysqli_query($con, $query);

        // Check if the complaint was successfully inserted
        if ($result) {
            echo "<script>alert('Complaint submitted successfully');</script>";
            echo "<script>window.location.href ='Complaints-feedback.php';</script>";
        } else {
            echo "<script>alert('Error submitting complaint. Please try again.');</script>";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Complaint & Feedback</title>
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
                            <strong>Add</strong> Complaint & Feedback
                        </div>
                        <div class="card-body">
                            <form method="POST" action="Complaints-feedback.php">
                                <div class="form-group">
                                    <label for="vehicle_id">Vehicle ID</label>
                                    <input type="text" class="form-control" name="vehicle_id" id="vehicle_id" required>
                                </div>
                                <div class="form-group">
                                    <label for="complaint_description">Complaint Description</label>
                                    <textarea name="complaint_description" class="form-control" rows="3" required></textarea>
                                </div>
                                <button type="submit" name="submit_complaint" class="btn btn-primary">Submit Complaint</button>
                            </form>
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
