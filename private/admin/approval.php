<?php
session_start();
require_once __DIR__ . '/../connect.php';

if(isset($_POST['approve'])){
    if(!empty($_POST['history_id']) && !empty($_SESSION['f_name']) && !empty($_SESSION['l_name'])){
        $history_id = $connect->real_escape_string($_POST['history_id']);
        $f_name = $connect->real_escape_string($_SESSION['f_name']);
        $l_name = $connect->real_escape_string($_SESSION['l_name']);
        // $sql = "UPDATE history SET status = 'borrowing' WHERE history_id = '$history_id'";
        $sql = "UPDATE history INNER JOIN book ON history.book_id = book.book_id SET history.status = 'borrowing', book.book_stock = book.book_stock - 1,borrow_date = CURRENT_TIMESTAMP, confirmer = '" . $f_name . " " . $l_name . "' WHERE history.history_id = '$history_id'";
        $result = $connect->query($sql);
        if($result){
            echo "success";
            $_SESSION['alert'] = "success";
            header("Location: ../../public/admin/approval.php");
            exit();
        }else{
            echo "unsuccess";
            $_SESSION['alert'] = "unsuccess";
            header("Location: ../../public/admin/approval.php");
            exit();
        }
        }else{
        echo "unsuccess";
        $_SESSION['alert'] = "unsuccess";
        header("Location: ../../public/admin/approval.php");
        exit();
        }
    }




if(isset($_POST['deny'])){
    if(!empty($_POST['history_id']) && !empty($_SESSION['f_name']) && !empty($_SESSION['l_name'])){
    $history_id = $connect->real_escape_string($_POST['history_id']);
    $f_name = $connect->real_escape_string($_SESSION['f_name']);
    $l_name = $connect->real_escape_string($_SESSION['l_name']);

    $sql = "UPDATE history SET status = 'deny', confirmer = '" . $f_name . " " . $l_name . "' WHERE history_id = '$history_id'";
    $result = $connect->query($sql);
    if($result){
        echo "success";
        $_SESSION['alert'] = "success";
        header("Location: ../../public/admin/approval.php");
        exit();
    }else{
        echo "unsuccess";
        $_SESSION['alert'] = "unsuccess";
        header("Location: ../../public/admin/approval.php");
        exit();
    }
    }else{
        echo "unsuccess";
        $_SESSION['alert'] = "unsuccess";
        header("Location: ../../public/admin/approval.php");
        exit();
    }
}



if(isset($_POST['received'])){
    if(!empty($_POST['history_id']) && !empty($_SESSION['f_name']) && !empty($_SESSION['l_name'])){
    $history_id = $connect->real_escape_string($_POST['history_id']);
    $f_name = $connect->real_escape_string($_SESSION['f_name']);
    $l_name = $connect->real_escape_string($_SESSION['l_name']);

    $sql = "UPDATE history INNER JOIN book ON history.book_id = book.book_id SET history.status = 'received', book.book_stock = book.book_stock + 1, return_date = CURRENT_TIMESTAMP, confirmer = '" . $f_name . " " . $l_name . "' WHERE history.history_id = '$history_id'";
    $result = $connect->query($sql);
    if($result){
        echo "success";
        $_SESSION['alert'] = "success";
        header("Location: ../../public/admin/approval.php");
        exit();
    }else{
        echo "unsuccess";
        $_SESSION['alert'] = "unsuccess";
        header("Location: ../../public/admin/approval.php");
        exit();
    }
    }else{
        echo "unsuccess";
        $_SESSION['alert'] = "unsuccess";
        header("Location: ../../public/admin/approval.php");
        exit();
    }
}



if(isset($_POST['acknowledge'])){
    if(!empty($_POST['history_id']) && !empty($_SESSION['f_name']) && !empty($_SESSION['l_name'])){
    $history_id = $connect->real_escape_string($_POST['history_id']);
    $f_name = $connect->real_escape_string($_SESSION['f_name']);
    $l_name = $connect->real_escape_string($_SESSION['l_name']);

    $sql = "UPDATE history SET status = 'acknowledge', return_date = CURRENT_TIMESTAMP, confirmer = '" . $f_name . " " . $l_name . "' WHERE history_id = '$history_id'";
    $result = $connect->query($sql);
    if($result){
        echo "success";
        $_SESSION['alert'] = "success";
        header("Location: ../../public/admin/approval.php");
        exit();
    }else{
        echo "unsuccess";
        $_SESSION['alert'] = "unsuccess";
        header("Location: ../../public/admin/approval.php");
        exit();
    }
    }else{
        echo "unsuccess";
        $_SESSION['alert'] = "unsuccess";
        header("Location: ../../public/admin/approval.php");
        exit();
    }
}



?>