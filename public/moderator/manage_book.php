<?php 
session_start();

    require_once __DIR__ . '/../../private/connect.php';
    require_once __DIR__ . '/check.php';
    include_once __DIR__ . '/../asset/header/header-moderator.php';

    $sql = "SELECT * FROM book";
    if (!empty($_GET['search']) && !empty($_GET['type'])) {
        $search = $connect->real_escape_string($_GET['search']);
        $type = $connect->real_escape_string($_GET['type']);
        $sql .= " WHERE $type LIKE '%$search%' ";
    }
    $sql .= " ORDER BY book_id DESC";

    $result = $connect->query($sql);
    if (!$result) {
        die("Query failed: " . $connect->error);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage_book</title>
</head>
<body>
    
    <div>
        <form action="" method="get">
            <div>
                <input type="search" name="search" placeholder="search" value="<?= !empty($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <select name="type">
                    <option value="book_name" <?= !empty($_GET['type']) && $_GET['type'] == 'book_name' ? 'selected' : '' ?>>Book Name</option>
                    <option value="book_category" <?= !empty($_GET['type']) && $_GET['type'] == 'book_category' ? 'selected' : '' ?>>Book Category</option>
                    <option value="book_stock" <?= !empty($_GET['type']) && $_GET['type'] == 'book_stock' ? 'selected' : '' ?>>Book Stock</option>
                    <option value="book_status" <?= !empty($_GET['type']) && $_GET['type'] == 'book_status' ? 'selected' : '' ?>>Book Status</option>
                </select>
                <button type="submit">Search</button>
            </div>
        </form>
    </div>


    <div>
        <form action="../../private/moderator/manage_book.php" method="post" enctype="multipart/form-data">
            <div>   
            <div>
                <input type="file" name="book_image" accept=".jpg, .jpeg, .png, .gif">
            </div>
            <div>
                <input type="text" name="book_name"  placeholder="Book Name">
            </div>
            <div>
                <input type="text" name="description"  placeholder="Description">
            </div>
            <div>
                <input type="text" name="book_category"  placeholder="Book category">
            </div>
            <div>
                <input type="number" name="book_stock"  placeholder="Book Stock">
            </div>
            <div>
                <select name="book_status" >
                    <option value="enable">Enable</option>
                    <option value="disable">Disable</option>
                </select>
            </div>
            <div>
                <button type="submit" name="add">Add</button>
            </div>
            </div>
        </form>
    </div>








    <div>

    <?php 
    if ($rows = $result->fetch_all(MYSQLI_ASSOC)) {
        foreach ($rows as $row) {?>
            <div>
            <form action="../../private/moderator/manage_book.php" method="post" enctype="multipart/form-data" >
                <div>
            <img src="<?= htmlspecialchars('../asset/book/' . (!empty($row['book_image']) ? $row['book_image'] : 'default')) ?>" alt="Book Image">
            </div>
            <div>
            <input type="file" name="book_image" >    
            </div>
            <div>
                <input type="hidden" name="book_id" value="<?= !empty($row['book_id']) ? htmlspecialchars($row['book_id']) : '' ?>">
            <input type="text" name="book_name"  value="<?= !empty($row['book_name']) ? htmlspecialchars($row['book_name']) : "don't have data" ?>">
            </div>
            <div>
                <input type="text" name="description"  value="<?= !empty($row['description']) ? htmlspecialchars($row['description']) : "don't have data" ?>">
            </div>
            <div>
            <input type="text" name="book_category"  value="<?= !empty($row['book_category']) ? htmlspecialchars($row['book_category']) : "don't have data" ?>">
            </div>
            <div>
            <input type="number" name="book_stock"  value="<?= !empty($row['book_stock']) ? htmlspecialchars($row['book_stock']) : "don't have data" ?>">
            </div>
            <div>
                <select name="book_status">
                    <option value="enable" <?= !empty($row['book_status']) && $row['book_status'] == "enable" ? 'selected' : '' ?>>Enable</option>
                    <option value="disable" <?= !empty($row['book_status']) && $row['book_status'] == "disable" ? 'selected' : '' ?>>Disable</option>
                </select>
            </div>
            <div>
                <button type="submit" name="update">Update</button>
                <button type="submit" name="delete">Delete</button>
            </div>
        </form>
            </div>
            <?php
        }
    }

    ?>

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