<?php
session_start();
//error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:.php');
}
else{
	// อัพเดตที่อยู่สำหรับออกใบแจ้งหนี้
	if(isset($_POST['update']))
	{
		$baddress=$_POST['billingaddress'];
		$bstate=$_POST['bilingstate'];
		$bcity=$_POST['billingcity'];
		$bpincode=$_POST['billingpincode'];
		$query=mysqli_query($con,"update users set billingAddress='$baddress',billingState='$bstate',billingCity='$bcity',billingPincode='$bpincode' where id='".$_SESSION['id']."'");
		if($query)
		{
echo "<script>alert('อัพเดตที่อยู่สำหรับออกใบแจ้งหนี้เรียบร้อยแล้ว');</script>";
		}
	}

	// อัพเดตที่อยู่สำหรับจัดส่งสินค้า
	if(isset($_POST['shipupdate']))
	{
		$saddress=$_POST['shippingaddress'];
		$sstate=$_POST['shippingstate'];
		$scity=$_POST['shippingcity'];
		$spincode=$_POST['shippingpincode'];
		$query=mysqli_query($con,"update users set shippingAddress='$saddress',shippingState='$sstate',shippingCity='$scity',shippingPincode='$spincode' where id='".$_SESSION['id']."'");
		if($query)
		{
echo "<script>alert('อัพเดตที่อยู่สำหรับจัดส่งสินค้าเรียบร้อยแล้ว');</script>";
		}
	}
?>

<!DOCTYPE html>
<html lang="th">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	    <title>บัญชีของฉัน</title>

	    <!-- Bootstrap Core CSS -->
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
	</head>
    <body class="cnt-home">
<header class="header-style-1">

	<!-- เมนูด้านบน -->
<?php include('includes/top-header.php');?>
<?php include('includes/main-header.php');?>
<?php include('includes/menu-bar.php');?>

</header>

<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="#">หน้าแรก</a></li>
				<li class='active'>การชำระเงิน</li>
			</ul>
		</div>
	</div>
</div>

<div class="body-content outer-top-bd">
	<div class="container">
		<div class="checkout-box inner-bottom-sm">
			<div class="row">
				<div class="col-md-8">
					<div class="panel-group checkout-steps" id="accordion">

<!-- ขั้นตอนที่ 1: ที่อยู่สำหรับออกใบแจ้งหนี้ -->
<div class="panel panel-default checkout-step-01">
	<div class="panel-heading">
    	<h4 class="unicase-checkout-title">
	        <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
	          <span>1</span> ที่อยู่สำหรับออกใบแจ้งหนี้
	        </a>
	     </h4>
    </div>

	<div id="collapseOne" class="panel-collapse collapse in">
	    <div class="panel-body">
			<div class="row">		
				<div class="col-md-12 col-sm-12 already-registered-login">

<?php
$query=mysqli_query($con,"select * from users where id='".$_SESSION['id']."'");
while($row=mysqli_fetch_array($query))
{
?>
					<form class="register-form" role="form" method="post">
						<div class="form-group">
						    <label class="info-title">ที่อยู่สำหรับออกใบแจ้งหนี้ <span>*</span></label>
						    <textarea class="form-control" name="billingaddress" required><?php echo $row['billingAddress'];?></textarea>
						</div>
						<div class="form-group">
						    <label class="info-title">จังหวัด <span>*</span></label>
						    <input type="text" class="form-control" name="bilingstate" value="<?php echo $row['billingState'];?>" required>
						</div>
						<div class="form-group">
						    <label class="info-title">อำเภอ/เขต <span>*</span></label>
						    <input type="text" class="form-control" name="billingcity" value="<?php echo $row['billingCity'];?>" required>
						</div>
						<div class="form-group">
						    <label class="info-title">รหัสไปรษณีย์ <span>*</span></label>
						    <input type="text" class="form-control" name="billingpincode" value="<?php echo $row['billingPincode'];?>" required>
						</div>
						<button type="submit" name="update" class="btn btn-primary">อัพเดต</button>
					</form>
<?php } ?>
				</div>	
			</div>			
		</div>
	</div>
</div>

<!-- ขั้นตอนที่ 2: ที่อยู่สำหรับจัดส่งสินค้า -->
<div class="panel panel-default checkout-step-02">
	<div class="panel-heading">
    	<h4 class="unicase-checkout-title">
	        <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseTwo">
	          <span>2</span> ที่อยู่สำหรับจัดส่งสินค้า
	        </a>
	     </h4>
    </div>

	<div id="collapseTwo" class="panel-collapse collapse">
	    <div class="panel-body">
<?php
$query=mysqli_query($con,"select * from users where id='".$_SESSION['id']."'");
while($row=mysqli_fetch_array($query))
{
?>
					<form class="register-form" role="form" method="post">
						<div class="form-group">
						    <label class="info-title">ที่อยู่สำหรับจัดส่งสินค้า <span>*</span></label>
						    <textarea class="form-control" name="shippingaddress" required><?php echo $row['shippingAddress'];?></textarea>
						</div>
						<div class="form-group">
						    <label class="info-title">จังหวัด <span>*</span></label>
						    <input type="text" class="form-control" name="shippingstate" value="<?php echo $row['shippingState'];?>" required>
						</div>
						<div class="form-group">
						    <label class="info-title">อำเภอ/เขต <span>*</span></label>
						    <input type="text" class="form-control" name="shippingcity" value="<?php echo $row['shippingCity'];?>" required>
						</div>
						<div class="form-group">
						    <label class="info-title">รหัสไปรษณีย์ <span>*</span></label>
						    <input type="text" class="form-control" name="shippingpincode" value="<?php echo $row['shippingPincode'];?>" required>
						</div>
						<button type="submit" name="shipupdate" class="btn btn-primary">อัพเดต</button>
					</form>
<?php } ?>
	    </div>
	</div>
</div>

					</div>
				</div>
			<?php include('includes/myaccount-sidebar.php');?>
			</div>
		</div>
	</div>
</div>

<?php include('includes/footer.php');?>
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>
