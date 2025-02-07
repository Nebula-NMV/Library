<?php 
    session_start();
    require_once __DIR__ . '/../connect.php';

if(isset($_POST['borrow'])){
    if(!empty($_POST['book_id']) && !empty($_SESSION['user_id'])){
    $book_id = $connect->real_escape_string($_POST['book_id']);
    $user_id = $connect->real_escape_string($_SESSION['user_id']);

    $sql = "INSERT INTO history(`book_id`, `user_id`, `status`) VALUES ('$book_id', '$user_id', 'wait');"; 
    // $sql .= "UPDATE book SET book_stock = book_stock - 1 WHERE book_id = '$book_id'; "; 
       
    if ($connect->query($sql)){
        $_SESSION['alert'] = "success";
        header("Location: ../../public/moderator/book.php");
        exit();
    }
    else{
        $_SESSION['alert'] = "unsuccess";
        header("Location: ../../public/moderator/book.php");
        exit();
    }
    
    }else {
        $_SESSION['alert'] = "unsuccess";
        header("Location: ../../public/moderator/book.php");
        exit();
    }

}



?>