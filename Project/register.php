<?php
session_start(); // start a new session or continues the previous
if (isset($_SESSION['user']) != "") {
    header("Location: home.php"); // redirects to home.php
    exit;
}
if (isset($_SESSION['adm']) != "") {
    header("Location: dashboard.php"); // redirects to home.php
    exit;
}

require_once 'components/db_connect.php';
require_once 'components/file_upload.php';

$error = false;
$first_name = $last_name = $email = $location = $password = $picture = $website = $occupation = $about = $account_type = '';
$first_nameError = $last_nameError = $emailError = $locationError = $passwordError = $pictureError = '';

function sanatize($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

if (isset($_POST['btn-signup'])) {
    $first_name = sanatize($_POST['first_name']);
    $last_name = sanatize($_POST['last_name']);
    $email = sanatize($_POST['email']);
    $location = sanatize($_POST['location']);
    $password = sanatize($_POST['password']);
    $website = sanatize($_POST['website']);
    $about = sanatize($_POST['about']);
    $occupation = sanatize($_POST['occupation']);
    $account_type = sanatize($_POST['account_type']);

    $uploadError = '';
    $picture = file_upload($_FILES['picture']);

    // basic name validation
    if (empty($first_name) || empty($last_name)) {
        $error = true;
        $first_nameError = "Please enter your full name and surname";
    } else if (strlen($first_name) < 2 || strlen($last_name) < 2) {
        $error = true;
        $first_nameError = "Name and surname must have at least 2 characters.";
    } else if (!preg_match("/^[a-zA-Z]+$/", $first_name) || !preg_match("/^[a-zA-Z]+$/", $last_name)) {
        $error = true;
        $first_nameError = "Name and surname must contain only letters and no spaces.";
    }

    // basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // checks whether the email exists or not
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }
    // checks if the location input was left empty
    if (empty($location)) {
        $error = true;
        $dateError = "Please enter your location.";
    }
    // password validation
    if (empty($password)) {
        $error = true;
        $passwordError = "Please enter password.";
    } else if (strlen($password) < 6) {
        $error = true;
        $passwordError = "Password must have at least 6 characters.";
    }

    // password hashing for security
    $password = hash('sha256', $password);
    // if there's no error, continue to signup
    if (!$error) {
        $insert_user = "INSERT INTO `users` (`email`, `first_name`, `last_name`, `location`, `password`, `picture`, `website`, `occupation`, `about`)
                        VALUES ('$email', '$first_name', '$last_name', '$location', '$password', '$picture->fileName', '$website', '$occupation', '$about')";
        $res_user = mysqli_query($connect, $insert_user);

        if ($res_user) {
            $last_id = "SELECT LAST_INSERT_ID()";
            $res_user_id = mysqli_query($connect, $last_id);
            $user_id = mysqli_fetch_array($res_user_id);
            $account_type_table = "mentors";

            if ($account_type == 2) {
                $account_type_table = "mentees";
            }

            $insert_account_type = "INSERT INTO `$account_type_table` (`fk_user_id`) VALUES ('$user_id[0]')";
            $res_account_type = mysqli_query($connect, $insert_account_type);

            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
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
    <title>Mentor Tree | Register</title>
    <?php require_once 'components/head.php'; ?>
    <style>
        <?php include 'styles.css'; ?>
    </style>
</head>

<body>
    <!-- begin navbar -->
    <?php include 'components/navPublic.php'; ?>
    <!-- end navbar -->


    <div class="container w-50 mx-auto">
        <div class="heading mt-5 mb-3">
            <h2>Sign Up.</h2>

        </div>

        <form class="row g-3 mb-5" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">

            <?php
            if (isset($errMSG)) {
                if ($errTyp == "success") {
                    $success = true;
                    // header("refresh:3;url=index.php");
                }
            ?>
                <div class="alert alert-<?php echo $errTyp ?>">
                    <p><?php echo $errMSG; ?></p>
                    <p><?php echo $uploadError; ?></p>
                </div>

            <?php
            }
            if (!isset($success)) {
            ?>
                <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" placeholder="John" maxlength="50" value="<?php echo $first_name ?>" />
                    <span class="text-danger"> <?php echo $first_nameError; ?> </span>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" placeholder="Doe" maxlength="50" value="<?php echo $last_name ?>" />
                    <span class="text-danger"> <?php echo $first_nameError; ?> </span>
                </div>
                <div class="col-md-6">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" placeholder="john@john-doe.com" maxlength="40" value="<?php echo $email ?>" />
                    <span class="text-danger"> <?php echo $emailError; ?> </span>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" maxlength="25" />
                    <span class="text-danger"> <?php echo $passwordError; ?> </span>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Country</label>
                <input type="text" name="location" class="form-control" placeholder="Canada" value="<?php echo $location ?>" />
                <span class="text-danger"> <?php echo $first_nameError; ?> </span>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Profile Pic</label>
                <input class='form-control' type="file" name="picture">
                <span class="text-danger"> <?php echo $pictureError; ?> </span>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Website (optional)</label>
                <input type="website" name="website" class="form-control" placeholder="www.john-doe.com" maxlength="255" />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Occupation</label>
                <input type="occupation" name="occupation" class="form-control" placeholder="Marketing Director" maxlength="255" />
                </div>
                <div class="col-md-12">
                    <label class="form-label">About You</label>
                <input type="about" name="about" class="form-control" placeholder="I was the first person on the moon..." maxlength="2048" />
                </div>
                <label class="form-label">What are you here to be?</label>
                <div class="col-md-4">
                
                <input  class="mb-2" type="radio" id="mentor" name="account_type" value=1 checked="checked">
                <label for="mentor">Mentor</label><br>
                <input type="radio" id="mentee" name="account_type" value=2>
                <label for="mentee">Mentee</label><br>
                </div>

                
                <button type="submit" class="btn btn-block btn-brand my-4" name="btn-signup">Sign Up</button>
                
                <a href="login.php" class="linky">Already have an account? Sign in Here!</a>
            <?php
            }
            ?>
        </form>
    </div>
        <!-- begin footer and js -->
        <?php include 'components/footer.php'; ?>
        <?php require_once 'components/bootjs.php' ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <!-- end footer and js -->
</body>

</html>