<?php
    session_start();
    require_once __DIR__ . "/../../private/connect.php";
    require_once __DIR__ . "/check.php";
    include_once __DIR__ . "/../asset/header/header-moderator.php";


    $sql = "SELECT 
    book.book_id,
    book.book_image,
    book.book_name,
    book.book_stock,
    book.book_category,
    user.user_id,
    user.f_name,
    user.l_name,
    history.history_id,
    history.status,
    history.borrow_date,
    history.return_date
    FROM history 
    INNER JOIN book ON history.book_id = book.book_id 
    INNER JOIN user ON history.user_id = user.user_id 
    WHERE history.status = 'wait' OR history.status = 'returned' OR history.status = 'missing' 
    ORDER BY history.borrow_date ASC";  #DESC เรียงใหม่ไปเก่า
    $result = $connect->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval</title>
</head>
<body>
    
<div>
    <?php 
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            ?>
                <div>
                    <form action="../../private/moderator/approval.php" method="post">
                    <div>
<img src="../asset/book/<?= !empty($row['book_image']) ? htmlspecialchars($row['book_image']) : "default" ?>" alt="book_image">
                    </div>
                    <input type="hidden" name="history_id" value="<?= !empty($row['history_id']) ? htmlspecialchars($row['history_id']) : '' ?>">
                    <p><?= !empty($row['book_name']) ? htmlspecialchars($row['book_name']) : "" ?></p>
                    <p><?= !empty($row['book_category']) ? htmlspecialchars($row['book_category']) : "" ?></p>
                    <p><?= !empty($row['f_name']) && !empty($row['l_name']) ? htmlspecialchars($row['f_name']) . " " . htmlspecialchars($row['l_name']) : "" ?></p>
                    <p><?= !empty($row['borrow_date']) ? htmlspecialchars($row['borrow_date']) : "---" ?></p>
                    <div>
                    <?php if(!empty($row['status'])){
                        switch($row['status']){
                            case 'wait':
                                if (isset($row['book_stock']) && $row['book_stock'] > 0) {
                                    echo "<button type='submit' name='approve'>Approve</button>";
                                }
                                echo "<button type='submit' name='deny'>Deny</button>";
                                break;
                            case 'returned':
                                echo "<button type='submit' name='received'>Received</button>";
                                break;
                            case 'missing':
                                echo "<button type='submit' name='acknowledge'>Acknowledge</button>";
                                break;
                            default :
                                echo "<button disabled >Error</button>";
                                break;
                        }
                    } ?>
                    </div>
                    </form>
                </div>
            <?php
        }
    }else{
        echo "<p>No data</p>";
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
?>
</body>
</html>