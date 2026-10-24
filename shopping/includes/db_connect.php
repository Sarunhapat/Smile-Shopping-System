<?php
// เชื่อมต่อฐานข้อมูล (แก้ไขข้อมูลตามของคุณ)
$con = new mysqli("localhost", "root", "", "shopping");

// ตรวจสอบการเชื่อมต่อ
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
