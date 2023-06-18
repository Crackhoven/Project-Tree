<?php
session_start();
require_once 'components/db_connect.php';
require_once 'components/head.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$hash_algo = "sha256";
$pass_length = 6;

function getStoredPassword($db_connection)
{
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $db_connection->prepare($sql);
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result->fetch_assoc()['password'];
}

function changeStoredPassword($db_connection, $user_id, $password)
{
    $sql = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = $db_connection->prepare($sql);
    $stmt->bind_param("ss", $password, $user_id);
    $stmt->execute();
}

function validPassword($password, $length)
{
    if (strlen($password) < $length) {
        return false;
    }
    return true;
}

if (isset($_POST["submit"])) {
    $current_password   = hash($hash_algo, $_POST['current_password']);
    $new_password       = hash($hash_algo, $_POST['new_password']);
    $confirmed_password = hash($hash_algo, $_POST['confirmed_password']);

    $stored_password = getStoredPassword($connect);

    if ($stored_password != $current_password) {
        $error = "Current password is incorrect.";
    } elseif ($new_password != $confirmed_password) {
        $error = "New passwords do not match.";
    } elseif (!validPassword($_POST['new_password'], $pass_length)) {
        $error = "New password must have at least {$pass_length} characters.";
    } else {
        changeStoredPassword($connect, $_SESSION['user'], $new_password);
        header("Location: home.php");
        exit;
    }
}


mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Tree | Change Password</title>
    <?php require_once 'components/boot.php'?>
    <style type="text/css">
        <?php include 'styles.css'; ?>
    

    @import url('https://fonts.googleapis.com/css2?family=Hammersmith+One&family=Permanent+Marker&family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&family=Source+Code+Pro:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        *
        *:before
        *:after{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body{
            height: 100vh;
              
        }
        .navbar{
            background: linear-gradient(to right, #d2fbd0,#71AF6B);
            /* light: #D2FBD0 middle: #71AF6B dark: #0D5F07 */
        }

        .navbar-brand {
            font-family: 'Hammersmith One', sans-serif!important;
            letter-spacing: .2rem!important;
            font-size: 2rem !important;
            text-decoration: none!important;
        }

        .nav-item   {
            font-family: 'Plus Jakarta Sans', sans-serif!important;
            padding-right: 3rem!important;
            font-weight: 600!important;
        }
        .alma{
            width: 100%;
            padding: 50px;
            
            
        }
        form{
            background-color: white;
            width: 100%;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 20px 20px 30px rgba(0,0,0,0.15);
            justify-content: center;
            text-align: center;
        }
        label{
            font-weight: 500;
            color: #101030;
        }
        input{
            display: block;
            width: 100%;
            margin-top: 5px;
            padding: 12px;
            border-radius: 5px;
            outline: none;
            color: #101010;
        }

        #password{
            margin-bottom: 30px;
        }
        input[type="password"]{
            border: 2px solid #c2c2c2;
        }
        input[type="button"]{
            background: linear-gradient(to right, #d2fbd0,#71AF6B);
            border: none;
            color: white;
            font-weight: 500;
            font-size: 18px;
            letter-spacing: 1px;
            cursor: pointer;
            margin-top: 20px;
        }

    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container-fluid p-2">
            <a class="navbar-brand ps-5" href="home.php">
                <img src="img/tree.png" alt="" width="30" height="30" class="d-inline-block align-text-top">
                mentor tree
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="search.php">Find a Mentor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="update.php">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="alma">
      <div class="container-fluid text-center w-50 changePass">
          <div class="row">
          <div class="col-12">
        <div class="<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
        </div>
    <form action="" method="post" enctype="multipart/form-data" class="mt-5 mb-5">
        <label for="password">Current Password</label>
        <input type="password" name="current_password" id="password" placeholder="password">
        <label for="cnfrm-password">New Password</label>
        <input type="password" name="new_password" id="confrm-password" placeholder="password">
        <label for="cnfrm-password">Confirm Password</label>
        <input type="password" name="confirmed_password" id="confrm-password" placeholder="password">
        <div class="text-center">
        <button name="submit" class="btn btn-brand mt-5" type="submit">Change Password</button>
        </div>
        <?php
                if (isset($error)) {
                    echo "<p class='text-danger'>$error</p>";
                }
        ?>
        <br>
        <div class="text-center">        
        <a href="update.php"><button class="btn btn-light" type="button">Back</button></a>
        </div>
    </form>
    </div>
</div>
</div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>