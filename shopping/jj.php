<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แนะนำตัวเอง</title>
    
</head>
<script>
        function toggleAbout() {
            var aboutSection = document.getElementById("about-section");
            if (aboutSection.style.display === "none" || aboutSection.style.display === "") {
                aboutSection.style.display = "block";
            } else {
                aboutSection.style.display = "none";
            }
        }
    </script>
<body>
    <style>

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('P3.jpg') no-repeat center center fixed;
    background-size: cover;
    filter: blur(10px); 
    z-index: -1;
}

.container {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    max-width: 600px;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    text-align: center;
}
.profile img {
    width: 190px;
    height: 220px;
    border-radius: 50%;
    margin-bottom: 15px;
}

h1 {
    margin: 10px 0;
    color: #333;
}

p {
    color: #555;
}

.social-links a {
    display: inline-block;
    margin: 10px;
    padding: 10px 15px;
    text-decoration: none;
    color: white;
    background: #007bff;
    border-radius: 5px;
}

.social-links a:hover {
    background: #0056b3;
}

.btn-about {
    display: inline-block;
    margin: 15px;
    padding: 10px 15px;
    text-decoration: none;
    color: white;
    background: #007bff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-about:hover {
    background: #007bff;
}
    </style>
       
    <div class="container">
        <div class="profile">
            <img src="photo/photo01.jpg" alt="รูปโปรไฟล์">
            <h1>นาย ปัณชณัชญ์ ประภากรณ์ (เจเจ)</h1>
            <p>คณะเทคโนโลยีสารสนเทศ | สาขาวิทยาการคอมพิวเตอร์</p>
            <p>ได้รับหน้าที่เป็น Design</p>
            <p>Email : punchanut.pra@mail.pbru.ac.th</p>
            <div class="social-links">
                <a href="https://www.facebook.com/punchanut.prapakorn" target="_blank">Facebook</a>
                <a href="https://www.instagram.com/punchanut_jin/" target="_blank">instagram</a>
                <button onclick="toggleAbout()" class="btn-about">personal record</button>   
            </div>
            <div id="about-section" style="display: none; margin-top: 20px;">
                <h2>ประวัติส่วนตัว</h2>
                <p><strong>ชื่อ:</strong> นาย ปัณชณัชญ์ ประภากรณ์ (เจเจ)</p>
                <p><strong>วันเกิด:</strong> 5 กันยายน 2003</p>
                <p><strong>สิ่งที่ชอบ:</strong> นอน, ฟังเพลง และ เล่นเกม🎮</p>
                <p><strong>เบอร์โทร:</strong> 0800492675 </p>
            </div>
        </div>
    </div>
</body>
</html>