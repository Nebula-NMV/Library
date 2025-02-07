<?php
    session_start();
    require_once __DIR__ . '/../../private/connect.php';
    require_once __DIR__ . '/check.php';
    include_once __DIR__ . '/../asset/header/header-admin.php';


    $sql = "SELECT 
    book.book_name,
    history.borrow_date,
    history.return_date,
    user.f_name,
    user.l_name,
    history.history_id,
    history.status,
    history.confirmer
    FROM history 
    INNER JOIN book ON history.book_id = book.book_id
    INNER JOIN user ON history.user_id = user.user_id";
    if(!empty($_GET['type']) && !empty($_GET['search'])){
        $type = $connect->real_escape_string($_GET['type']);
        $search = $connect->real_escape_string($_GET['search']);
        $sql .= " WHERE $type LIKE '%$search%' ";
    }
    $sql .= " ORDER BY history.history_id DESC";
    $result = $connect->query($sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
</head>
<body>
    <div>

        <div>
            <form action="" method="get">
                <input type="search" name="search" placeholder="search" value="<?= !empty($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" >
                <select name="type" >
                    <option value="history.history_id" <?= !empty($_GET['type']) && $_GET['type'] == 'history.history_id' ? 'selected' : '' ?>>History ID</option>
                    <option value="book.book_name" <?= !empty($_GET['type']) && $_GET['type'] == 'book.book_name' ? 'selected' : '' ?>>Book Name</option>
                    <option value="user.f_name" <?= !empty($_GET['type']) && $_GET['type'] == 'user.f_name' ? 'selected' : '' ?>>First Name</option>
                    <option value="user.l_name" <?= !empty($_GET['type']) && $_GET['type'] == 'user.l_name' ? 'selected' : '' ?>>Last Name</option>
                    <option value="history.status" <?= !empty($_GET['type']) && $_GET['type'] == 'history.status' ? 'selected' : '' ?>>Status</option>
                    <option value="history.confirmer" <?= !empty($_GET['type']) && $_GET['type'] == 'history.confirmere' ? 'selected' : '' ?>>Confirmer</option>
                </select>
                <button type="submit">search</button>

        </div>

    <div>
        <table>
            <tr>
                <th>History ID</th>
                <th>Book Name</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Status</th>
                <th>Confirmer</th>
            </tr>
            <?php 
                if ($rows = $result->fetch_all(MYSQLI_ASSOC)) {
                    foreach($rows as $row){ ?>
                <tr>
                    <td><?= !empty($row['history_id']) ? htmlspecialchars($row['history_id']) : "---" ?></td>
                    <td><?= !empty($row['book_name']) ? htmlspecialchars($row['book_name']) : "---" ?></td>
                    <td><?= !empty($row['borrow_date']) ? htmlspecialchars($row['borrow_date']) : "---" ?></td>
                    <td><?= !empty($row['return_date']) ? htmlspecialchars($row['return_date']) : "---" ?></td>
                    <td><?= !empty($row['f_name']) ? htmlspecialchars($row['f_name']) : "---" ?></td>
                    <td><?= !empty($row['l_name']) ? htmlspecialchars($row['l_name']) : "---" ?></td>
                    <td><?= !empty($row['status']) ? htmlspecialchars($row['status']) : "---" ?></td>
                    <td><?= !empty($row['confirmer']) ? htmlspecialchars($row['confirmer']) : "---" ?></td>
                </tr>
                <?php } 
                }else{ ?>
                    <tr>
                        <td>Don't Have Data</td>
                    </tr>
                <?php } ?>








        </table>
        </div>





    </div>




</body>
</html>