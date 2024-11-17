<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['vpmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

// Fetching all parking slots from the database
$query_slots = mysqli_query($con, "SELECT * FROM tblparkingslot WHERE Status = 'Available'");
$slots = mysqli_fetch_all($query_slots, MYSQLI_ASSOC);

// Handling visitor form submission
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $vehicle_details = mysqli_real_escape_string($con, $_POST['vehicle_details']);
    $slot_id = $_POST['slot_id'];
    $entry_time = date('Y-m-d H:i:s'); // Current timestamp

    // Inserting visitor information into the database
    $insert_query = mysqli_query($con, "INSERT INTO tblvisitor (Name, ContactNumber, VehicleDetails, ParkingSlotID, EntryTime) 
                                        VALUES ('$name', '$contact', '$vehicle_details', '$slot_id', '$entry_time')");

    // Updating the parking slot status to 'Occupied'
    if ($insert_query) {
        $update_slot_query = mysqli_query($con, "UPDATE tblparkingslot SET Status = 'Occupied' WHERE SlotID = '$slot_id'");
        echo "<script>alert('Visitor added successfully.');</script>";
        echo "<script>window.location.href ='Manage_Visitors.php';</script>";
    } else {
        echo "<script>alert('Error adding visitor. Please try again.');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Visitor</title>
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
                            <strong>Add</strong> Visitor
                        </div>
                        <div class="card-body">
                            <form method="POST" action="add-visitor.php">
                                <div class="form-group">
                                    <label for="name">Visitor Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="contact">Contact Number</label>
                                    <input type="text" class="form-control" id="contact" name="contact" required>
                                </div>
                                <div class="form-group">
                                    <label for="vehicle_details">Vehicle Details</label>
                                    <input type="text" class="form-control" id="vehicle_details" name="vehicle_details" required>
                                </div>
                                <div class="form-group">
                                    <label for="slot_id">Parking Slot</label>
                                    <select class="form-control" id="slot_id" name="slot_id" required>
                                        <option value="">Select Parking Slot</option>
                                        <?php foreach ($slots as $slot) { ?>
                                            <option value="<?php echo $slot['SlotID']; ?>"><?php echo $slot['SlotNumber']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Add Visitor</button>
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
