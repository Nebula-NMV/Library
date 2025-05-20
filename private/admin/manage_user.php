<?php 
    session_start();
    require_once __DIR__ . '/../connect.php';
    if(isset($_POST['update'])) {
      if(!empty($_POST['user_id']) && !empty($_POST['std_id']) && !empty($_POST['f_name']) && !empty($_POST['l_name']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['status']) ){
        $user_id = $connect->real_escape_string($_POST['user_id']);
        $std_id = $connect->real_escape_string($_POST['std_id']);
        $f_name = $connect->real_escape_string($_POST['f_name']);
        $l_name = $connect->real_escape_string($_POST['l_name']);
        $username = $connect->real_escape_string($_POST['username']);
        $email = $connect->real_escape_string($_POST['email']);
        $status = $connect->real_escape_string($_POST['status']);
        $sql = "UPDATE user SET std_id = '$std_id', f_name = '$f_name', l_name = '$l_name', username = '$username', email = '$email', status = '$status' ";


        if(!empty($_POST['new_password'])){
          $new_password = $connect->real_escape_string($_POST['new_password']);
          $new_password = password_hash($new_password, PASSWORD_DEFAULT);
          $sql .= ", password = '$new_password' ";
        }

        if(!empty($_POST['role'])){
            $role = $connect->real_escape_string($_POST['role']);
            $sql .= ", role = '$role' ";
        }
    

        $sql .= " WHERE user_id = '$user_id'";

        if($connect->query($sql)){
            echo "success";
            $_SESSION['alert'] = "success";
            header("Location: ../../public/admin/manage_user.php");
            exit();
        }else{
            echo "unsuccess";
            $_SESSION['alert'] = "unsuccess";
            header("Location: ../../public/admin/manage_user.php");
            exit();
        }
      }else{
        echo "unsuccess";
        $_SESSION['alert'] = "unsuccess";
        header("Location: ../../public/admin/manage_user.php");
        exit();
      }
    }


// if(isset($_POST['delete'])) {
//     if(!empty($_POST['user_id'])){

//         $user_id = $connect->real_escape_string($_POST['user_id']);
//         $sql = "DELETE FROM user WHERE user_id = '$user_id'";
//         if($connect->query($sql)){
//             echo "success";
//             $_SESSION['alert'] = "success";
//             header("Location: ../../public/admin/manage_user.php");
//             exit();
//         }else{
//             echo "unsuccess";
//             $_SESSION['alert'] = "unsuccess";
//             header("Location: ../../public/admin/manage_user.php");
//             exit();
//         }
//         }else{
//             echo "unsuccess";
//             $_SESSION['alert'] = "unsuccess";
//             header("Location: ../../public/admin/manage_user.php");
//             exit();
//     }

// }



?>