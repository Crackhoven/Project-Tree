<?php
session_start();
require_once 'components/db_connect.php';

// it will never let you open index (login) page if session is set
if (isset($_SESSION['user']) != "") {
    header("Location: home.php");
    exit;
}
if (isset($_SESSION['admin']) != "") {
    header("Location: dashboard.php"); // redirects to home.php
    exit;
}

$error = false;
$email = $password = $emailError = $passError = '';

if (isset($_POST['btn-login'])) {

    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    if (empty($email)) {
        $error = true;
        $emailError = "Please enter your email address.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Please enter your password.";
    }

    // if there's no error, continue to login
    if (!$error) {
        $password = hash('sha256', $pass); // password hashing
        $result = mysqli_query($connect, "SELECT * FROM users WHERE email = '$email'");
        $user = mysqli_fetch_assoc($result);
        $account_type = "mentee";
        if (mysqli_num_rows($result) == 1 && $user['password'] == $password) {
            $mentor = mysqli_query($connect, "SELECT * from mentors where fk_user_id = '$user[id]'");
            if (mysqli_num_rows($mentor) > 0) {
                $account_type = "mentor";
            }
            $_SESSION['user'] = $user['id'];
            $_SESSION['account_type'] = $account_type;
            header("Location: home.php");
        } else {
            $errMSG = "Incorrect Credentials, Try again...";
        }
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Tree | Login</title>
    <?php require_once 'components/head.php'; ?>
    <style>
        <?php include 'styles.css'; ?>
    </style>
</head>

<body>

    <!-- NO NAVBAR OR FOOTER -->

    <div class="container-fluid">
        <div class="row" id="rowLogin">
            <div class="col-3 d-flex flex-column align-items-center justify-content-center mx-auto p-2 shadow" id="sidebar">
                <div>
                    <img src="img/tree.png" alt="" width="30" height="30" class="d-inline-block align-text-top">
                </div>
                <div>
                    <h2 class="mb-5 text-center">mentor tree</h2>
                </div>
                <div>
                    <h5 class="mb-3 text-center">Same you, new beginning.</h5>
                </div>
                <div>
                    <a href="home.php" id="linkHelp" class="linky text-center">Need help? Click here.</a>
                </div>

            </div>
            <div class="col-9 d-flex flex-column align-items-center justify-content-evenly">
                <form class="w-75 mx-auto" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                    <div class="heading mb-3">
                        <h2>Login.</h2>
                    </div>

                    <?php
                    if (isset($errMSG)) {
                        echo $errMSG;
                    }
                    ?>

                    <input type="email" autocomplete="off" name="email" class="form-control mb-2" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
                    <span class="text-danger"><?php echo $emailError; ?></span>

                    <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                    <span class="text-danger"><?php echo $passError; ?></span>

                    <button class="btn btn-block btn-brand my-4" type="submit" name="btn-login">Sign In</button>
                    <br>

                    <a href="register.php" class="linky">Not registered yet? Click here</a>
                </form>
            </div>
        </div>
    </div>
    <!-- NO NAVBAR OR FOOTER -->
    <?php require_once 'components/bootjs.php' ?>
</body>

</html>