<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['login'])==0) {   
    header('location:login.php');
} else {
    // โค้ดสำหรับลบสินค้าจาก Wishlist  
    $wid=intval($_GET['del']);
    if(isset($_GET['del'])) {
        $query=mysqli_query($con,"DELETE FROM wishlist WHERE id='$wid'");
    }

    if(isset($_GET['action']) && $_GET['action']=="add") {
        $id=intval($_GET['id']);
        $query=mysqli_query($con,"DELETE FROM wishlist WHERE productId='$id'");
        if(isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $sql_p="SELECT * FROM products WHERE id={$id}";
            $query_p=mysqli_query($con,$sql_p);
            if(mysqli_num_rows($query_p)!=0) {
                $row_p=mysqli_fetch_array($query_p);
                $_SESSION['cart'][$row_p['id']]=array("quantity" => 1, "price" => $row_p['productPrice']);    
                header('location:my-wishlist.php');
            } else {
                $message="รหัสสินค้าที่ไม่ถูกต้อง";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>สินค้าที่ชื่นชอบ</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/red.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="shortcut icon" href="assets/images/favicon.ico">
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
                <li><a href="home.html">หน้าแรก</a></li>
                <li class='active'>สินค้าที่ชื่นชอบ</li>
            </ul>
        </div>
    </div>
</div>

<div class="body-content outer-top-bd">
    <div class="container">
        <div class="my-wishlist-page inner-bottom-sm">
            <div class="row">
                <div class="col-md-12 my-wishlist">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="4">สินค้าที่ชื่นชอบ</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$ret=mysqli_query($con,"SELECT products.productName as pname, products.id as pid, products.productImage1 as pimage, products.productPrice as pprice, wishlist.id as wid FROM wishlist JOIN products ON products.id=wishlist.productId WHERE wishlist.userId='".$_SESSION['id']."'");
$num=mysqli_num_rows($ret);
if($num>0) {
    while ($row=mysqli_fetch_array($ret)) {
?>
                                <tr>
                                    <td class="col-md-2">
                                        <img src="admin/productimages/<?php echo htmlentities($row['pid']);?>/<?php echo htmlentities($row['pimage']);?>" alt="<?php echo htmlentities($row['pname']);?>" width="60" height="100">
                                    </td>
                                    <td class="col-md-6">
                                        <div class="product-name">
                                            <a href="product-details.php?pid=<?php echo htmlentities($row['pid']);?>">
                                                <?php echo htmlentities($row['pname']);?>
                                            </a>
                                        </div>
                                        <div class="price">฿<?php echo htmlentities($row['pprice']);?>.00</div>
                                    </td>
                                    <td class="col-md-2">
                                        <a href="my-wishlist.php?page=product&action=add&id=<?php echo $row['pid']; ?>" class="btn btn-primary">เพิ่มลงตะกร้า</a>
                                    </td>
                                    <td class="col-md-2 close-btn">
                                        <a href="my-wishlist.php?del=<?php echo htmlentities($row['wid']);?>" onClick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบ?')" class="">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
<?php 
    } 
} else { 
?>
                                <tr>
                                    <td style="font-size: 18px; font-weight:bold ">ยังไม่มีสินค้าที่ชื่นชอบ</td>
                                </tr>
<?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/brands-slider.php');?>
    </div>
</div>
<?php include('includes/footer.php');?>

<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/echo.min.js"></script>
<script src="assets/js/jquery.easing-1.3.min.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/jquery.rateit.min.js"></script>
<script type="text/javascript" src="assets/js/lightbox.min.js"></script>
<script src="assets/js/bootstrap-select.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/scripts.js"></script>

</body>
</html>
<?php } ?>
