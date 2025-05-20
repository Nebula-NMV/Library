<?php 
session_start();
require_once __DIR__ . '/../../private/connect.php';
require_once __DIR__ . '/check.php';
include_once __DIR__ . '/../asset/header/header-admin.php';

$sql = "SELECT * FROM book";
if (!empty($_GET['search']) && !empty($_GET['type'])) {
    $search = $connect->real_escape_string($_GET['search']);
    $type = $connect->real_escape_string($_GET['type']);
    $sql .= " WHERE $type LIKE '%$search%' ";
}
$sql .= " ORDER BY book_id DESC";
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
        <div class="mb-8">
            <form action="" method="get" class="bg-white p-4 rounded-lg shadow">
                <div class="join flex flex-col md:flex-row gap-2 w-full">
                    <input 
                        type="search" 
                        name="search" 
                        placeholder="Search books..." 
                        class="input input-bordered join-item w-full"
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                    >
                    <select 
                        name="type" 
                        class="select select-bordered join-item md:w-64"
                    >
                        <option value="book_name" <?= selected('book_name') ?>>Book Name</option>
                        <option value="book_category" <?= selected('book_category') ?>>Category</option>
                        <option value="book_stock" <?= selected('book_stock') ?>>Stock</option>
                        <option value="book_status" <?= selected('book_status') ?>>Status</option>
                    </select>
                    <button type="submit" class="btn btn-primary join-item">
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Add Book Form -->
        <div class="card bg-white shadow-lg mb-8">
            <div class="card-body">
                <h2 class="card-title mb-4">Add New Book</h2>
                <form action="../../private/admin/manage_book.php" method="post" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Book Cover</span>
                            </label>
                            <input 
                                type="file" 
                                name="book_image" 
                                class="file-input file-input-bordered"
                                accept=".jpg, .jpeg, .png, .gif"
                            >
                        </div>
                        
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Book Name</span>
                            </label>
                            <input 
                                type="text" 
                                name="book_name" 
                                class="input input-bordered"
                                placeholder="Enter book name"
                                required
                            >
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text">Description</span>
                            </label>
                            <textarea 
                                name="description" 
                                class="textarea textarea-bordered h-24"
                                placeholder="Enter description"
                            ></textarea>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Category</span>
                            </label>
                            <input 
                                type="text" 
                                name="book_category" 
                                class="input input-bordered"
                                placeholder="Enter category"
                            >
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Stock</span>
                            </label>
                            <input 
                                type="number" 
                                name="book_stock" 
                                class="input input-bordered"
                                placeholder="Enter stock quantity"
                                min="0"
                            >
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Status</span>
                            </label>
                            <select name="book_status" class="select select-bordered">
                                <option value="enable">Enable</option>
                                <option value="disable">Disable</option>
                            </select>
                        </div>

                        <div class="form-control md:col-span-2 mt-4">
                            <button type="submit" name="add" class="btn btn-primary w-full">
                                Add Book
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card bg-white shadow-lg hover:shadow-xl transition-shadow">
                        <div class="card-body">
                            <form action="../../private/admin/manage_book.php" method="post" enctype="multipart/form-data">
                                <!-- Book Image -->
                                <figure class="mb-4">
                                    <img 
                                        src="../asset/book/<?= !empty($row['book_image']) ? htmlspecialchars($row['book_image']) : 'default.png' ?>" 
                                        alt="Book Cover" 
                                        class="w-full h-48 object-cover rounded-lg"
                                    >
                                </figure>

                                <input type="hidden" name="book_id" value="<?= htmlspecialchars($row['book_id']) ?>">
                                
                                <div class="space-y-4">
                                    <!-- File Upload -->
                                    <div class="form-control">
                                        <input 
                                            type="file" 
                                            name="book_image" 
                                            class="file-input file-input-bordered file-input-sm"
                                        >
                                    </div>

                                    <!-- Book Details -->
                                    <div class="form-control">
                                        <input 
                                            type="text" 
                                            name="book_name" 
                                            class="input input-bordered input-sm"
                                            value="<?= htmlspecialchars($row['book_name']) ?>"
                                            placeholder="book name"
                                        >
                                    </div>

                                    <div class="form-control">
                                        <input 
                                            type="text" 
                                            name="description" 
                                            class="input input-bordered input-sm"
                                            value="<?= htmlspecialchars($row['description']) ?>"
                                            placeholder="description"
                                        >
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="form-control">
                                            <input 
                                                type="text" 
                                                name="book_category" 
                                                class="input input-bordered input-sm"
                                                value="<?= htmlspecialchars($row['book_category']) ?>"
                                                placeholder="category"
                                            >
                                        </div>

                                        <div class="form-control">
                                            <input 
                                                type="number" 
                                                name="book_stock" 
                                                class="input input-bordered input-sm"
                                                value="<?= htmlspecialchars($row['book_stock']) ?>"
                                                placeholder="stock"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-control">
                                        <select name="book_status" class="select select-bordered select-sm">
                                            <option value="enable" <?= $row['book_status'] == 'enable' ? 'selected' : '' ?>>Enable</option>
                                            <option value="disable" <?= $row['book_status'] == 'disable' ? 'selected' : '' ?>>Disable</option>
                                        </select>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-2 mt-4">
                                        <button type="submit" name="update" class="btn btn-success btn-sm flex-1">
                                            Update
                                        </button>
                                        <!-- <button type="submit" name="delete" class="btn btn-error btn-sm flex-1">
                                            Delete
                                        </button> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">No books found</p>
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