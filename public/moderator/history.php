<?php
    session_start();
    require_once __DIR__ . '/../../private/connect.php';
    require_once __DIR__ . '/check.php';
    include_once __DIR__ . '/../asset/header/header-moderator.php';


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
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-100">
    <div class="container mx-auto px-4 py-8 max-w-screen-xl">
        <!-- Search Form -->
        <div class="mb-8 card bg-base-200 shadow-sm">
            <div class="card-body">
                <form action="" method="get" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <input type="search" name="search" placeholder="Search..." 
                               class="input input-bordered w-full" 
                               value="<?= !empty($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    </div>
                    <div>
                        <select name="type" class="select select-bordered w-full">
                            <option value="history.history_id" <?= !empty($_GET['type']) && $_GET['type'] == 'history.history_id' ? 'selected' : '' ?>>History ID</option>
                            <option value="book.book_name" <?= !empty($_GET['type']) && $_GET['type'] == 'book.book_name' ? 'selected' : '' ?>>Book Name</option>
                            <option value="user.f_name" <?= !empty($_GET['type']) && $_GET['type'] == 'user.f_name' ? 'selected' : '' ?>>First Name</option>
                            <option value="user.l_name" <?= !empty($_GET['type']) && $_GET['type'] == 'user.l_name' ? 'selected' : '' ?>>Last Name</option>
                            <option value="history.status" <?= !empty($_GET['type']) && $_GET['type'] == 'history.status' ? 'selected' : '' ?>>Status</option>
                            <option value="history.confirmer" <?= !empty($_GET['type']) && $_GET['type'] == 'history.confirmer' ? 'selected' : '' ?>>Confirmer</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary w-full">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- History Table -->
        <div class="card bg-base-200 shadow-sm">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr class="bg-base-300">
                                <th>History ID</th>
                                <th>Book Name</th>
                                <th>Borrow Date</th>
                                <th>Return Date</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Confirmer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php foreach($result->fetch_all(MYSQLI_ASSOC) as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['history_id']) ?></td>
                                        <td><?= htmlspecialchars($row['book_name']) ?></td>
                                        <td><?= htmlspecialchars($row['borrow_date']) ?></td>
                                        <td><?= htmlspecialchars($row['return_date']) ?? '---' ?></td>
                                        <td><?= htmlspecialchars($row['f_name'] . ' ' . $row['l_name']) ?></td>
                                        <td>
                                            <?php $status = strtolower($row['status'] ?? ''); ?>
                                            <span class="badge <?= match($status) {
                                                'returned' => 'badge-success',
                                                'received' => 'badge-info',
                                                'wait' => 'badge-warning',
                                                'missing' => 'badge-Error',
                                                'acknowledge' => 'badge-Error',
                                                default => 'badge-neutral'
                                            } ?>"><?= $row['status'] ?? '---' ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($row['confirmer']) ?? '---' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 py-4">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>