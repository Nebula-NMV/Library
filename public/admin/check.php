<?php 
if (empty($_SESSION['user_id']) || empty($_SESSION['role']) || empty($_SESSION['f_name']) || empty($_SESSION['l_name'])) {
        header("Location: ../index.php");
    }
if ($_SESSION['role'] != 'admin') {
        header("Location: ../index.php");
}
?>