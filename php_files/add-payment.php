<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['vpmsaid'] == 0)) {
    header('location:logout.php');
} else {

    if (isset($_POST['submit'])) {
        $paymentAmount = $_POST['paymentAmount'];
        $paymentMethod = $_POST['paymentMethod'];
        $vehicleId = $_POST['vehicleId']; // Associate with vehicle
        $invoiceNumber = mt_rand(100000, 999999);

        // Insert Payment Details into the tblpayment
        $query = mysqli_query($con, "INSERT INTO tblpayment (PaymentAmount, PaymentMethod, VehicleID, InvoiceNumber, PaymentStatus) 
            VALUES ('$paymentAmount', '$paymentMethod', '$vehicleId', '$invoiceNumber', 'Pending')");

        if ($query) {
            echo "<script>alert('Payment details have been added successfully');</script>";
            echo "<script>window.location.href ='manage-payments.php'</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    }

?>
<!doctype html>
<html class="no-js" lang="">
<head>
    <title>Add Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include_once('includes/sidebar.php');?>

    <?php include_once('includes/header.php');?>

    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add </strong> Payment
                        </div>
                        <div class="card-body card-block">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <p style="font-size:16px; color:red" align="center"> <?php if($msg) { echo $msg; } ?> </p>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="vehicleId" class=" form-control-label">Select Vehicle</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="vehicleId" id="vehicleId" class="form-control" required>
                                            <option value="">Select Vehicle</option>
                                            <?php
                                            $query = mysqli_query($con, "SELECT * FROM tblvehicle");
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <option value="<?php echo $row['ID']; ?>"><?php echo $row['RegistrationNumber']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="paymentAmount" class=" form-control-label">Amount</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="paymentAmount" name="paymentAmount" class="form-control" placeholder="Enter Payment Amount" required></div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="paymentMethod" class=" form-control-label">Payment Method</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="paymentMethod" name="paymentMethod" class="form-control" placeholder="Payment Method" required></div>
                                </div>

                                <p style="text-align: center;"> <button type="submit" class="btn btn-primary btn-sm" name="submit">Add Payment</button></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>

    <?php include_once('includes/footer.php');?>
</div><!-- /#right-panel -->

<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
<?php } ?>
