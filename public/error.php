<?php
session_start();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Error</title>
</head>
<body>
    <h2>ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้</h2>
    <p>กรุณารอสักครู่ แล้วระบบจะกลับไปยังหน้าก่อนหน้านี้อัตโนมัติ</p>

    <script>
        setInterval(() => {
            fetch("../private/check_db.php") // ตรวจสอบว่า Database กลับมาใช้ได้หรือยัง
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "OK") {
                        window.location.href = "index.php"; // กลับไปหน้าเดิม
                    }
                });
        }, 15000); // เช็คทุก 15 วินาที
    </script>



    
</body>
</html>
