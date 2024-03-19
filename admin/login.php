<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin - Login</title>
    <link rel="stylesheet" href="user-login.css"> 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
</head>
<body>
    <div class="wrapper">
        <?php
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            require_once "db.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    header("Location: admin.html");
                    die();
                }else{
                    echo "<div class = 'alert alert-danger'> Password does not match </div>";
                }
            }else{
                echo "<div class = 'alert alert-danger'> Email does not match </div>";
            }
        }
        ?>
        <form action="login.php" method="post">
            <h1>Admin</h1>
            <div class="input-box">
                <input type="email" placeholder="Email" name="email">
                <i class='bx bx-user' ></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="password">
                <i class='bx bx-lock' ></i>
            </div>

            <div class="remember-forgot">
                <label for=""><input type="checkbox">Remember Me
                </label>
                <a href="#">Forgot Password</a>
            </div>

            <input type="submit" value="Login" name="login" class="btn">

        </form>
  
    </div>
</body>
</html>