<?php 
session_start();
error_reporting(0);
include('includes/config.php');
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>ประวัติการสั่งซื้อ</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/red.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <script language="javascript" type="text/javascript">
    function popUpWindow(URLStr) {
        window.open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=600,height=600');
    }
    </script>
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
                <li class='active'>ประวัติการสั่งซื้อ</li>
            </ul>
        </div>
    </div>
</div>

<div class="body-content outer-top-xs">
    <div class="container">
        <div class="row inner-bottom-sm">
            <div class="shopping-cart">
                <div class="col-md-12 col-sm-12 shopping-cart-table">
                    <div class="table-responsive">
                        <form name="cart" method="post">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รูปภาพ</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>จำนวน</th>
                                        <th>ราคาต่อหน่วย</th>
                                        <th>ราคารวม</th>
                                        <th>วิธีการชำระเงิน</th>
                                        <th>วันที่สั่งซื้อ</th>
                                        <th>ติดตามคำสั่งซื้อ</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php 
$orderid=$_POST['orderid'];
$email=$_POST['email'];
$ret = mysqli_query($con,"SELECT t.email, t.id FROM (SELECT usr.email, odrs.id FROM users as usr JOIN orders as odrs ON usr.id=odrs.userId) as t WHERE t.email='$email' AND (t.id='$orderid')");
$num=mysqli_num_rows($ret);
if($num>0) {
    $query=mysqli_query($con,"SELECT products.productImage1 as pimg1, products.productName as pname, orders.productId as opid, orders.quantity as qty, products.productPrice as pprice, orders.paymentMethod as paym, orders.orderDate as odate, orders.id as orderid FROM orders JOIN products ON orders.productId=products.id WHERE orders.id='$orderid' AND orders.paymentMethod IS NOT NULL");
    $cnt=1;
    while($row=mysqli_fetch_array($query)) {
?>
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td class="cart-image">
                                            <a class="entry-thumbnail" href="product-details.php?pid=<?php echo $row['opid'];?>">
                                                <img src="admin/productimages/<?php echo $row['pname'];?>/<?php echo $row['pimg1'];?>" alt="" width="84" height="146">
                                            </a>
                                        </td>
                                        <td class="cart-product-name-info">
                                            <h4 class='cart-product-description'>
                                                <a href="product-details.php?pid=<?php echo $row['opid'];?>"><?php echo $row['pname'];?></a>
                                            </h4>
                                        </td>
                                        <td class="cart-product-quantity"><?php echo $qty=$row['qty']; ?></td>
                                        <td class="cart-product-sub-total"><?php echo $price=$row['pprice']; ?> บาท</td>
                                        <td class="cart-product-grand-total"><?php echo $qty*$price;?> บาท</td>
                                        <td class="cart-product-sub-total"><?php echo $row['paym']; ?></td>
                                        <td class="cart-product-sub-total"><?php echo $row['odate']; ?></td>
                                        <td>
                                            <a href="javascript:void(0);" onClick="popUpWindow('track-order.php?oid=<?php echo htmlentities($row['orderid']);?>');" title="ติดตามคำสั่งซื้อ">
                                                ติดตาม
                                            </a>
                                        </td>
                                    </tr>
<?php 
        $cnt=$cnt+1;
    } 
} else { 
?>
                                    <tr>
                                        <td colspan="9">รหัสคำสั่งซื้อหรืออีเมลไม่ถูกต้อง</td>
                                    </tr>
<?php } ?>
                                </tbody>
                            </table>
                        </form>
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
ห