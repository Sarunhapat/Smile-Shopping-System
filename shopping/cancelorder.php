<?php
session_start();
error_reporting(0);
include_once('includes/config.php');
if(isset($_POST['submit']))
  {
    
   $orderid=$_GET['oid'];
    $ressta="ยกเลิกแล้ว";
    $remark=$_POST['restremark'];
    $canclbyuser='ผู้ใช้';
 
    $query=mysqli_query($con,"INSERT INTO ordertrackhistory(orderId,remark,status,canceledBy) VALUES('$orderid','$remark','$ressta','$canclbyuser')"); 
    $query=mysqli_query($con, "UPDATE orders SET orderStatus='$ressta' WHERE id='$orderid'");
    if ($query) {
        echo '<script>alert("คำสั่งซื้อของคุณถูกยกเลิกเรียบร้อยแล้ว")</script>';
    } else {
        echo '<script>alert("มีบางอย่างผิดพลาด กรุณาลองใหม่อีกครั้ง")</script>';
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<title>ยกเลิกคำสั่งซื้อ</title>
</head>
<body>

<div style="margin-left:50px;">
<?php  
$orderid=$_GET['oid'];
$query=mysqli_query($con,"SELECT orderNumber, orderStatus FROM orders WHERE id='$orderid'");
$num=mysqli_num_rows($query);
$cnt=1;
?>
<?php  
while ($row=mysqli_fetch_array($query)) {
?>
<table border="1" cellpadding="10" style="border-collapse: collapse; border-spacing:0; width: 100%; text-align: center;">
  <tr align="center">
   <th colspan="4">ยกเลิกคำสั่งซื้อ #<?php echo  $row['orderNumber'];?></th> 
  </tr>
  <tr>
    <th>หมายเลขคำสั่งซื้อ</th>
    <th>สถานะปัจจุบัน</th>
  </tr>

  <tr> 
    <td><?php echo $row['orderNumber'];?></td> 
    <td><?php  
        $status = $row['orderStatus'];
        if($status == ""){
            echo "รอการยืนยัน";
        } else { 
            echo $status;
        }
    ?></td> 
  </tr>
<?php 
} ?>
</table>

<?php if($status == "" || $status == "บรรจุสินค้าแล้ว" || $status == "กำลังจัดส่ง" || $status == "อยู่ระหว่างขนส่ง") { ?>
<form method="post">
  <table>
    <tr>
      <th>เหตุผลในการยกเลิก</th>
      <td><textarea name="restremark" placeholder="กรุณาใส่เหตุผลในการยกเลิก" rows="5" cols="50" class="form-control wd-450" required></textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <button type="submit" name="submit" class="btn btn--box btn--small btn--blue btn--uppercase btn--weight">อัพเดตคำสั่งซื้อ</button>
      </td>
    </tr>
  </table>
</form>

<?php } else { ?>
  <?php if($status == 'ยกเลิกแล้ว'){ ?>
    <p style="color:red; font-size:20px;">คำสั่งซื้อนี้ถูกยกเลิกไปแล้ว ไม่จำเป็นต้องยกเลิกอีก</p>
  <?php } else { ?>
    <p style="color:red; font-size:20px;">คุณไม่สามารถยกเลิกคำสั่งซื้อนี้ได้ เนื่องจากคำสั่งซื้ออยู่ในสถานะ "กำลังนำส่ง" หรือ "จัดส่งสำเร็จ"</p>
  <?php } ?>
<?php } ?>

</div>

</body>
</html>
