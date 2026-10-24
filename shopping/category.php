<?php
session_start();
error_reporting(0);
include('includes/config.php');
$cid=intval($_GET['cid']);

if(isset($_GET['action']) && $_GET['action']=="add"){
	$id=intval($_GET['id']);
	if(isset($_SESSION['cart'][$id])){
		$_SESSION['cart'][$id]['quantity']++;
	}else{
		$sql_p="SELECT * FROM products WHERE id={$id}";
		$query_p=mysqli_query($con,$sql_p);
		if(mysqli_num_rows($query_p)!=0){
			$row_p=mysqli_fetch_array($query_p);
			$_SESSION['cart'][$row_p['id']]=array("quantity" => 1, "price" => $row_p['productPrice']);
			echo "<script>alert('เพิ่มสินค้าไปยังตะกร้าเรียบร้อยแล้ว')</script>";
			echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
		}else{
			$message="รหัสสินค้าผิดพลาด";
		}
	}
}

// เพิ่มสินค้าไปยังรายการโปรด
if(isset($_GET['pid']) && $_GET['action']=="wishlist" ){
	if(strlen($_SESSION['login'])==0)
    {   
		header('location:login.php');
	}
	else {
		mysqli_query($con,"INSERT INTO wishlist(userId,productId) VALUES('".$_SESSION['id']."','".$_GET['pid']."')");
		echo "<script>alert('เพิ่มสินค้าไปยังรายการโปรดเรียบร้อยแล้ว');</script>";
		header('location:my-wishlist.php');
	}
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>หมวดหมู่สินค้า</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
</head>
<body class="cnt-home">

<header class="header-style-1">
	<?php include('includes/top-header.php');?>
	<?php include('includes/main-header.php');?>
	<?php include('includes/menu-bar.php');?>
</header>

<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="#">หน้าแรก</a></li>
				<li class='active'>หมวดหมู่สินค้า</li>
			</ul>
		</div>
	</div>
</div>

<div class="body-content outer-top-xs">
	<div class='container'>
		<div class='row outer-bottom-sm'>
			<div class='col-md-3 sidebar'>

<!-- เมนูหมวดหมู่ -->
<div class="side-menu animate-dropdown outer-bottom-xs">       
	<div class="head"><i class="icon fa fa-align-justify fa-fw"></i>หมวดหมู่ย่อย</div>        
	<nav class="yamm megamenu-horizontal" role="navigation">
		<ul class="nav">
			<li class="dropdown menu-item">
				<?php $sql=mysqli_query($con,"SELECT id,subcategory FROM subcategory WHERE categoryid='$cid'");
				while($row=mysqli_fetch_array($sql)) { ?>
					<a href="sub-category.php?scid=<?php echo $row['id'];?>" class="dropdown-toggle"><i class="icon fa fa-desktop fa-fw"></i>
					<?php echo $row['subcategory'];?></a>
				<?php }?>
			</li>
		</ul>
	</nav>
</div>

			</div><!-- /.sidebar -->
			<div class='col-md-9'>

	<!-- แสดงสินค้าในหมวดหมู่ -->
	<div id="category" class="category-carousel hidden-xs">
		<div class="item">	
			<div class="image">
				<img src="assets/images/banners/cat-banner-1.jpg" alt="" class="img-responsive">
			</div>
			<div class="container-fluid">
				<div class="caption vertical-top text-left">
					<div class="big-text">
						<br />
					</div>

					<?php $sql=mysqli_query($con,"SELECT categoryName FROM category WHERE id='$cid'");
					while($row=mysqli_fetch_array($sql)) { ?>
						<div class="excerpt hidden-sm hidden-md">
							<?php echo htmlentities($row['categoryName']);?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

	<div class="search-result-container">
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane active " id="grid-container">
				<div class="category-product inner-top-vs">
					<div class="row">									
						<?php
						$ret=mysqli_query($con,"SELECT * FROM products WHERE category='$cid'");
						$num=mysqli_num_rows($ret);
						if($num>0) {
							while ($row=mysqli_fetch_array($ret)) {?>							
								<div class="col-sm-6 col-md-4 wow fadeInUp">
									<div class="products">				
										<div class="product">		
											<div class="product-image">
												<div class="image">
													<a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>">
														<img src="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" alt="" width="200" height="300">
													</a>
												</div>	                      		   	   
											</div>
											
											<div class="product-info text-left">
												<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['productName']);?></a></h3>
												<div class="product-price">	
													<span class="price">฿<?php echo htmlentities($row['productPrice']);?></span>
													<span class="price-before-discount">฿<?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
												</div>
											</div>

											<div class="cart clearfix animate-effect">
												<div class="action">
													<ul class="list-unstyled">
														<li class="add-cart-button btn-group">
															<?php if($row['productAvailability']=='In Stock'){?>
																<a href="category.php?page=product&action=add&id=<?php echo $row['id']; ?>">
																	<button class="btn btn-info" type="button">เพิ่มลงตะกร้า</button>
																</a>
															<?php } else { ?>
																<div class="action" style="color:red">สินค้าหมด</div>
															<?php } ?>
														</li>
														<li class="lnk wishlist">
															<a class="add-to-wishlist" href="category.php?pid=<?php echo htmlentities($row['id'])?>&&action=wishlist" title="เพิ่มลงรายการโปรด">
																<i class="icon fa fa-heart"></i>
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php } } else { ?>
								<div class="col-sm-6 col-md-4 wow fadeInUp"> <h3>ไม่พบสินค้า</h3></div>
							<?php } ?>	
					</div>
				</div>
			</div>
		</div>
	</div>

			</div><!-- /.col -->
		</div>
	</div>
</div>

<?php include('includes/footer.php');?>
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>
