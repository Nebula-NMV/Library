<?php 
    session_start();
    if (!empty($_SESSION['alert'])) {
        switch ($_SESSION['alert']) {
            case 'success':
                echo "<script>alert('Success')</script>";
                unset($_SESSION['alert']);
                break;
            case 'unsuccess':
                echo "<script>alert('Unsuccess')</script>";
                unset($_SESSION['alert']);
                break;
            case 'not_number':
                echo "<script>alert('Student ID Not a Number')</script>";
                unset($_SESSION['alert']);
                break;
            case 'not_match':
                echo "<script>alert('Password not Match')</script>";
                unset($_SESSION['alert']);
                break;
            case 'have_email':
                echo "<script>alert('Have a Email')</script>";
                unset($_SESSION['alert']);
                break;
            case 'have_studentID':
                echo "<script>alert('Have a Student ID')</script>";
                unset($_SESSION['alert']);
                break;
            case 'have_username':
                echo "<script>alert('Have a Username')</script>";
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
    <title>Library Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">

<div class="w-full max-w-lg"> <!-- เพิ่มขนาด max-width เป็น lg -->
    <div class="card bg-base-100 shadow-xl mx-2">
        <div class="card-body p-4 md:p-6"> <!-- ปรับ padding สำหรับ mobile/desktop -->
            <div class="text-center mb-4 md:mb-6"> <!-- Responsive margin -->
                <h1 class="text-2xl md:text-3xl font-bold text-primary">Library Membership</h1>
                <p class="text-sm md:text-base text-gray-600 mt-1 md:mt-2">Create new account</p>
            </div>

            <form action="../private/register.php" method="post" class="space-y-3 md:space-y-4"> <!-- Responsive spacing -->
                
                <!-- Student ID -->
                <div class="form-control">
                    <label class="label py-1">
                        <span class="label-text text-sm md:text-base">Student ID</span>
                    </label>
                    <input 
                        type="text" 
                        name="std_id" 
                        placeholder="11 Student ID" 
                        class="input input-bordered input-sm md:input-md"
                        minlength="11"
                        maxlength="11"
                        required
                    >
                </div>

                <!-- Username -->
                <div class="form-control">
                    <label class="label py-1">
                        <span class="label-text text-sm md:text-base">Username</span>
                    </label>
                    <input 
                        type="text" 
                        name="username" 
                        placeholder="Username" 
                        class="input input-bordered input-sm md:input-md"
                        minlength="3"
                        maxlength="50"
                        required
                    >
                </div>

                <!-- Password Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4"> <!-- Grid responsive -->
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text text-sm md:text-base">Password</span>
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="••••••••" 
                            class="input input-bordered input-sm md:input-md"
                            required
                        >
                    </div>
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text text-sm md:text-base">Confirm</span>
                        </label>
                        <input 
                            type="password" 
                            name="confirm" 
                            placeholder="••••••••" 
                            class="input input-bordered input-sm md:input-md"
                            required
                        >
                    </div>
                </div>

                <!-- Name Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-4"> <!-- ใช้ grid แทน flex -->
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text text-sm md:text-base">First Name</span>
                        </label>
                        <input 
                            type="text" 
                            name="f_name" 
                            placeholder="First name" 
                            class="input input-bordered input-sm md:input-md"
                            required
                        >
                    </div>
                    <div class="form-control">
                        <label class="label py-1">
                            <span class="label-text text-sm md:text-base">Last Name</span>
                        </label>
                        <input 
                            type="text" 
                            name="l_name" 
                            placeholder="Last name" 
                            class="input input-bordered input-sm md:input-md"
                            required
                        >
                    </div>
                </div>

                <!-- Email -->
                <div class="form-control">
                    <label class="label py-1">
                        <span class="label-text text-sm md:text-base">Email</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="user@library.com" 
                        class="input input-bordered input-sm md:input-md"
                        required
                    >
                </div>

                <button 
                    type="submit" 
                    name="register" 
                    class="btn btn-primary btn-sm md:btn-md mt-4 w-full"
                >
                    Create Account
                </button>
            </form>

            <div class="text-center mt-3 md:mt-4">
                <p class="text-xs md:text-sm text-gray-600">
                    Already have an account?
                    <a href="./login.php" class="link link-primary">
                        Login here
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>