<?php
session_start();
require_once __DIR__ . '/../../private/connect.php';
require_once __DIR__ .'/check.php';
include_once __DIR__ . '/../asset/header/header-moderator.php';

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
    WHERE user.user_id = {$_SESSION['user_id']} ";  // Space added after WHERE

if (!empty($_GET['search']) && !empty($_GET['type'])) {
    $search = $connect->real_escape_string($_GET['search']);
    $type = $connect->real_escape_string($_GET['type']);
    $sql .= " AND $type LIKE '%$search%'";  // Added space before AND
}
$sql .= " ORDER BY history_id DESC;";

$result = $connect->query($sql);
if(!$result){
    die("Connection failed: " . $connect->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowing Status</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen p-0">
    <div class="max-w-7xl mx-auto">
        <!-- Search Form -->
        <form action="" method="get" class="mb-8">
            <div class="flex flex-col md:flex-row gap-2 items-center">
                <div class="join flex-1 w-full">
                    <input 
                        type="search" 
                        name="search" 
                        placeholder="Search history..." 
                        class="input input-bordered join-item w-full"
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                    >
                    <select 
                        name="type" 
                        class="select select-bordered join-item md:w-48"
                    >
                        <option value="book.book_name" <?= selected('book.book_name') ?>>Book Name</option>
                        <option value="book.book_category" <?= selected('book.book_category') ?>>Category</option>
                        <option value="history.status" <?= selected('history.status') ?>>Status</option>
                    </select>
                    <button type="submit" class="btn btn-primary join-item">
                        Search
                    </button>
                </div>
            </div>
        </form>

        <!-- History List -->
        <div class="grid grid-cols-1 gap-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <form action="../../private/moderator/status.php" method="post">
                        <div class="card bg-white shadow-lg hover:shadow-xl transition-shadow duration-200">
                            <div class="card-body">
                                <input type="hidden" name="history_id" value="<?= htmlspecialchars($row['history_id']) ?>">
                                
                                <div class="flex flex-col md:flex-row gap-4 items-start">
                                    <!-- Book Cover -->
                                    <figure class="flex-shrink-0 w-full md:w-32">
                                        <img 
                                            src="../asset/book/<?= !empty($row['book_image']) ? htmlspecialchars($row['book_image']) : 'default.png' ?>" 
                                            alt="Book Cover" 
                                            class="rounded-lg w-full h-32 object-cover"
                                        >
                                    </figure>
                                    
                                    <!-- Details -->
                                    <div class="flex-1 space-y-2">
                                        <h2 class="card-title text-lg">
                                            <?= htmlspecialchars($row['book_name']) ?>
                                        </h2>
                                        
                                        <div class="grid grid-cols-2 gap-2 text-sm">
                                            <div>
                                                <p class="text-gray-500">Borrow Date:</p>
                                                <p><?= htmlspecialchars($row['borrow_date']) ?></p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Return Date:</p>
                                                <p><?= htmlspecialchars($row['return_date'] ?? '---') ?></p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Status:</p>
                                                <span class="badge <?= status_badge($row['status']) ?>">
                                                    <?= htmlspecialchars($row['status']) ?>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Confirmed by:</p>
                                                <p><?= htmlspecialchars($row['confirmer'] ?? '---') ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="w-full md:w-auto space-y-2">
                                        <?php if ($row['status'] == 'borrowing'): ?>
                                            <button 
                                                type="submit" 
                                                name="return" 
                                                class="btn btn-success w-full md:w-32"
                                            >
                                            Return the book
                                            </button>
                                            <button 
                                                type="submit" 
                                                name="missing" 
                                                class="btn btn-error w-full md:w-32"
                                            >
                                                Report Missing
                                            </button>
                                        <?php elseif ($row['status'] == 'wait'): ?>
                                            <button 
                                                type="submit" 
                                                name="cancel" 
                                                class="btn btn-warning w-full md:w-32"
                                            >
                                                Cancel
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-500 text-lg">No borrowing history found</p>
                </div>
            <?php endif; ?>
        </div>
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

<?php
function selected($type) {
    return (!empty($_GET['type']) && $_GET['type'] == $type) ? 'selected' : '';
}

function status_badge($status) {
    switch(strtolower($status)) {
        case 'wait': return 'badge-warning';
        case 'borrowing': return 'badge-success';
        case 'returned': return 'badge-info';
        case 'missing': return 'badge-error';
        default: return 'badge-outline';
    }
}
?>