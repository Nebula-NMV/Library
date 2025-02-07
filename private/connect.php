<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "library2";

$connect = new mysqli($servername, $username, $password, $database);

// $host = "sql305.infinityfree.com"; // Check if this is correct
// $username = "if0_37579233";
// $password = "Lm7ofxqDNThxb2";
// $database = "if0_37579233_library";

// $connect = new mysqli($host, $username, $password, $database);

if ($connect->connect_error) {
    session_start();
    // $_SESSION['alert'] = 'error';
    $_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
    session_write_close();

    // หา root ของโปรเจกต์โดยอิงจาก DOCUMENT_ROOT และ path ของไฟล์ที่ถูก include
    $projectRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] . "/library2.0")); // แก้ตามโปรเจกต์
    // แปลง path เป็น URL
    $baseURL = str_replace($_SERVER['DOCUMENT_ROOT'], '', $projectRoot);
    // Redirect ไปยัง login.php
    // header("Location: " . $baseURL . "/public/login.php");
    header("Location: " . $baseURL . "/public/error.php");
    // exit();
    die("Connection failed: " . $connect->connect_error);
}

$connect->set_charset("utf8mb4");

?>