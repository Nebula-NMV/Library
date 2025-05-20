<?php 
    session_start();
    if (!empty($_SESSION['alert'])) {
        switch ($_SESSION['alert']) {
            case 'banned':
                echo "<script>alert('account banned')</script>";
                unset($_SESSION['alert']);
                break;
            case 'unsuccess':
                echo "<script>alert('Unsuccess')</script>";
                unset($_SESSION['alert']);
                break;
        } 
    }
    ?>
    
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Login</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-primary">Library </h1>
                    <p class="text-gray-600 mt-2">Please login to continue</p>
                </div>
                
                <form action="../private/login.php" method="post">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Username</span>
                        </label>
                        <input 
                            type="text" 
                            name="username" 
                            placeholder="Enter your username" 
                            class="input input-bordered" 
                            minlength="3" 
                            maxlength="50" 
                            required
                        >
                    </div>
                    
                    <div class="form-control mt-4">
                        <label class="label">
                            <span class="label-text">Password</span>
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="••••••••" 
                            class="input input-bordered" 
                            minlength="8" 
                            maxlength="50" 
                            required
                        >
                    </div>
                    
                    <button 
                        type="submit" 
                        name="login" 
                        class="btn btn-primary mt-6 w-full"
                    >
                        Login
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="./register.php" class="link link-primary hover:text-primary-focus">
                            Register here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>