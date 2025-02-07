<?php 

    session_start();
    require_once __DIR__ . "/connect.php"; 

if (isset($_POST['register'])) {
    if (!empty($_POST['std_id']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['confirm']) && !empty($_POST['email']) && !empty($_POST['f_name']) && !empty($_POST['l_name']) && !empty($_POST['email'])) {
            $std_id = $connect->real_escape_string($_POST['std_id']);
            $username = $connect->real_escape_string($_POST['username']);
            $password = $connect->real_escape_string($_POST['password']);
            $confirm = $connect->real_escape_string($_POST['confirm']);
            $f_name = $connect->real_escape_string($_POST['f_name']);
            $l_name = $connect->real_escape_string($_POST['l_name']);
            $email = $connect->real_escape_string($_POST['email']);
            
            if (!is_numeric($std_id)) {
                $_SESSION['alert'] = "unsuccess";
                header('Location: ../public/register.php');
                exit();
            }

            if($password != $confirm) {
                // echo "password not match";
                $_SESSION['alert'] = "unsuccess";
                header('Location: ../public/register.php');
                exit();
            }

            
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "SELECT * FROM user WHERE email = '$email' OR std_id = '$std_id' OR username = '$username'";
            $result = $connect->query($sql);
            if (!$result) {
                die("Database error: " . $connect->error);
            }
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['email'] == $email) {
                        // echo "มี email แล้ว";
                        $_SESSION['alert'] = "unsuccess";
                        header('Location: ../public/register.php');
                        exit();
                    }
                    if ($row['std_id'] == $std_id) {
                        // echo "มี student_id แล้ว";
                        $_SESSION['alert'] = "unsuccess";
                        header('Location: ../public/register.php');
                        exit();
                    }
                    if ($row['username'] == $username) {
                        // echo "มี username แล้ว";
                        $_SESSION['alert'] = "unsuccess";
                        header('Location: ../public/register.php');
                        exit();
                    }
                }
                header("Location: ../public/register.php");
                exit();
            }
            
            $sql = "INSERT INTO user (`user_id`, `std_id`, `username`, `password`, `f_name`, `l_name`, `email`, `role`, `status`) VALUES (NULL, '$std_id', '$username', '$password', '$f_name', '$l_name', '$email', 'user', 'enable')";
            $result = $connect->query($sql);
            if ($result) {
                // echo "สมัครสมาชิกสำเร็จ";
                $_SESSION['alert'] = "success";
                header('Location: ../public/register.php');
                exit();
            } else {
                // echo "สมัครสมาชิกไม่สำเร็จ";
                $_SESSION['alert'] = "unsuccess";
                header('Location: ../public/register.php');
                exit();
            }
        } else {
            // echo "กรุณากรอกข้อมูลให้ครบถ้วน";
            $_SESSION['alert'] = "unsuccess";
            header('Location: ../public/register.php');
            exit();
        }
    }

?>