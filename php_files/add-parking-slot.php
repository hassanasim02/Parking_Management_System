<?php
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['vpmsaid'] == 0)) {
    header('location:logout.php');
} else {
    // Adding a new parking slot
    if (isset($_POST['submit'])) {
        $slotnumber = mysqli_real_escape_string($con, $_POST['slotnumber']); // To prevent SQL injection

        // Insert new parking slot into the database
        $query = mysqli_query($con, "INSERT INTO tblparkingslot(SlotNumber, Status) VALUES ('$slotnumber', 'Available')");
        
        if ($query) {
            echo "<script>alert('Parking Slot added successfully');</script>";
            echo "<script>window.location.href ='Slot-Availability.php';</script>"; 
        } else {
            echo "<script>alert('Something went wrong, try again');</script>";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Parking Slot</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Include Sidebar and Header -->
    <?php include_once('includes/sidebar.php'); ?>
    <?php include_once('includes/header.php'); ?>

    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add</strong> Parking Slot
                        </div>
                        <div class="card-body card-block">
                            <form action="" method="post" class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="slotnumber" class="form-control-label">Slot Number</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="number" id="slotnumber" name="slotnumber" class="form-control" placeholder="Enter Slot Number" required>
                                    </div>
                                </div>
                                <div class="form-actions form-group">
                                    <button type="submit" class="btn btn-primary btn-sm" name="submit">Add Slot</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include_once('includes/footer.php'); ?>
</body>
</html>
