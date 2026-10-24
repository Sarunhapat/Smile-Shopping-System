<?php 
session_start();
error_reporting(0);
include('includes/config.php');

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if(strlen($_SESSION['login'])==0) {   
    header('location:login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>ประวัติการสั่งซื้อ</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/red.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <script>
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
                                        <th>ค่าจัดส่ง</th>
                                        <th>ราคารวม</th>
                                        <th>วิธีการชำระเงิน</th>
                                        <th>วันที่สั่งซื้อ</th>
                                        <th>ติดตามคำสั่งซื้อ</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php 
// ใช้ Prepared Statement เพื่อความปลอดภัย
$userId = $_SESSION['id'];
$stmt = $con->prepare("SELECT p.productImage1, p.productName, p.id as proid, o.productId as opid, o.quantity, p.productPrice, p.shippingCharge, o.paymentMethod, o.orderDate, o.id as orderid 
                        FROM orders o 
                        JOIN products p ON o.productId = p.id 
                        WHERE o.userId = ? AND o.paymentMethod IS NOT NULL");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$cnt=1;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
?>
                                    <tr>
                                        <td><?php echo $cnt;?></td>
                                        <td class="cart-image">
                                            <a class="entry-thumbnail" href="product-details.php?pid=<?php echo $row['opid'];?>">
                                                <img src="admin/productimages/<?php echo $row['proid'];?>/<?php echo $row['productImage1'];?>" alt="" width="84" height="146">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="product-details.php?pid=<?php echo $row['opid'];?>"><?php echo $row['productName'];?></a>
                                        </td>
                                        <td><?php echo $row['quantity']; ?></td>
                                        <td><?php echo number_format($row['productPrice'], 2); ?> บาท</td>
                                        <td><?php echo number_format($row['shippingCharge'], 2); ?> บาท</td>
                                        <td><?php echo number_format(($row['quantity'] * $row['productPrice']) + $row['shippingCharge'], 2); ?> บาท</td>
                                        <td><?php echo $row['paymentMethod']; ?></td>
                                        <td><?php echo $row['orderDate']; ?></td>
                                        <td>
                                            <a href="javascript:void(0);" onClick="popUpWindow('track-order.php?oid=<?php echo htmlentities($row['orderid']);?>');" title="ติดตามคำสั่งซื้อ">
                                                ติดตาม
                                            </a>
                                        </td>
                                    </tr>
<?php 
        $cnt++;
    }
} else {
    echo "<tr><td colspan='10' class='text-center'><strong>ยังไม่มีคำสั่งซื้อ</strong></td></tr>";
}
$stmt->close();
?>
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
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/echo.min.js"></script>
<script src="assets/js/jquery.easing-1.3.min.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/jquery.rateit.min.js"></script>
<script src="assets/js/lightbox.min.js"></script>
<script src="assets/js/bootstrap-select.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/scripts.js"></script>

</body>
</html>
