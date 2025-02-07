<?php
    session_start();
    require_once __DIR__ . '/../../private/connect.php'; // เชื่อมต่อฐานข้อมูล
    require_once __DIR__ .'/check.php'; // เช็คสิทธิ์
    include_once __DIR__ . '/../asset/header/header-admin.php';

    $sql = "SELECT * FROM user";
    if (!empty($_GET['search'])) {
        $sql .= " WHERE {$_GET['type']} LIKE '%{$_GET['search']}%'";
    }
    $sql .= " ORDER BY f_name ASC;";
    $result = $connect->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage_User</title>
</head>

<body>
    <div>
        <form action="" method="get">
            <div>
                <input type="search" name="search" placeholder="search" value="<?php echo htmlspecialchars($_GET['search'] ?? '') ?>">
                <select name="type">
                    <option value="std_id" <?= !empty($_GET['type']) && $_GET['type'] == 'std_id' ? 'selected' : '' ?> >Student id</option>
                    <option value="f_name" <?= !empty($_GET['type']) && $_GET['type'] == 'f_name' ? 'selected' : '' ?> >First Name</option>
                    <option value="l_name" <?= !empty($_GET['type']) && $_GET['type'] == 'l_name' ? 'selected' : '' ?> >Last Name</option>
                    <option value="username" <?= !empty($_GET['type']) && $_GET['type'] == 'username' ? 'selected' : '' ?> >Username</option>
                    <option value="email" <?= !empty($_GET['type']) && $_GET['type'] == 'email' ? 'selected' : '' ?> >Email</option>
                    <option value="status" <?= !empty($_GET['type']) && $_GET['type'] == 'status' ? 'selected' : '' ?> >Status</option>
                </select>
                <button type="submit">search</button>
            </div>
        </form>
    </div>


    <div>
        <table>
            <tr>
                <th>Student id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            
            <?php 
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                        <form action="../../private/admin/manage_user.php" method="post">
                        <tr>
                            <input type="hidden" name="user_id" value="<?= !empty($row['user_id']) ? htmlspecialchars($row['user_id']) : '' ?>"  <?=!empty($row['role']) && $row['role'] == 'admin' ? 'disabled' : '' ?>>
                            <td><input type="number" name="std_id" value="<?= !empty($row['std_id']) ? htmlspecialchars($row['std_id']) : '' ?>" <?=!empty($row['role']) && $row['role'] == 'admin' ? 'disabled' : '' ?>></td>
                            <td><input type="text" name="f_name" value="<?= !empty($row['f_name']) ? htmlspecialchars($row['f_name']) : '' ?>" <?=!empty($row['role']) && $row['role'] == 'admin' ? 'disabled' : '' ?>></td>
                            <td><input type="text" name="l_name" value="<?= !empty($row['l_name']) ? htmlspecialchars($row['l_name']) : '' ?>" <?=!empty($row['role']) && $row['role'] == 'admin' ? 'disabled' : '' ?>></td>
                            <td><input type="text" name="username" value="<?= !empty($row['username']) ? htmlspecialchars($row['username']) : '' ?>" <?=!empty($row['role']) && $row['role'] == 'admin' ? 'disabled' : '' ?>></td>
                            <td><input type="password" name="new_password" placeholder="new-password" <?=!empty($row['role']) && $row['role'] == 'admin' ? 'disabled' : '' ?>></td>
                            <td><input type="email" name="email" value="<?= !empty($row['email']) ? htmlspecialchars($row['email']) : '' ?>" <?=!empty($row['role']) && $row['role'] == 'admin' ? 'disabled' : '' ?>></td>
                            <td>
                                <select name="role" <?=!empty($row['role']) && $row['role'] == 'admin' ? 'disabled' : '' ?>>
                                    <option value="admin" disabled <?= (!empty($row['role']) && $row['role'] == 'admin'  ? 'selected' : '')?>>Admin</option>
                                    <option value="modetator" <?= !empty($row['role']) && $row['role'] == 'moderator'  ? 'selected' : '' ?>>Moderator</option>
                                    <option value="user" <?= !empty($row['role']) && $row['role'] == 'user'  ? 'selected' : '' ?>>User</option>
                                </select>
                            </td>
                            <td>
                                <select name="status" <?=!empty($row['role']) && $row['role'] == 'admin' ? 'disabled' : '' ?>>
                                <option value="enable" <?= !empty($row['status']) && $row['status'] == 'enable'  ? 'selected' : '' ?>>enable</option>
                                <option value="disable" <?= !empty($row['status']) && $row['status'] == 'disable'  ? 'selected' : '' ?>>disable</option>
                                </select>
                            </td>
                            <td><?= !empty($row['role']) && $row['role'] == 'admin' ? '' : '<button type="submit" name="update" >Update</button> <button type="submit" name="delete" >Delete</button>' ?>
                            </tr>
                        </form>
                <?php
                }
            }else{
                ?>
                <tr>
                    <td colspan="8">no data</td>
                </tr>
                <?php
            }
            ?>
           

        </table>

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
    $connect->close();
?>
</body>
</html>