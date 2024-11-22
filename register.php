<?php
include ("./include/config.php");

if (isset($_POST['register'])) {
    // Name Condition
    if (isset($_POST['name']) && !empty($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        $message_name = 'Please fill Name field';
    }

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

    // Confirm Password Condition
    if (isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
        if ($_POST['confirm_password'] != $_POST['password']) {
            $message_confirm_pass = 'Passwords do not match';
        } else {
            $confirm_password = $_POST['confirm_password'];
        }
    } else {
        $message_confirm_pass = 'Please fill Confirm Password field';
    }

    // All Conditions Met
    if (isset($name) && !empty($name) && isset($email) && !empty($email) && isset($password) && !empty($password) && isset($confirm_password) && !empty($confirm_password)) {
        $name = mysqli_real_escape_string($connection, $name);
        $email = mysqli_real_escape_string($connection, $email);
        $password = md5(mysqli_real_escape_string($connection, $password));

        // Check if email already exists
        $check_email_sql = "SELECT * FROM `users` WHERE email='$email'";
        $result_check = mysqli_query($connection, $check_email_sql);

        if (mysqli_num_rows($result_check) > 0) {
            $message_register = 'Email already exists. Please use a different email.';
        } else {
            // Insert into database
            $register_sql = "INSERT INTO `users` (name, email, password) VALUES ('$name', '$email', '$password')";
            $result = mysqli_query($connection, $register_sql);

            if ($result) {
                header('Location: login.php');
            } else {
                $message_register = 'Registration failed. Please try again.';
            }
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

    <title>Study Sync - Register</title>

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
            background: url('../images/register.png') center center no-repeat;
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

        .login-button {
            background-color: #007bff;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form id="register-form" name="register-form" class="nobottommargin" action="" method="post">
            <h3 style="text-align: center;">Create an Account</h3>

            <div>
                <label for="register-form-name">Name:</label>
                <input type="text" id="register-form-name" name="name" value="" class="form-control" />
            </div>

            <div>
                <label for="register-form-email">Email:</label>
                <input type="email" id="register-form-email" name="email" value="" class="form-control" />
            </div>

            <div>
                <label for="register-form-password">Password:</label>
                <input type="password" id="register-form-password" name="password" value="" class="form-control" />
            </div>

            <div>
                <label for="register-form-confirm-password">Confirm Password:</label>
                <input type="password" id="register-form-confirm-password" name="confirm_password" value=""
                    class="form-control" />
            </div>

            <div>
                <button class="button" id="register-form-submit" name="register" value="register">Register</button>
            </div>
        </form>

        <div class="alert-danger">
            <?php
            if (isset($message_name) || isset($message_mail) || isset($message_pass) || isset($message_confirm_pass) || isset($message_register)) {
                if (isset($message_name))
                    echo "$message_name <br>";
                if (isset($message_mail))
                    echo "$message_mail <br>";
                if (isset($message_pass))
                    echo "$message_pass <br>";
                if (isset($message_confirm_pass))
                    echo "$message_confirm_pass <br>";
                if (isset($message_register))
                    echo "$message_register";
            }
            ?>
        </div>

        <div>
            <button class="button login-button" onclick="window.location.href='login.php'">Login</button>
        </div>
    </div>

    <!-- <div class="copyright">
        <small>Copyrights &copy; 2024 All Rights Reserved by StudySync.</small>
    </div> -->
</body>

</html>