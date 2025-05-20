<?php
session_start();

if (isset($_SESSION['last_page'])) {
    $last_page = $_SESSION['last_page'];
    unset($_SESSION['last_page']); // ล้างค่า session
    header("Location: $last_page");
    exit();
}



if (!empty($_SESSION["user_id"]) && !empty($_SESSION['role']) && !empty($_SESSION['f_name']) && !empty($_SESSION['l_name'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: ./admin/index.php");
        exit();
    } else if ($_SESSION['role'] == 'moderator') {
        header("Location: ./moderator/index.php");
        exit();
    } elseif ($_SESSION['role'] == 'user') {
        header('Location: ./user/index.php');
        exit();
    } else {
        header('Location: ./login.php');
        exit();
    }
}


header("Location: login.php"); // ถ้าไม่มีหน้าล่าสุดให้ไปหน้าแรก
exit();
