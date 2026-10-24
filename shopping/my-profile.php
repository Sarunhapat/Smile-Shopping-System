<?php 
session_start();
include_once('includes/config.php');
if(strlen($_SESSION['id'])==0)
{   
    header('location:logout.php');
}
else{

// อัปเดตโปรไฟล์ผู้ใช้
if(isset($_POST['update']))
{
    $name = $_POST['fullname'];
    $uid = $_SESSION['id'];
    $contactno = $_POST['contactnumber'];
    $query = mysqli_query($con,"UPDATE users SET name='$name', contactno='$contactno' WHERE id='$uid'");
    if($query)
    {
        echo "<script>alert('อัปเดตโปรไฟล์สำเร็จ');</script>";
        echo "<script type='text/javascript'> document.location ='my-profile.php'; </script>";
    }
    else
    {
        echo "<script>alert('เกิดข้อผิดพลาด กรุณาลองอีกครั้ง');</script>";
        echo "<script type='text/javascript'> document.location ='my-profile.php'; </script>";
    } 
}
?>
<!DOCTYPE html>
<html lang="th">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>ร้านค้า | สมัครสมาชิก</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/jquery.min.js"></script>
    </head>
    <style type="text/css"></style>
    <body>
<?php include_once('includes/header.php'); ?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">

<?php 
$uid = $_SESSION['id'];
$query = mysqli_query($con,"SELECT * FROM users WHERE id='$uid'");
while($result = mysqli_fetch_array($query)){
?>
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">โปรไฟล์ของ <?php echo htmlentities($result['name']);?></h1>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 mt-5">
                <form method="post" name="profile">
                    <div class="row">
                        <div class="col-2">ชื่อ-นามสกุล</div>
                        <div class="col-6">
                            <input type="text" name="fullname" value="<?php echo htmlentities($result['name']);?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-2">อีเมล</div>
                        <div class="col-6">
                            <input type="email" name="emailid" id="emailid" class="form-control" value="<?php echo htmlentities($result['email']);?>" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-2">เบอร์โทรศัพท์</div>
                        <div class="col-6">
                            <input type="text" name="contactnumber" value="<?php echo htmlentities($result['contactno']);?>" pattern="[0-9]{10}" title="กรุณากรอกหมายเลขโทรศัพท์ 10 หลัก" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">&nbsp;</div>
                        <div class="col-6">
                            <input type="submit" name="update" id="update" class="btn btn-primary" value="อัปเดต" required>
                        </div>
                    </div>
                </form>
            </div>
<?php } ?>
        </section>
        <!-- Footer-->
   <?php include_once('includes/footer.php'); ?>
        <!-- Bootstrap core JS-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php } ?>
