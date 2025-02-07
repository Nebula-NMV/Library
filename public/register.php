<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <div>
        <form action="../private/register.php" method="post">
            <div>
                <label for="std_id">Student id</label>
                <input type="text" name="std_id" id="std_id" placeholder="student id" minlength="11" maxlength="11" required >
            </div>
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="username" minlength="3" maxlength="50" required    >
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="password" minlength="8" maxlength="50" required >
                <input type="password" name="confirm"  placeholder="confirm password" minlength="8" maxlength="50" required >
            </div>
            <div>
                <label for="f_name">Firse Name</label>
                <input type="text" name="f_name" id="f_name" placeholder="first Name" minlength="3" maxlength="255" required >
            </div>
            <div>
                <label for="l_name">Last Name</label>
                <input type="text" name="l_name" id="l_name" placeholder="last Name" minlength="3" maxlength="255" required >
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="email" minlength="3" maxlength="255" required >
            </div>
            <div>
                <button type="submit" name="register">Register</button>
            </div>
        </form>
        <div>
            <p>Have Account? <a href="./login.php">Login</a></p>
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
        } 
    }
    ?>
</body>
</html>