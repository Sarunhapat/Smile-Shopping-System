        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php">Shopping Portal</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about-us.php">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="index.php">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="shop-categories.php">Categor Wise</a></li>
                            </ul>
                        </li>
<?php if($_SESSION['id']==0){?>
          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Users</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="login.php">Login</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="signup.php">Sign Up</a></li>
                            </ul>
                        </li>
                                     <li class="nav-item"><a class="nav-link" href="admin/">Admin</a></li>
                    <?php } else {?>
                        <li class="nav-item"><a class="nav-link" href="my-wishlist.php">My Wishlist</a></li>
                                  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">My Account</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="my-orders.php">Orders</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="my-profile.php">Profile</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="change-password.php">Change Password</a></li>
                                  <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="manage-addresses.php">Adresses</a></li>
                                  <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                     <?php } ?>  
                      <li class="nav-item"><a class="nav-link" href="contact-us.php">Contact us</a></li> 
        
                    </ul>  
<?php if($_SESSION['id']!=0):?>
<strong>Welcome:</strong> <?php echo $_SESSION['username'];?> &nbsp;
<?php endif;?>
                    <form class="d-flex">


                    <?php 
$uid = $_SESSION['id'];

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
if ($uid) {
    $query = "SELECT SUM(cart.quantity) AS qtyy, SUM(products.productPrice * cart.quantity) AS total 
              FROM cart 
              JOIN products ON cart.productId = products.id 
              WHERE cart.userId='$uid'";

    $result = mysqli_query($con, $query);

    // ตรวจสอบว่า Query ทำงานสำเร็จหรือไม่
    if (!$result) {
        die("Error in SQL Query: " . mysqli_error($con)); // แสดง error ถ้า SQL ผิด
    }

    $row = mysqli_fetch_array($result);
    $cartTotal = isset($row['total']) ? $row['total'] : 0;
    $cartcount = isset($row['qtyy']) ? $row['qtyy'] : 0;
} else {
    $cartTotal = 0;
    $cartcount = 0;
}
?>
