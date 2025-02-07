<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>

    <div>
        <form action="../private/login.php" method="post">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="username" minlength="3" maxlength="50" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="password" minlength="8" maxlength="50" required>
            </div>
            <div>
                <button type="submit" name="login">Login</button>
            </div>
        </form>
        <div>
            <p>
                Don't have account?
                <a href="./register.php">Register</a>
            </p>
        </div>
    </div>

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
            // case 'error':
            //     echo "<script>alert('Server Error')</script>";
            //     unset($_SESSION['alert']);
            //     break;
            default:
                break;
        } 
    }
    ?>
</body>
</html>