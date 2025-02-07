<?php
session_start();
require_once(__DIR__ . '/connect.php');

if (isset($_POST['login'])) {
    if (!empty($_POST['username'] &&  !empty($_POST['password']))) {
        $username = $connect->real_escape_string($_POST['username']);
        $password = $connect->real_escape_string($_POST['password']);

        $sql = "SELECT * FROM user WHERE username = '$username' LIMIT 1";
        $result = $connect->query($sql);

        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $password_data = $row["password"];
        
            if (password_verify($password, $password_data)) {
               if ($row['status'] == 'enable') {
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["role"] = $row["role"];
                $_SESSION["f_name"] = $row["f_name"];
                $_SESSION["l_name"] = $row["l_name"];

                switch ($row["role"]) {
                    case 'admin':
                        // echo "คุณเป็นผู้ดูแลระบบ";
                        header("Location: ../public/admin/index.php");
                        exit();
                    case 'moderator':
                        // echo "คุณเป็นผู้ควบคุมระบบ";
                        header("Location: ../public/moderator/index.php");
                        exit();
                    case 'user':
                        // echo "คุณเป็นผู้ใช้งานทั่วไป";
                        header("Location: ../public/user/index.php");
                        exit();
                    default:
                        // echo "บทบาทผู้ใช้ไม่ถูกต้อง";
                        header("Location: ../public/login.php");
                        exit();
                }
               } else {
                // echo "โดนแบน";
                $_SESSION['alert'] = "unsuccess";
                header('Location: ../public/login.php');
                exit();
               }
            } else {
                // echo "รหัสผ่านไม่ถูกต้อง";
                $_SESSION['alert'] = "unsuccess";
                header('Location: ../public/login.php');
                exit();
            }
        } else {
            // echo "ไม่พบผู้ใช้งาน";
            $_SESSION['alert'] = "unsuccess";
            header('Location: ../public/login.php');
            exit();
        }
    } else {
        // echo "กรุณากรอกข้อมูลให้ครบถ้วน"; // username or password ว่าง
        $_SESSION['alert'] = "unsuccess";
        header('Location: ../public/login.php');
        exit();
    }
} else {
    // echo "คำขอไม่ถูกต้อง"; // ไม่เข้าเงื่อนไข login
    $_SESSION['alert'] = "unsuccess";
    header('Location: ../public/login.php');
    exit();
}



?>