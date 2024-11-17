<?php
session_start();
include('includes/dbconnection.php');

// Check if the user is logged in
if (strlen($_SESSION['vpmsaid'] == 0)) {
    header('location:logout.php');
    exit;
}

// Handle delete request
if (isset($_GET['delete'])) {
    $slotid = $_GET['delete'];
    // Ensure SlotID exists before attempting to delete
    if ($slotid) {
        $delete_query = mysqli_query($con, "DELETE FROM tblparkingslot WHERE SlotID = '$slotid'");

        if ($delete_query) {
            echo "<script>alert('Parking Slot deleted successfully');</script>";
            echo "<script>window.location.href = 'Slot-Availability.php';</script>";  // Redirect to Slot-Availability.php
        } else {
            echo "<script>alert('Error deleting parking slot. Please try again.');</script>";
        }
    }
}

// Handle update request
if (isset($_POST['update_slot'])) {
    $slotid = $_POST['slotid'];
    $slotnumber = $_POST['slotnumber'];
    $status = $_POST['status'];

    if ($slotid && $slotnumber && $status) {
        $update_query = mysqli_query($con, "UPDATE tblparkingslot SET SlotNumber = '$slotnumber', Status = '$status' WHERE SlotID = '$slotid'");
        if ($update_query) {
            echo "<script>alert('Parking Slot updated successfully');</script>";
            echo "<script>window.location.href = 'Slot-Availability.php';</script>";  // Redirect to Slot-Availability.php
        } else {
            echo "<script>alert('Error updating parking slot. Please try again.');</script>";
        }
    }
}

// Fetch all parking slots
$query = mysqli_query($con, "SELECT * FROM tblparkingslot");
$slots = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Parking Slot</title>
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
                            <strong>Manage</strong> Parking Slots
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Slot ID</th>
                                        <th>Slot Number</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($slots as $slot) { ?>
                                    <tr>
                                        <td><?php echo $slot['SlotID']; ?></td>
                                        <td><?php echo $slot['SlotNumber']; ?></td>
                                        <td><?php echo $slot['Status']; ?></td>
                                        <td>
                                            <!-- Update Button -->
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#updateSlotModal<?php echo $slot['SlotID']; ?>">Update</button>

                                            <!-- Delete Button -->
                                            <a href="Slot-Availability.php?delete=<?php echo $slot['SlotID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this parking slot?');">Delete</a>
                                        </td>
                                    </tr>

                                    <!-- Update Slot Modal -->
                                    <div class="modal fade" id="updateSlotModal<?php echo $slot['SlotID']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateSlotModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="Slot-Availability.php" method="POST">  <!-- Action should point to Slot-Availability.php -->
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateSlotModalLabel">Update Parking Slot</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="slotid" value="<?php echo $slot['SlotID']; ?>">
                                                        <div class="form-group">
                                                            <label for="slotnumber">Slot Number</label>
                                                            <input type="number" name="slotnumber" class="form-control" value="<?php echo $slot['SlotNumber']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="status">Slot Status</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="Available" <?php echo ($slot['Status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                                                                <option value="Occupied" <?php echo ($slot['Status'] == 'Occupied') ? 'selected' : ''; ?>>Occupied</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="update_slot" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
