<?php
    session_start();
    require_once __DIR__ . '/../connect.php';

    if(isset($_SESSION['user_id']) && isset($_POST['update'])){
        if(!empty($_POST['f_name']) && !empty($_POST['l_name']) && !empty($_POST['email']) && !empty($_POST['password'])){
            $user_id = $connect->real_escape_string($_SESSION['user_id']);
            $f_name = $connect->real_escape_string($_POST['f_name']);
            $l_name = $connect->real_escape_string($_POST['l_name']);
            $email = $connect->real_escape_string($_POST['email']);

            $sql = "SELECT * FROM user WHERE user_id = '$user_id' ";
            $result = $connect->query($sql);
            $row = $result->fetch_assoc();
            $password_data = $row['password'];

            $password = $connect->real_escape_string($_POST['password']);
            if(password_verify($password, $password_data)){
                $sql = "UPDATE user SET f_name = '$f_name', l_name = '$l_name', email = '$email' ";
                if(!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
                    $new_password = $connect->real_escape_string($_POST['new_password']);
                    $confirm_password = $connect->real_escape_string($_POST['confirm_password']);
                    if($new_password == $confirm_password){
                        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                        $sql .= ", password = '$new_password' ";
                    }else{
                        echo "Password does not match";
                        $_SESSION['alert'] = "unsuccess";
                        header("Location: ../../public/admin/profile.php");
                        exit();
                    }
                }

                $sql .= " WHERE user_id = '$user_id'";
                $result = $connect->query($sql);
                if($result){
                    echo "success";
                    $_SESSION['alert'] = "success";
                    header("Location: ../../public/admin/profile.php");
                    exit();
                }else{
                    echo "unsuccess can't query";
                    $_SESSION['alert'] = "unsuccess";
                    header("Location: ../../public/admin/profile.php");
                    exit();
                }
                }else{
                    echo "passwod incorrect";
                    $_SESSION['alert'] = "unsuccess";
                    header("Location: ../../public/admin/profile.php");
                    exit();
                }
            }else{
                echo "empty data";
                $_SESSION['alert'] = "unsuccess";
                header("Location: ../../public/admin/profile.php");
                exit();
            }

        }
    
    
    
    
        
?>