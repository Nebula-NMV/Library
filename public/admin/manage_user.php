<?php
session_start();
require_once __DIR__ . '/../../private/connect.php';
require_once __DIR__ .'/check.php';
include_once __DIR__ . '/../asset/header/header-admin.php';

// ... Keep your existing PHP code ...
$sql = "SELECT * FROM user";
if (!empty($_GET['search'])) {
    $sql .= " WHERE {$_GET['type']} LIKE '%{$_GET['search']}%'";
}
$sql .= " ORDER BY f_name ASC;";
$result = $connect->query($sql);

?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen p-0">
    <div class="max-w-7xl mx-auto">
        <!-- Search Form -->
        <form action="" method="get" class="mb-6">
            <div class="flex flex-col md:flex-row gap-2">
                <div class="join flex-1">
                    <input 
                        type="search" 
                        name="search" 
                        placeholder="Search users..." 
                        class="input input-bordered join-item w-full"
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                    >
                    <select 
                        name="type" 
                        class="select select-bordered join-item md:w-auto"
                    >
                        <option value="std_id" <?= selected('std_id') ?>>Student ID</option>
                        <option value="f_name" <?= selected('f_name') ?>>First Name</option>
                        <option value="l_name" <?= selected('l_name') ?>>Last Name</option>
                        <option value="username" <?= selected('username') ?>>Username</option>
                        <option value="email" <?= selected('email') ?>>Email</option>
                        <option value="status" <?= selected('status') ?>>Status</option>
                    </select>
                    <button type="submit" class="btn btn-primary join-item">
                        Search
                    </button>
                </div>
            </div>
        </form>

        <!-- Users Table -->
        <div class="overflow-x-auto rounded-lg shadow-lg">
            <table class="table table-zebra table-pin-rows table-pin-cols">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="p-3">Student ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <form action="../../private/admin/manage_user.php" method="post">
                                <tr class="hover:bg-base-200">
                                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($row['user_id']) ?>">
                                    
                                    <!-- Student ID -->
                                    <td class="p-2">
                                        <input 
                                            type="number" 
                                            name="std_id" 
                                            value="<?= htmlspecialchars($row['std_id']) ?>" 
                                            class="input input-xs input-bordered w-24"
                                            <?= admin_disabled($row) ?>
                                        >
                                    </td>

                                    <!-- Name Fields -->
                                    <td>
                                        <input 
                                            type="text" 
                                            name="f_name" 
                                            value="<?= htmlspecialchars($row['f_name']) ?>" 
                                            class="input input-xs input-bordered w-full"
                                            <?= admin_disabled($row) ?>
                                        >
                                    </td>
                                    <td>
                                        <input 
                                            type="text" 
                                            name="l_name" 
                                            value="<?= htmlspecialchars($row['l_name']) ?>" 
                                            class="input input-xs input-bordered w-full"
                                            <?= admin_disabled($row) ?>
                                        >
                                    </td>

                                    <!-- Username & Password -->
                                    <td>
                                        <input 
                                            type="text" 
                                            name="username" 
                                            value="<?= htmlspecialchars($row['username']) ?>" 
                                            class="input input-xs input-bordered w-full"
                                            <?= admin_disabled($row) ?>
                                        >
                                    </td>
                                    <td>
                                        <input 
                                            type="password" 
                                            name="new_password" 
                                            placeholder="New password" 
                                            class="input input-xs input-bordered w-full"
                                            <?= admin_disabled($row) ?>
                                        >
                                    </td>

                                    <!-- Email -->
                                    <td>
                                        <input 
                                            type="email" 
                                            name="email" 
                                            value="<?= htmlspecialchars($row['email']) ?>" 
                                            class="input input-xs input-bordered w-full"
                                            <?= admin_disabled($row) ?>
                                        >
                                    </td>

                                    <!-- Role Dropdown -->
                                    <td>
                                        <select 
                                            name="role" 
                                            class="select select-xs select-bordered"
                                            <?= admin_disabled($row) ?>
                                        >
                                            <option value="admin" disabled <?= selected_role('admin', $row) ?>>Admin</option>
                                            <option value="moderator" <?= selected_role('moderator', $row) ?>>Moderator</option>
                                            <option value="user" <?= selected_role('user', $row) ?>>User</option>
                                        </select>
                                    </td>

                                    <!-- Status Dropdown -->
                                    <td>
                                        <select 
                                            name="status" 
                                            class="select select-xs select-bordered"
                                            <?= admin_disabled($row) ?>
                                        >
                                            <option value="enable" <?= selected_status('enable', $row) ?>>Enable</option>
                                            <option value="disable" <?= selected_status('disable', $row) ?>>Disable</option>
                                        </select>
                                    </td>

                                    <!-- Action Button -->
                                    <td>
                                        <?php if (!is_admin($row)): ?>
                                            <button 
                                                type="submit" 
                                                name="update" 
                                                class="btn btn-xs btn-success"
                                            >
                                                Update
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </form>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center p-4">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
    // Keep your alert handling code
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
// Helper functions
function selected($type) {
    return (!empty($_GET['type']) && $_GET['type'] == $type) ? 'selected' : '';
}

function selected_role($role, $row) {
    return (!empty($row['role']) && $row['role'] == $role) ? 'selected' : '';
}

function selected_status($status, $row) {
    return (!empty($row['status']) && $row['status'] == $status) ? 'selected' : '';
}

function admin_disabled($row) {
    return (!empty($row['role']) && $row['role'] == 'admin') ? 'disabled' : '';
}

function is_admin($row) {
    return (!empty($row['role']) && $row['role'] == 'admin');
}
?>