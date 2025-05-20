<?php
    session_start();
    require_once __DIR__ . '/../../private/connect.php';
    require_once __DIR__ . '/check.php';
    include_once __DIR__ . '/../asset/header/header-moderator.php';

    $sql = "SELECT * FROM user WHERE user_id = {$_SESSION['user_id']}";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen p-0">
    <div class="max-w-2xl mx-auto">
        <div class="card bg-white shadow-lg rounded-lg">
            <div class="card-body">
                <h1 class="card-title text-2xl mb-6">Profile Settings</h1>
                
                <form action="../../private/moderator/profile.php" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Read-only Fields -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Student ID</span>
                            </label>
                            <input 
                                type="text" 
                                class="input input-bordered bg-gray-100"
                                value="<?= htmlspecialchars($row['std_id'] ?? '') ?>" 
                                disabled
                            >
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Username</span>
                            </label>
                            <input 
                                type="text" 
                                class="input input-bordered bg-gray-100"
                                value="<?= htmlspecialchars($row['username'] ?? '') ?>" 
                                disabled
                            >
                        </div>

                        <!-- Editable Fields -->
                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text">First Name</span>
                            </label>
                            <input 
                                type="text" 
                                name="f_name" 
                                class="input input-bordered"
                                value="<?= htmlspecialchars($row['f_name'] ?? '') ?>"
                            >
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text">Last Name</span>
                            </label>
                            <input 
                                type="text" 
                                name="l_name" 
                                class="input input-bordered"
                                value="<?= htmlspecialchars($row['l_name'] ?? '') ?>"
                            >
                        </div>

                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text">Email</span>
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                class="input input-bordered"
                                value="<?= htmlspecialchars($row['email'] ?? '') ?>"
                            >
                        </div>

                        <!-- Password Change Section -->
                        <div class="md:col-span-2 border-t pt-4 mt-4">
                            <h2 class="text-lg font-semibold mb-4">Change Password</h2>
                            
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Current Password</span>
                                </label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    class="input input-bordered"
                                    placeholder="Enter current password"
                                    required
                                >
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">New Password</span>
                                    </label>
                                    <input 
                                        type="password" 
                                        name="new_password" 
                                        class="input input-bordered"
                                        placeholder="New password"
                                    >
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Confirm Password</span>
                                    </label>
                                    <input 
                                        type="password" 
                                        name="confirm_password" 
                                        class="input input-bordered"
                                        placeholder="Confirm new password"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-control md:col-span-2 mt-6">
                            <button 
                                type="submit" 
                                name="update" 
                                class="btn btn-primary w-full"
                            >
                                Update Profile
                            </button>
                        </div>
                    </div>
                </form>
            </div>
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