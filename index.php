<?php 
session_start();

if(!empty($_SESSION["user_id"]) || !empty($_SESSION['role']) || !empty($_SESSION['f_name']) || !empty($_SESSION['l_name'])){
    if($_SESSION['role'] == 'admin'){
        header("Location: ./public/admin/index.php");
        exit();
    }else if($_SESSION['role'] == 'moderator'){
        header("Location: ./public/moderator/index.php");
        exit();
    }elseif($_SESSION['role'] == 'user'){
        header('Location: ./public/user/index.php');
        exit();
    }else{
        header('Location: ./public/login.php');
        exit();
    }
}else{
    header('Location: ./public/login.php');
    exit();
}



?>