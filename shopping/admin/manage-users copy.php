<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());

    if (isset($_POST['submit'])) {
        $userid = $_POST['userid'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contactno = $_POST['contactno'];
        $shippingAddress = $_POST['shippingAddress'];
        $billingAddress = $_POST['billingAddress'];

        if ($userid) {
            // Update user
            $query = "UPDATE users SET name='$name', email='$email', contactno='$contactno', shippingAddress='$shippingAddress', billingAddress='$billingAddress' WHERE id='$userid'";
            mysqli_query($con, $query);
            $_SESSION['msg'] = "User updated successfully!";
        } else {
            // Add new user
            $query = "INSERT INTO users (name, email, contactno, shippingAddress, billingAddress) VALUES ('$name', '$email', '$contactno', '$shippingAddress', '$billingAddress')";
            mysqli_query($con, $query);
            $_SESSION['msg'] = "User added successfully!";
        }
    }

    if (isset($_GET['del'])) {
        mysqli_query($con, "DELETE FROM users WHERE id = '" . $_GET['id'] . "'");
        $_SESSION['delmsg'] = "User deleted !!";
    }

    if (isset($_GET['edit'])) {
        $userid = $_GET['edit'];
        $result = mysqli_query($con, "SELECT * FROM users WHERE id='$userid'");
        $row = mysqli_fetch_array($result);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin| Manage Users</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>
<body>
<?php include('include/header.php'); ?>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <?php include('include/sidebar.php'); ?>
            <div class="span9">
                <div class="content">

                    <div class="module">
                        <div class="module-head">
                            <h3>Manage Users</h3>
                        </div>
                        <div class="module-body table">
                            <?php if (isset($_GET['del'])) { ?>
                                <div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>Oh snap!</strong> <?php echo htmlentities($_SESSION['delmsg']); ?><?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                                </div>
                            <?php } ?>

                            <br />

                            <!-- Add/Edit User Form -->
                            <form method="post" action="manage-users copy.php">
                                <input type="hidden" name="userid" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
                                <div class="control-group">
                                    <label class="control-label" for="name">Name</label>
                                    <div class="controls">
                                        <input type="text" id="name" name="name" value="<?php echo isset($row['name']) ? $row['name'] : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="email">Email</label>
                                    <div class="controls">
                                        <input type="email" id="email" name="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="contactno">Contact No</label>
                                    <div class="controls">
                                        <input type="text" id="contactno" name="contactno" value="<?php echo isset($row['contactno']) ? $row['contactno'] : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="shippingAddress">Shipping Address</label>
                                    <div class="controls">
                                        <input type="text" id="shippingAddress" name="shippingAddress" value="<?php echo isset($row['shippingAddress']) ? $row['shippingAddress'] : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="billingAddress">Billing Address</label>
                                    <div class="controls">
                                        <input type="text" id="billingAddress" name="billingAddress" value="<?php echo isset($row['billingAddress']) ? $row['billingAddress'] : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                            <!-- End Add/Edit User Form -->

                            <br />
                            <!-- Existing table code -->
                            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact no</th>
                                        <th>Shipping Address/City/State/Pincode</th>
                                        <th>Billing Address/City/State/Pincode</th>
                                        <th>Reg. Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($con, "select * from users");
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                        <tr>
                                            <td><?php echo htmlentities($cnt); ?></td>
                                            <td><?php echo htmlentities($row['name']); ?></td>
                                            <td><?php echo htmlentities($row['email']); ?></td>
                                            <td><?php echo htmlentities($row['contactno']); ?></td>
                                            <td><?php echo htmlentities($row['shippingAddress'] . "," . $row['shippingCity'] . "," . $row['shippingState'] . "-" . $row['shippingPincode']); ?></td>
                                            <td><?php echo htmlentities($row['billingAddress'] . "," . $row['billingCity'] . "," . $row['billingState'] . "-" . $row['billingPincode']); ?></td>
                                            <td><?php echo htmlentities($row['regDate']); ?></td>
                                            <td>
                                                <a href="manage-users copy.php?edit=<?php echo $row['id']; ?>">Edit</a>
                                                <a href="manage-users copy.php?del=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php $cnt = $cnt + 1;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div><!--/.content-->
            </div><!--/.span9-->
        </div>
    </div><!--/.container-->
</div><!--/.wrapper-->

<?php include('include/footer.php'); ?>

<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
<script src="scripts/datatables/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('.datatable-1').dataTable();
        $('.dataTables_paginate').addClass("btn-group datatable-pagination");
        $('.dataTables_paginate > a').wrapInner('<span />');
        $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
        $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
    });
</script>
</body>
<?php } ?>