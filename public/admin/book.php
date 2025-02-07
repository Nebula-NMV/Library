<?php
    session_start();
    require_once __DIR__ . "/../../private/connect.php"; // เชื่อมต่อฐานข้อมูล
    require_once __DIR__ ."/check.php"; // เช็คสิทธิ์
    include_once __DIR__ . "/../asset/header/header-admin.php";

    $sql = "SELECT * FROM book WHERE book_status = 'enable'";
    if (!empty($_GET['search']) && !empty($_GET['type'])) {
        $sql .= "AND {$_GET['type']} LIKE '%{$_GET['search']}%'";
    }
    $sql .= " ORDER BY CASE WHEN book_stock <= 0 THEN 1 ELSE 0 END ASC,
        book_id DESC;";
    $result = $connect->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book</title>
</head>

<body>

    <div>
        <form action="" method="get">
            <div>
                <input type="search" name="search" placeholder="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <select name="type">
                    <option value="book_name" <?= ($_GET['type'] ?? '') == 'book_name' ? 'selected' : '' ?>>Book name</option>
                    <option value="book_category" <?= ($_GET['type'] ?? '') == 'book_category' ? 'selected' : '' ?>>Book category</option>
                </select>
                <button type="submit" >search</button>
            </div>
        </form>
    </div>

    <div>
        <?php if ($result->num_rows > 0) {?>
<?php while ($row = $result->fetch_assoc()) {?>
                <div>
                    <form action="../../private/admin/book.php" method="post">
                        <div>
                            <img src="../asset/book/<?= !empty($row['book_image']) ? htmlspecialchars($row['book_image']) : 'default.png' ?>" alt="book_image">
                            <div>
                                <input type="hidden" name="book_id" value="<?php echo $row['book_id'] ?? '' ?>">
                                <div>
                                    <p><?= !empty($row['book_name']) ? htmlspecialchars($row['book_name']) : "Don't Have Data" ?></p>
                                </div>
                                <div>
                                    <p><?= !empty($row['description']) ? htmlspecialchars($row['description']) : "Don't Have Data" ?></p>
                                </div>
                                <div>
                                    <p><?= !empty($row['book_category']) ? htmlspecialchars($row['book_category']) : "Don't Have Data" ?></p>
                                </div>
                                <div>
                                    <p><?= isset($row['book_stock']) ? htmlspecialchars($row['book_stock']) : "Don't Have Data"?></p>
                                </div>
                            </div>

                            <?= 
                            !empty($row['book_stock']) && $row['book_stock'] > 0 ? 
                            '<button type="submit" name="borrow">Borrow</button>' : 
                            '<button disabled >out of stock</button>' 
                            ?>
                        </div>

                    </form>
                </div>
            <?php } ?>
<?php }else{
    echo "No Data";
} ?>
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