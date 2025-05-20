<?php
    session_start();
    require_once __DIR__ . "/../../private/connect.php";
    require_once __DIR__ ."/check.php";
    include_once __DIR__ . "/../asset/header/header-user.php";

    $sql = "SELECT * FROM book WHERE book_status = 'enable'";
    if (!empty($_GET['search'])) {
        $sql .= " AND {$_GET['type']} LIKE '%{$_GET['search']}%'";
    }
    $sql .= " ORDER BY CASE WHEN book_stock <= 0 THEN 1 ELSE 0 END ASC,
        book_id DESC;";
    $result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management</title>
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
                        placeholder="Search books..." 
                        class="input input-bordered join-item w-full"
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                    >
                    <select 
                        name="type" 
                        class="select select-bordered join-item md:w-48"
                    >
                        <option value="book_name" <?= selected('book_name') ?>>Book Name</option>
                        <option value="book_category" <?= selected('book_category') ?>>Category</option>
                    </select>
                    <button type="submit" class="btn btn-primary join-item">
                        Search
                    </button>
                </div>
            </div>
        </form>

        <!-- Book Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <form action="../../private/user/book.php" method="post">
                        <div class="card bg-white shadow-xl hover:shadow-2xl transition-shadow duration-200">
                            <figure class="px-4 pt-4">
                                <img 
                                    src="../asset/book/<?= !empty($row['book_image']) ? htmlspecialchars($row['book_image']) : 'default.png' ?>" 
                                    alt="Book Cover" 
                                    class="rounded-xl h-48 w-full object-cover"
                                >
                            </figure>
                            <div class="card-body">
                                <input type="hidden" name="book_id" value="<?= $row['book_id'] ?? '' ?>">
                                
                                <h2 class="card-title">
                                    <?= !empty($row['book_name']) ? htmlspecialchars($row['book_name']) : "Untitled" ?>
                                </h2>
                                
                                <div class="space-y-2">
                                    <p class="text-sm text-gray-600">
                                        <?= !empty($row['description']) ? htmlspecialchars($row['description']) : "No description available" ?>
                                    </p>
                                    
                                    <div class="badge badge-outline">
                                        <?= !empty($row['book_category']) ? htmlspecialchars($row['book_category']) : "Uncategorized" ?>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium">Stock:</span>
                                        <span class="<?= $row['book_stock'] > 0 ? 'text-success' : 'text-error' ?>">
                                            <?= $row['book_stock'] ?? 0 ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="card-actions mt-4">
                                    <?php if ($row['book_stock'] > 0): ?>
                                        <button 
                                            type="submit" 
                                            name="borrow" 
                                            class="btn btn-primary w-full"
                                        >
                                            Borrow Book
                                        </button>
                                    <?php else: ?>
                                        <button 
                                            class="btn btn-disabled w-full"
                                            disabled
                                        >
                                            Out of Stock
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No books found</p>
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
?>