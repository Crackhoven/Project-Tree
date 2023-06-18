<?php
session_start();
require_once 'components/db_connect.php';
require_once 'components/file_upload.php';

// if session is not set this will redirect to login page
if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// workaround for now in order to use the get_details.php component
$_GET['id'] = $_SESSION['user'];

require_once 'components/get_details.php';

function sanatize($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

//update
$class = 'd-none';
if (isset($_POST["submit"])) {
    $first_name = sanatize($_POST['first_name']);
    $last_name = sanatize($_POST['last_name']);
    $email = sanatize($_POST['email']);
    $location = sanatize($_POST['location']);
    $website = sanatize($_POST['website']);
    $occupation = sanatize($_POST['occupation']);
    $about = sanatize($_POST['about']);
    $id = sanatize($_SESSION['user']);
    //variable for upload pictures errors is initialized
    $uploadError = '';
    $pictureArray = file_upload($_FILES['picture']); //file_upload() called
    $picture = $pictureArray->fileName;
    if ($pictureArray->error === 0) {
        ($_POST["picture"] == "avatar.png") ?: unlink("pictures/{$_POST["picture"]}");
        $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', location = '$location', website = '$website', occupation = '$occupation', about = '$about',  picture = '$pictureArray->fileName' WHERE id = {$id}";
    } else {
        $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', location = '$location', website = '$website', occupation = '$occupation', about = '$about' WHERE id = {$id}";
    }


    if (mysqli_query($connect, $sql) === true) {
        $class = "alert alert-success";
        $message = "Update successful!";
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
        if (isset($_POST['skills'])) {
            $flush_skills_sql = "DELETE FROM user_skills WHERE fk_user_id = {$id}";
            mysqli_query($connect, $flush_skills_sql);
            foreach ($_POST['skills'] as $skill) {
                $add_skill_sql = "INSERT INTO user_skills VALUES ((select id from skills where name = '{$skill}'), {$id})";
                mysqli_query($connect, $add_skill_sql);
            }
        }
        if (isset($_POST['twitter']) || isset($_POST['facebook']) || isset($_POST['instagram'])) {
            $flush_social_sql = "DELETE FROM user_social_media where fk_user_id = {$id}";
            mysqli_query($connect, $flush_social_sql);
            $social_platforms = [$_POST['twitter'], $_POST['facebook'], $_POST['instagram']];
            foreach ($social_platforms as $index => $social_username) {
                $index++;
                if ($social_username) {
                    $set_social_sql = "INSERT INTO user_social_media values({$id}, {$index}, '{$social_username}')";
                    mysqli_query($connect, $set_social_sql);
                }
            }
            #header("refresh:3;url=update.php?id={$id}");
        }
    } else {
        $class = "alert alert-danger";
        $message = "Error while updating record : <br>" . $connect->error;
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
        header("refresh:3;url=update.php?id={$id}");
    }
}

$skills_sql = "select * from skills";
$skills_data = mysqli_query($connect, $skills_sql);
$skills_html = "";
while ($row = mysqli_fetch_assoc($skills_data)) {
    $skills_html = $skills_html . "<option value='{$row['name']}'>{$row['name']}</option>";
}

$user_skills_sql = "SELECT skills.name from user_skills join skills on skills.id = fk_skill_id where fk_user_id = {$_SESSION['user']}";
$user_skills_data = mysqli_query($connect, $user_skills_sql);
$user_skills = [];
while ($row = mysqli_fetch_assoc($user_skills_data)) {
    $user_skills[] = $row['name'];
}

$user_social_sql = "SELECT social_media_platforms.name, user_social_media.username, social_media_platforms.website from user_social_media join social_media_platforms on user_social_media.fk_platform_id = social_media_platforms.id where user_social_media.fk_user_id = {$id}";
$user_social_data = mysqli_query($connect, $user_social_sql);
$user_social = [];
while ($row_social = mysqli_fetch_assoc($user_social_data)) {
    $user_social[] = $row_social['username'];
}




mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Tree | Edit Profile</title>

    <script src="https://code.jquery.com/jquery-3.4.0.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <?php require_once 'components/head.php'; ?>
    <style>
        <?php include 'styles.css'; ?>
    </style>
</head>

<body>
    <!-- begin navbar -->
    <?php include 'components/navUser.php'; ?>
    <!-- end navbar -->

    <div class="container w-50 mt-5">


        <div class="<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
        </div>
        <div class="d-flex justify-content-between mt-3 mb-2">
            <h2>Edit Profile</h2>
            <img class='img-thumbnail rounded-circle' src='pictures/<?php echo $data['picture'] ?>' alt="<?php echo $first_name ?>">
        </div>

        <form method="post" id="formUpdate" enctype="multipart/form-data" class="row g-3 mb-5 p-2">
            <div class="col-md-6">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" placeholder="First name" maxlength="50" value="<?php echo $first_name ?>" />
            </div>
            <div class="col-md-6">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" placeholder="Surname" maxlength="50" value="<?php echo $last_name ?>" />
            </div>
            <div class="col-md-6">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
            </div>
            <div class="col-md-6">
                <label class="form-label">Country</label>
                <input type="text" name="location" class="form-control" placeholder="Location" value="<?php echo $location ?>" />
            </div>
            <div class="col-md-6">
                <label class="form-label">Website (optional)</label>
                <input type="website" name="website" class="form-control" placeholder="www.john-doe.com" value="<?= $website ?>" />
            </div>
            <div class="col-md-6">
                <label class="form-label">Occupation</label>
                <input type="occupation" name="occupation" class="form-control" placeholder="Occupation" value="<?= $occupation ?>" />
            </div>
            <div class="col-md-12">
                <label class="form-label">Describe yourself</label>
                <input class="form-control" type="text" name="about" value="<?= "$about" ?>" maxlength="2048" rows="4"></input>
            </div>
            <div class="col-md-12">
                <label class="form-label">Profile picture</label>
                <input class='form-control' type="file" name="picture">
            </div>
            <label class="form-label"><h5>Skills</h5></label>
            <div class="col-md-12 selectRow">
                <!--     Using data-placeholder below to set place holder value versus putting in configuration-->
                <select class="form-control" id="multipleSelectExample" name="skills[]" data-placeholder="Select an option" multiple="true">
                    <?= $skills_html ?>
                </select>
            </div>
</body>
<script>
    $(document).ready(
        function() {
            $('#multipleSelectExample').select2().val(<?= json_encode($user_skills) ?>).trigger('change');
        }
    );
</script>
<h5>Social Media</h5>
<div class="col-md-4">
    <label class="form-label">Twitter</label>
    <input class="form-control" type="text" name="twitter" placeholder="username" value="<?= isset($user_social[0]) ? $user_social[0] : "" ?>" maxlength="255"></input>
</div>
<div class="col-md-4">
    <label class="form-label">Facebook</label>
    <input class="form-control" type="text" name="facebook" placeholder="username" value="<?= isset($user_social[1]) ? $user_social[1] : "" ?>" maxlength="255"></input>
</div>
<div class="col-md-4">
    <label class="form-label">Instagram</label>
    <input class="form-control" type="text" name="instagram" placeholder="username" value="<?= isset($user_social[2]) ?  $user_social[2] : "" ?>" maxlength="255"></input>
</div>

<input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
<input type="hidden" name="picture" value="<?php echo $picture ?>" />

</form>
<div class="d-flex justify-content-between mb-5 p-2">
    <a href="<?php echo $backBtn ?>"><button class="btn btn-light" type="button">Back</button></a>
    <a href="change_password.php"><button class="btn btn-light" type="button">Change Password</button></a>
    <button name="submit" form="formUpdate" class="btn btn-brand" type="submit">Save Changes</button>

</div>
</div>
<!-- begin footer and js -->
<?php include 'components/footer.php'; ?>
<?php require_once 'components/bootjs.php' ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!-- end footer and js -->
</body>

</html>