<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>User Register</title>
    <link rel="stylesheet" href="user-login.css"> 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
</head>
<body>
    <div class="wrapper">
        <?php
        if (isset($_POST["submit"])) {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $repeatpassword = $_POST["repeat_password"];

            $passwordhash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();

            if (empty($username) OR empty($email) OR empty($password) OR empty($repeatpassword)) {
               array_push($errors, "All fields are required");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors,"Email is not valid");
            }
            if (strlen($password)<8) {
                array_push($errors, "Password must be at least 8 characters long");
            }
            if ($password!==$repeatpassword) {
                array_push($errors, "Password does not match");
            }
            require_once "db.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0) {
                array_push($errors, "Email already exists!");
            }
            if (count($errors)>0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }else {
                
                $sql = "INSERT INTO users (user_name, email, password) VALUES(?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt,"sss",$username, $email, $passwordhash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'> Registered Successfully! </div>"; 
                }else{
                    die("Something went wrong");
                }
            }
        }
        ?>
        <form action="register.php" method="post">
            <h1>Sign Up</h1>
            <div class="input-box">
                <input type="text" placeholder="Username" name="username">
                <i class='bx bx-user' ></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Email" name="email">
                <i class='bx bx-envelope'></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Phone Number" name="phone">
                <i class='bx bx-phone'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="password">
                <i class='bx bx-lock' ></i>
            </div>
            <div class="input-box">
                <input type="repeat-password" placeholder="Repeat Password" name="repeat_password">
                <i class='bx bx-lock' ></i>
            </div>

            <button type="submit" class="btn" value="Register" name="submit">Register</button>

            <div class="register-link">
                <p> Already have an account?
                <a href="login.php">Login</a></p>
            </div>
        </form>
  
    </div>
</body>
</html>