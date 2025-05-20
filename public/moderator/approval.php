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
    ORDER BY history.borrow_date ASC";
    $result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval System</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen p-0">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <form action="../../private/moderator/approval.php" method="post">
                        <div class="card bg-white shadow-lg hover:shadow-xl transition-shadow duration-200">
                            <div class="card-body">
                                <input type="hidden" name="history_id" value="<?= htmlspecialchars($row['history_id']) ?>">
                                
                                <div class="flex flex-col md:flex-row gap-4">
                                    <!-- Book Image -->
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
                                        
                                        <div class="space-y-1">
                                            <div class="badge badge-outline">
                                                <?= htmlspecialchars($row['book_category']) ?>
                                            </div>
                                            <p class="text-sm">
                                                Borrower: <?= htmlspecialchars($row['f_name'] . ' ' . $row['l_name']) ?>
                                            </p>
                                            <p class="text-sm">
                                                Borrow Date: <?= htmlspecialchars($row['borrow_date']) ?>
                                            </p>
                                            <div class="badge <?= status_badge($row['status']) ?>">
                                                <?= htmlspecialchars($row['status']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="card-actions mt-4">
                                    <?php switch($row['status']):
                                        case 'wait': ?>
                                            <?php if ($row['book_stock'] > 0): ?>
                                                <button 
                                                    type="submit" 
                                                    name="approve" 
                                                    class="btn btn-success btn-sm w-full md:w-auto"
                                                >
                                                    Approve
                                                </button>
                                            <?php endif; ?>
                                            <button 
                                                type="submit" 
                                                name="deny" 
                                                class="btn btn-error btn-sm w-full md:w-auto"
                                            >
                                                Deny
                                            </button>
                                            <?php break; ?>
                                        
                                        <?php case 'returned': ?>
                                            <button 
                                                type="submit" 
                                                name="received" 
                                                class="btn btn-info btn-sm w-full"
                                            >
                                                Mark as Received
                                            </button>
                                            <?php break; ?>
                                        
                                        <?php case 'missing': ?>
                                            <button 
                                                type="submit" 
                                                name="acknowledge" 
                                                class="btn btn-warning btn-sm w-full"
                                            >
                                                Acknowledge
                                            </button>
                                            <?php break; ?>
                                    <?php endswitch; ?>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500 text-lg">No pending approvals found</p>
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
    ?>
</body>
</html>

<?php
function status_badge($status) {
    switch(strtolower($status)) {
        case 'wait': return 'badge-warning';
        case 'returned': return 'badge-success';
        case 'missing': return 'badge-error';
        default: return 'badge-outline';
    }
}
?>