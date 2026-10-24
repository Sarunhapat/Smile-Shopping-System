<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แนะนำตัวเอง</title>
    <link rel="website icon" type="png" href="prmsr.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg'); 
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1); 
            backdrop-filter: blur(10px); 
            z-index: 0;
        }

        .container {
            position: relative;
            width: 50%;
            margin: auto;
            background: #B4EBE6; 
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 50px;
            z-index: 1;
        }

        img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 3px solid #555;
            object-fit: cover;
        }

        h1 {
            color: #333;
        }

        p {
            font-size: 24px;
            color: #666;
        }

        .contact {
            margin-top: 20px;
            font-size: 16px;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        .video-container {
            margin-top: 20px;
        }

        video {
            width: 100%;
            max-width: 600px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="background-overlay"></div>

<div class="container">
    <?php
        $name = "นายภูรินท์ มีศิริ";
        $nickname = "อ้น";
        $bio = "เป็นนักศึกษาคณะเทคโนโลยีสารสนเทศ สาขาวิทยาการคอมพิวเตอร์ สนใจเทคโนโลยีใหม่ๆ และชอบศึกษาเกี่ยวกับ PHP, JavaScript และฐานข้อมูล";
        $email = "poorin.mee@mail.pbru.ac.th";
        $facebook = "https://www.facebook.com/phu.ri.nth.mi.siri/";
        $image = "poorin.jpg"; 
    ?>

    <img src="<?= $image ?>" alt="Profile Picture">
    <h1>654244128</h1>
    <h1><?= $name ?> (<?= $nickname ?>)</h1>
    <p><?= $bio ?></p>
    
    <div class="contact">
        <p>📧 อีเมล: <a href="mailto:<?= $email ?>"><?= $email ?></a></p>
        <p>📌 Facebook: <a href="<?= $facebook ?>" target="_blank">กดที่นี่</a></p>
    </div>

    <div class="video-container">
        <h2>วิดีโอแนะนำ</h2>
        <video controls>
            <source src="MAX.mp4" type="video/mp4">
            <p>เบราว์เซอร์ของคุณไม่รองรับวิดีโอ</p>
        </video>
    </div>
</div>

</body>
</html>
