<?php
session_start();
include_once('includes/config.php');

// ตรวจสอบการรีเซ็ตรหัสผ่าน
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    
    // ป้องกัน CSRF Attack
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "<script>alert('Invalid CSRF token. Please try again.');</script>";
        exit();
    }

    // รับค่าจากฟอร์ม
    $username = trim($_POST['emailid']);
    $cnumber = trim($_POST['phoneno']);
    $newpassword = trim($_POST['inputPassword']);
    $confirmPassword = trim($_POST['cinputPassword']);

    // ตรวจสอบว่ารหัสผ่านตรงกัน
    if ($newpassword !== $confirmPassword) {
        echo "<script>alert('รหัสผ่านไม่ตรงกัน!');</script>";
        echo "<script>window.location.href='password-recovery.php';</script>";
        exit();
    }

    // ตรวจสอบความยาวของรหัสผ่าน
    if (strlen($newpassword) < 6) {
        echo "<script>alert('รหัสผ่านควรมีความยาวอย่างน้อย 6 ตัวอักษร');</script>";
        echo "<script>window.location.href='password-recovery.php';</script>";
        exit();
    }

    // ใช้ Prepared Statements เพื่อป้องกัน SQL Injection
    $stmt = $con->prepare("SELECT id FROM users WHERE email=? AND contactno=?");
    $stmt->bind_param("ss", $username, $cnumber);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // ตรวจสอบว่ามีผู้ใช้หรือไม่
    if ($result->num_rows > 0) {
        // เข้ารหัสรหัสผ่านแบบ bcrypt
        $hashedPassword = password_hash($newpassword, PASSWORD_BCRYPT);

        // อัปเดตรหัสผ่านใหม่
        $update_stmt = $con->prepare("UPDATE users SET password=? WHERE email=? AND contactno=?");
        $update_stmt->bind_param("sss", $hashedPassword, $username, $cnumber);
        $update_stmt->execute();

        echo "<script>alert('เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');</script>";
        echo "<script>window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('อีเมลหรือหมายเลขโทรศัพท์ไม่ถูกต้อง');</script>";
        echo "<script>window.location.href='password-recovery.php';</script>";
    }

    $stmt->close();
    $update_stmt->close();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopping | กู้คืนรหัสผ่าน</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script>
    function valid() {
        var password = document.passwordrecovery.inputPassword.value;
        var confirmPassword = document.passwordrecovery.cinputPassword.value;
        if (password !== confirmPassword) {
            alert("รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน!");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
<?php include_once('includes/header.php'); ?>

<header class="bg-dark py-5">
    <div class="container text-center text-white">
        <h1 class="display-4 fw-bolder">กู้คืนรหัสผ่าน</h1>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <form method="post" name="passwordrecovery" onSubmit="return valid();">
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); ?>">
            
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">อีเมล</label>
                <div class="col-sm-6">
                    <input type="email" name="emailid" class="form-control" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">หมายเลขโทรศัพท์</label>
                <div class="col-sm-6">
                    <input type="text" name="phoneno" class="form-control" pattern="[0-9]{10}" title="กรุณากรอกหมายเลขโทรศัพท์ 10 หลัก" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">รหัสผ่านใหม่</label>
                <div class="col-sm-6">
                    <input type="password" name="inputPassword" class="form-control" minlength="6" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">ยืนยันรหัสผ่าน</label>
                <div class="col-sm-6">
                    <input type="password" name="cinputPassword" class="form-control" minlength="6" required>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-sm-6 offset-sm-3">
                    <input type="submit" name="submit" class="btn btn-primary" value="รีเซ็ตรหัสผ่าน">
                </div>
            </div>
        </form>
    </div>
</section>

<?php include_once('includes/footer.php'); ?>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
