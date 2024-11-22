<?php
include ("./include/config.php");

if (isset($_POST['submit'])) {
    // Email Condition
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $pattern = "/^[_a-z0-9-]+(\.[_a_z0-9-]+)*@[a-z0-9-]+(\.[a_z0-9-]+)*(\.[a-z]{2,3})$/";
        if (preg_match($pattern, $_POST['email'])) {
            $email = $_POST['email'];
        } else {
            $message_mail = 'Please type correct Email';
        }
    } else {
        $message_mail = 'Please fill Email field';
    }

    // Password Condition
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        if (strlen($_POST['password']) < 6) {
            $message_pass = 'Your Password should be 6 characters long';
        } else {
            $password = $_POST['password'];
        }
    } else {
        $message_pass = 'Please fill Password field';
    }

    // Email and Password Validation
    if ((isset($email) && !empty($email)) && (isset($password) && !empty($password))) {
        $email = mysqli_real_escape_string($connection, $email);
        $password = md5(mysqli_real_escape_string($connection, $password));
        $check_sql = "SELECT * FROM `users` WHERE email='$email' AND password = '$password'";
        $result = mysqli_query($connection, $check_sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION['userId'] = $row['id'];
                $_SESSION['userName'] = $row['name'];

                header('Location: home.php');
            }
        }

        if (mysqli_num_rows($result) <= 0) {
            $message_found = 'OOP\'s! email or password not found';
        }
    }
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />
    <link rel="icon" type="image/png" href="images/tab.png" sizes="16x16">
    <link rel="icon" type="image/png" href="images/tab1.png" sizes="32x32">

    <title>Study Sync</title>

    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('../images/login.png') center center no-repeat;
            background-size: cover;
            font-family: 'Lato', sans-serif;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.93);
            padding: 40px;
            max-width: 400px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .button {
            background-color: #000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }

        .alert-danger {
            color: red;
            text-align: center;
        }

        .copyright {
            text-align: center;
            margin-top: 20px;
        }

        .register-button {
            background-color: #007bff;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form id="login-form" name="login-form" class="nobottommargin" action="" method="post">
            <h3 style="text-align: center;">Login to your Account</h3>

            <div>
                <label for="login-form-email">Email:</label>
                <input type="email" id="login-form-username" name="email" value="" class="form-control" />
            </div>

            <div>
                <label for="login-form-password">Password:</label>
                <input type="password" id="login-form-password" name="password" value="" class="form-control" />
            </div>

            <div>
                <button class="button" id="login-form-submit" name="submit" value="login">Login</button>
            </div>
        </form>

        <div class="alert-danger">
            <?php
            if (isset($message_pass) || isset($message_mail) || isset($message_found)) {
                if (isset($message_mail))
                    echo "$message_mail <br>";
                if (isset($message_pass))
                    echo "$message_pass <br>";
                if (isset($message_found))
                    echo "$message_found";
            }
            ?>
        </div>

        <div>
            <button class="button register-button" onclick="window.location.href='register.php'">Register</button>
        </div>
    </div>

    <!-- <div class="copyright">
        <small>Copyrights &copy; 2024 All Rights Reserved by StudySync.</small>
    </div> -->
</body>

</html>