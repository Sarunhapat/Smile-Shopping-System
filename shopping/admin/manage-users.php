<?php
session_start();
include('include/config.php');

if(strlen($_SESSION['alogin'])==0) {	
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('d-m-Y h:i:s A', time());

	if(isset($_GET['del']) && $_GET['del'] == 'delete') {
		$userId = intval($_GET['id']); 
		$query = mysqli_query($con, "DELETE FROM users WHERE id = '$userId'");
		
		if ($query) {
			echo "<script>alert('User deleted successfully!');</script>";
		} else {
			echo "<script>alert('Error deleting user!');</script>";
		}
		echo "<script>window.location.href='manage_users.php'</script>";
	}
	

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Users</title>
    <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link type="text/css" href="css/theme.css" rel="stylesheet">
    <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
    <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
    <style>
        .action-btn {
            background-color: #0095ff;
            color: white;
            border-radius: 50%;
            padding: 8px;
            display: inline-block;
            text-align: center;
        }
        .action-btn i {
            font-size: 14px;
        }
    </style>
</head>
<body>
<?php include('include/header.php');?>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <?php include('include/sidebar.php');?>				
            <div class="span9">
                <div class="content">

                    <div class="module">
                        <div class="module-head">
                            <h3>Manage Users</h3>
                        </div>
                        <div class="module-body table">

                            <?php if(isset($_SESSION['delmsg'])) { ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong><?php echo htmlentities($_SESSION['delmsg']); ?></strong>
                            </div>
                            <?php unset($_SESSION['delmsg']); } ?>

                            <br />

                            <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact No</th>
                                        <th>Shipping Address</th>
                                        <th>Billing Address</th>
                                        <th>Reg. Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $query=mysqli_query($con,"SELECT * FROM users");
                                $cnt=1;
                                while($row=mysqli_fetch_array($query)) { ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php echo htmlentities($row['name']);?></td>
                                        <td><?php echo htmlentities($row['email']);?></td>
                                        <td><?php echo htmlentities($row['contactno']);?></td>
                                        <td><?php echo htmlentities($row['shippingAddress'].", ".$row['shippingCity'].", ".$row['shippingState']." - ".$row['shippingPincode']);?></td>
                                        <td><?php echo htmlentities($row['billingAddress'].", ".$row['billingCity'].", ".$row['billingState']." - ".$row['billingPincode']);?></td>
                                        <td><?php echo htmlentities($row['regDate']);?></td>
                                        <td>
                                            <a href="edit-user.php?id=<?php echo $row['id']?>" class="action-btn">
                                                <i class="icon-edit"></i>
                                            </a>
                                            <a href="manage_users.php?id=<?php echo $row['id']; ?>&del=delete"
                                             onclick="return confirm('Are you sure you want to delete this user?');"
                                              class="action-btn">
                                                <i class="icon-remove-sign"></i>
                                                 </a>

                                            </a>
                                        </td>
                                    </tr>
                                <?php $cnt=$cnt+1; } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>						

                </div><!--/.content-->
            </div><!--/.span9-->
        </div>
    </div><!--/.container-->
</div><!--/.wrapper-->

<?php include('include/footer.php');?>

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

    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = "manage_users.php?id=" + id + "&del=delete";
        }
        return false;
    }
</script>
</body>
<?php } ?>
