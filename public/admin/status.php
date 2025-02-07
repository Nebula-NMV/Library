<?php
session_start();
require_once __DIR__ . '/../../private/connect.php';  // เชื่อมต่อฐานข้อมูล
require_once __DIR__ .'/check.php'; // เช็คสิทธิ์
include_once __DIR__ . '/../asset/header/header-admin.php';

    $sql = "SELECT 
    book.book_id,
    book.book_name,
    book.book_image,
    user.user_id,
    history.history_id,
    history.borrow_date,
    history.return_date,
    history.status,
    history.confirmer
    FROM history 
    INNER JOIN book ON history.book_id = book.book_id
    INNER JOIN user ON history.user_id = user.user_id
    WHERE user.user_id = {$_SESSION['user_id']} ";

if (!empty($_GET['search']) && !empty($_GET['type'])) {
    $search = $connect->real_escape_string($_GET['search']);
    $type = $connect->real_escape_string($_GET['type']);
    $sql .= "AND $type LIKE '%$search%'";
}
    $sql .= "ORDER BY history_id DESC;";

    $result = $connect->query($sql);
    if(!$result){
        die("Connection failed: " . $connect->connect_error);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status</title>
</head>
<body>

<div>
    <form action="" method="get">
        <div>
            <input type="search"   name="search" id="search" placeholder="search" value="<?php echo htmlspecialchars($_GET['search'] ?? '') ?>">
            <select name="type" id="type">
                <option value="book.book_name" <?= !empty($_GET['type']) && $_GET['type'] == 'book.book_name' ? 'selected' : '' ?>>Book name</option>
                <option value="book.book_category" <?= !empty($_GET['type']) && $_GET['type']  == 'book.book_category' ? 'selected' : '' ?>>Book category</option>
                <option value="history.status" <?= !empty($_GET['type']) && $_GET['type']  == 'history.status' ? 'selected' : '' ?>>Status</option>
            </select>
            <button type="submit" name="search">search</button>
        </div>
    </form>
</div>

<?php  
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div>
            <form action="../../private/admin/status.php" method="post">    
            <div>
                <div>
                 <img src="../asset/book/<?= !empty($row['book_image']) ?  htmlspecialchars($row['book_image']) : 'default.png'?>"/>
                </div>
                <div>
                 <input type="hidden" name="history_id" placeholder="ห้ามแก้ไข" readonly value="<?= !empty($row['history_id']) ? htmlspecialchars($row['history_id']) : '' ?>" >
                <p><?= !empty($row['book_name']) ?  htmlspecialchars($row['book_name']) : '---' ?></p> 
                <p><?= !empty($row['borrow_date']) ? htmlspecialchars($row['borrow_date']) : '---'?></p>
                <p><?= !empty($row['return_date']) ?  htmlspecialchars($row['return_date']) : '---'?></p>
                <p><?= !empty($row['status']) ? htmlspecialchars($row['status']) : '---' ?></p>
                <p><?= !empty($row['confirmer']) ? htmlspecialchars($row['confirmer']) : '---' ?></p>
                </div>
                <div>
                <?= $row['status'] == 'borrowing' ? '<button type="submit" name="return">Return</button> <button type="submit" name="missing">Missing</button>' : '' ?>
                <?= $row['status'] == 'wait' ? '<button type="submit" name="cancle">cancle</button>' : '' ?>
                </div>
                </div>
            </form>
        </div><?php
    }
} else {
    ?>
    <div>
        <p>No data</p>
    </div>
    <?php
}

?>

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