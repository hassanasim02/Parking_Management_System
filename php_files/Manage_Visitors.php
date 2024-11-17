<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['vpmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

// Fetching all visitor details from the database
$query = mysqli_query($con, "SELECT v.VisitorID, v.Name, v.ContactNumber, v.VehicleDetails, p.SlotNumber, v.EntryTime, v.ExitTime, v.ParkingCharge
                             FROM tblvisitor v
                             INNER JOIN tblparkingslot p ON v.ParkingSlotID = p.SlotID");
$visitors = mysqli_fetch_all($query, MYSQLI_ASSOC);

// Handling visitor exit time update
if (isset($_GET['exit'])) {
    $visitor_id = $_GET['exit'];
    $exitTime = date('Y-m-d H:i:s'); // Current timestamp

    // Update exit time
    $update_query = mysqli_query($con, "UPDATE tblvisitor SET ExitTime = '$exitTime' WHERE VisitorID = '$visitor_id'");
    
    if ($update_query) {
        echo "<script>alert('Visitor exit time updated successfully.');</script>";
        echo "<script>window.location.href ='Manage_Visitors.php';</script>";
    } else {
        echo "<script>alert('Error updating exit time. Please try again.');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Visitors</title>
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
                            <strong>Manage</strong> Visitors
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Visitor ID</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Vehicle Details</th>
                                        <th>Parking Slot</th>
                                        <th>Entry Time</th>
                                        <th>Exit Time</th>
                                        <th>Parking Charge</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($visitors as $visitor) { ?>
                                    <tr>
                                        <td><?php echo $visitor['VisitorID']; ?></td>
                                        <td><?php echo $visitor['Name']; ?></td>
                                        <td><?php echo $visitor['ContactNumber']; ?></td>
                                        <td><?php echo $visitor['VehicleDetails']; ?></td>
                                        <td><?php echo $visitor['SlotNumber']; ?></td>
                                        <td><?php echo $visitor['EntryTime']; ?></td>
                                        <td><?php echo $visitor['ExitTime']; ?></td>
                                        <td><?php echo $visitor['ParkingCharge']; ?></td>
                                        <td>
                                            <!-- Mark as Exit Button -->
                                            <?php if ($visitor['ExitTime'] == null) { ?>
                                                <a href="Manage_Visitors.php?exit=<?php echo $visitor['VisitorID']; ?>" class="btn btn-warning" onclick="return confirm('Mark this visitor as exited?');">Mark as Exit</a>
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
