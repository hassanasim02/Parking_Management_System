<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['vpmsaid'] == 0)) {
    header('location:logout.php');
} else {
    // Fetching all payments from the database
    $query = mysqli_query($con, "SELECT tblpayment.PaymentID, tblpayment.VehicleID, tblpayment.PaymentAmount, tblpayment.PaymentStatus, tblpayment.PaymentDate 
                                 FROM tblpayment 
                                 INNER JOIN tblvehicle ON tblpayment.VehicleID = tblvehicle.ID");
    $payments = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments</title>
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
                            <strong>Manage</strong> Payments
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Payment ID</th>
                                        <th>Vehicle ID</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Payment Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($payments as $payment) { ?>
                                    <tr>
                                        <td><?php echo $payment['PaymentID']; ?></td>
                                        <td><?php echo $payment['VehicleID']; ?></td>
                                        <td><?php echo $payment['PaymentAmount']; ?></td>
                                        <td><?php echo $payment['PaymentStatus']; ?></td>
                                        <td><?php echo $payment['PaymentDate']; ?></td>
                                        <td>
                                            <!-- Update Button -->
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#updatePaymentModal<?php echo $payment['PaymentID']; ?>">Update</button>

                                            <!-- Delete Button -->
                                            <a href="manage-payments.php?delete=<?php echo $payment['PaymentID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this payment?');">Delete</a>
                                        </td>
                                    </tr>

                                    <!-- Update Payment Modal -->
                                    <div class="modal fade" id="updatePaymentModal<?php echo $payment['PaymentID']; ?>" tabindex="-1" role="dialog" aria-labelledby="updatePaymentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="manage-payments.php" method="POST">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updatePaymentModalLabel">Update Payment</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="billing_id" value="<?php echo $payment['PaymentID']; ?>">
                                                        <div class="form-group">
                                                            <label for="payment_status">Payment Status</label>
                                                            <select name="payment_status" class="form-control" required>
                                                                <option value="Pending" <?php echo ($payment['PaymentStatus'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                                <option value="Paid" <?php echo ($payment['PaymentStatus'] == 'Paid') ? 'selected' : ''; ?>>Paid</option>
                                                                <option value="Failed" <?php echo ($payment['PaymentStatus'] == 'Failed') ? 'selected' : ''; ?>>Failed</option>
                                                            </select>
                                                        </div>
                                                         <div class="form-group">
                                                            <label for="amount">Amount</label>
                                                            <!-- <input type="number" name="amount" class="form-control" value="<?php echo ($payment['Amount']) ?>"> -->
                                                            <input type="number" class="form-control" name="amount" value="<?php echo $payment['PaymentAmount']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="update_payment" class="btn btn-primary">Update</button>
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

    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
    // Delete Payment
    if (isset($_GET['delete'])) {
        $billing_id = $_GET['delete'];
        $delete_query = mysqli_query($con, "DELETE FROM tblpayment WHERE PaymentID = '$billing_id'");
        if ($delete_query) {
            echo "<script>alert('Payment deleted successfully');</script>";
            echo "<script>window.location.href ='manage-payments.php';</script>";
        } else {
            echo "<script>alert('Error deleting payment. Please try again.');</script>";
        }
    }

    // Update Payment
    if (isset($_POST['update_payment'])) {
        $billing_id = $_POST['billing_id'];
        $payment_status = $_POST['payment_status'];
        $amount = $_POST['amount']; // Get the updated amount

        // $update_query = mysqli_query($con, "UPDATE tblbilling SET PaymentStatus = '$payment_status', Amount = '$amount' WHERE BillingID = '$billing_id'");

        $update_query = mysqli_query($con, "UPDATE tblpayment SET PaymentStatus = '$payment_status',PaymentAmount = '$amount' WHERE PaymentID = '$billing_id'");
        if ($update_query) {
            echo "<script>alert('Payment updated successfully');</script>";
            echo "<script>window.location.href ='manage-payments.php';</script>";
        } else {
            echo "<script>alert('Error updating payment. Please try again.');</script>";
        }
    }
}
?>
