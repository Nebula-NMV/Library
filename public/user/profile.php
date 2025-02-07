<?php
    session_start();
    require_once __DIR__ . '/../../private/connect.php';  // เชื่อมต่อฐานข้อมูล
    require_once __DIR__ . '/check.php'; // เช็คสิทธิ์
    include_once __DIR__ . '/../asset/header/header-user.php';

    $sql = "SELECT * FROM user WHERE user_id = {$_SESSION['user_id']}";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <div>
        <form action="../../private/user/profile.php" method="post">
            <div>
                <div>
                    <label for="std_id">Student id</label>
                    <input type="text" name="std_id" id="std_id" disabled value="<?= !empty($row['std_id']) ? htmlspecialchars($row['std_id']) : '' ?>" >
                </div>
                <div>
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" disabled value="<?= !empty($row['username']) ? htmlspecialchars($row['username']) : '' ?>" >
                </div>
                <div>
                    <label for="password">Change password</label>
                    <input type="password" name="new_password" id="password" placeholder="New Password" >
                    <input type="password" name="confirm_password" placeholder="Confirm Password" >
                </div>
                <div>
                    <label for="f_name">First name</label>
                    <input type="text" name="f_name" id="f_name" value="<?= !empty($row['f_name']) ? htmlspecialchars($row['f_name']) : '' ?>" >
                </div>
                <div>
                    <label for="l_name">Last name</label>
                    <input type="text" name="l_name" id="l_name" value="<?= !empty($row['l_name']) ? htmlspecialchars($row['l_name']) : '' ?>" >
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?= !empty($row['email']) ? htmlspecialchars($row['email']) : '' ?>" >
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password">
                </div>
                <div>
                    <button type="submit" name="update">Update</button>
                </div>
            </div>
        </form>
    </div>






<?php
    if(!empty($_SESSION['alert'])){
        switch($_SESSION['alert']){
            case 'success':
                echo "<script>alert('Success')</script>";
                unset($_SESSION['alert']);
                break;
            case 'unsuccess':
                echo "<script>alert('Unsuccess')</script>";
                unset($_SESSION['alert']);
                break;
        } 

    }
// $connect->close();
?>
</body>
</html>