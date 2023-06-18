<?php
session_start();
require_once 'components/db_connect.php';
require_once 'components/get_details.php';

if (isset($_SESSION['user']) != "") {
}

if (!$user_found) {
    header("Location: index.php");
    mysqli_close($connect);
}

$can_apply = false;

// reviews
$reviews_sql = "SELECT users.first_name, users.last_name, date, subject, details, rating, picture from user_reviews join mentees on user_reviews.fk_mentee_id = mentees.id join users on mentees.fk_user_id = users.id where user_reviews.fk_mentor_id = (select id from mentors where fk_user_id = {$id})";
$reviews_data = mysqli_query($connect, $reviews_sql);

// skills
$skills_sql = "SELECT name from skills join user_skills on skills.id = fk_skill_id join users on users.id = user_skills.fk_user_id where users.id = {$id}";
$skills_data = mysqli_query($connect, $skills_sql);

// social media
$social_sql = "SELECT social_media_platforms.name, user_social_media.username, social_media_platforms.website from user_social_media join social_media_platforms on user_social_media.fk_platform_id = social_media_platforms.id where user_social_media.fk_user_id = {$id}";
$social_data = mysqli_query($connect, $social_sql);

$user_id = 0;
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];
}

// mentorship application
$applications_sql = "SELECT * from applications join mentees on applications.fk_mentee_id = mentees.id join users on mentees.fk_user_id = users.id where users.id = {$user_id} and status <2";
$applications_data = mysqli_query($connect, $applications_sql);
$applications_num = mysqli_num_rows($applications_data);

// already mentor?
$mentee_connected_sql = "SELECT * from mentors join users on mentors.fk_user_id = users.id join mentees on mentors.id = mentees.fk_mentor_id where users.id = {$id} and mentees.fk_user_id = {$user_id}";
$mentee_connect_data = mysqli_query($connect, $mentee_connected_sql);
$mentee_connected_num = mysqli_num_rows($mentee_connect_data);

// if session is not set display public navbar, else user navbar
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    $smartNav = "<nav class='navbar navbar-expand-lg navbar-light shadow'>
    <div class='container-fluid p-2'>
        <a class='navbar-brand ps-5' href='home.php'>
            <img src='img/tree.png' alt='' width='30' height='30' class='d-inline-block align-text-top'>
            mentor tree
        </a>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav'
            aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse justify-content-end' id='navbarNav'>
            <ul class='navbar-nav'>
                <li class='nav-item'>
                    <a class='nav-link' href='search.php'>Find a Mentor</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='register.php'>Register</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='login.php'>Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>";
} else {
    $smartNav = "<nav class='navbar navbar-expand-lg navbar-light shadow'>
    <div class='container-fluid p-2'>
        <a class='navbar-brand ps-5' href='home.php'>
            <img src='img/tree.png' alt='' width='30' height='30' class='d-inline-block align-text-top'>
            mentor tree
        </a>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse justify-content-end' id='navbarNav'>
            <ul class='navbar-nav'>
                <li class='nav-item'>
                    <a class='nav-link' href='search.php'>Find a Mentor</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='home.php'>Dashboard</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='update.php'>Edit Profile</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='logout.php'>Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>";
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Tree | Profile</title>
    <?php require_once 'components/head.php'; ?>
    <style>
        <?php include 'styles.css'; ?>
    </style>
</head>

<body>
    <?php echo $smartNav ?>

    <div class="container mt-5">
        <div class="<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
        </div>
        <?php
        $reviews_rows = mysqli_num_rows($reviews_data);
        $reviews_html = "";


        if ($reviews_rows > 0) {
            $reviews_html = $reviews_html . "<h5>Reviews</h5>";
            $reviews_html = $reviews_html .
                "<div id='carouselExampleIndicators' class='carousel carousel-dark slide w-75 mx-auto' data-bs-ride='carousel'>
                <div class='carousel-indicators'>
                    <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='0' class='active' aria-current='true' aria-label='Slide 1'></button>";
            for ($i = 0; $i <= $reviews_rows - 1; $i++) {
                if ($i > 0) {
                    $reviews_html = $reviews_html . "\n<button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='{$i}' aria-label='Slide {$i}'></button>";
                }
            }
            $reviews_html = $reviews_html . "</div><div class='carousel-inner'>";
            $carousel_item_html = "";
            $active = "active";
            while ($row = mysqli_fetch_assoc($reviews_data)) {
                $rating = "";
                for ($j = 0; $j < $row['rating']; $j++) {
                    $rating = $rating . "<i class='fa-solid fa-star' data-rating='1'></i>";
                }
                $reviews_html = $reviews_html . "<div class='carousel-item {$active}'>
                <div class='card mb-3 p-5 mx-5'>
                    <div class='row g-0'>
                        <div class='col-md-4'>
                        <img src='pictures/{$row['picture']}' class='img-fluid rounded-circle' alt='...'>
                        </div>
                        <div class='col-md-8'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$row['first_name']} {$row['last_name']}</h5>
                            <div class='star-rating mb-2'>
                            {$rating}
                        </div>
                            <p class='card-text font-weight-bold'>{$row['subject']}</p>
                            <p class='card-text font-weight-bold'>{$row['details']}</p>
                            <p class='card-text'><small class='text-muted'>{$row['date']}</small></p>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>";
                $active = "";
            }
            $reviews_html = $reviews_html . '
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
    </div>';
        } else {
        }


        $skills_rows = mysqli_num_rows($skills_data);
        $user_skills_html = "";
        $user_skills_short_html = "";
        if ($skills_rows > 0) {
            $skill_count = 0;
            while ($row = mysqli_fetch_assoc($skills_data)) {
                $skill_count += 1;
                // todo why id and not class?
                $skill_name = urlencode($row['name']);
                $user_skills_html = $user_skills_html . "<a href=search.php?search={$skill_name}><span class='skill' id='skillBig'>{$row['name']}</span></a>";
                if ($skill_count <= 5) {
                    $user_skills_short_html = $user_skills_short_html . "<a href=search.php?search={$skill_name}><span class='skill'>{$row['name']}</span></a>";
                }
            }
        } else {
        }

        $social_rows = mysqli_num_rows($social_data);
        $social_html = "";
        if ($social_rows > 0) {
            while ($row = mysqli_fetch_assoc($social_data)) {
                $social_html = $social_html . "<a href='{$row['website']}{$row['username']}'><i class='fa-brands fa-{$row['name']} mx-1'></i></a>";
            }
        } else {
        }

        if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == "mentor") {
            $application_html = '<p class="btn-light btn-lg">You are a mentor!</p>';
        } else {
            if ($applications_num > 0 || $mentee_connected_num > 0) {
                $application_html = '<p class="btn-light btn-lg">Already your mentor / pending application.</p>';
                # check if no user is logged in
            } else {
                $application_html = '<a href="#" class="btn btn-lg btn-brand-lg">Send Application</a>';

                $application_html = "<form action='send_application.php' method='post'>
                                    <button class='btn btn-lg btn-brand-lg' name='apply' type='submit'>Send Application</button>
                                    <input type='hidden' name='mentor_id' value='{$id}' />
                                    <input type='hidden' name='mentee_id' value='{$user_id}' />
                                </form>";
            }
        }
        ?>

        <div class="container mt-5">
            <div class="directory mb-5">
                <a href="index.php" class="text-decoration-none text-reset">
                    <i class="fa-solid fa-house-chimney d-inline ps-1 mx-2"></i></a>
                <i class="fa-solid fa-angle-right d-inline ps-1 mx-2"></i>
                <a class="d-inline text-decoration-none text-reset ps-1 mx-2" href="search.php">Find a Mentor</a>
                <i class="fa-solid fa-angle-right d-inline ps-1 mx-2"></i>
                <p class="d-inline ps-1 mx-2"><?= $first_name . " " . $last_name ?></p>
            </div>
            <div class="profile">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-4">
                                <img src="pictures/<?= $picture ?>" class="img-fluid rounded" alt="">
                                <div class="social my-1 text-center">
                                    <?= $social_html ?>
                                </div>
                            </div>
                            <div class="col-8 p-2 px-5">
                                <div class="d-flex justify-content-between">
                                    <h2 class="mentorName"><?= $first_name . " " . $last_name ?></h2>
                                    <i class="fa-solid fa-heart" id="favHeart"></i>
                                    <!-- needs on-click event, could go from class: fa-regular to fa-solid -->
                                </div>

                                <h5><?= $occupation ?></h5>
                                <p><?= $location ?></p>
                                <hr>
                                <div class="skillsShort">
                                    <?= $user_skills_short_html ?>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <p class="rounded description mt-2 p-1">
                                <?= $about ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 rounded p-3">
                        <div class="profileCard card shadow">
                            <div class="card-body">
                                <h5 class="card-title"><em>Like what you see?</em></h5>
                                <div class="apply p-3">
                                    <p class="card-text"><strong>Apply for this mentor!</strong></p>
                                    <p class="card-text">Send in application.</p>
                                    <p class="card-text">Mentor accepts or declines invitation.</p>
                                    <p class="card-text">Mentor/mentee relationships can be cancelled any time.</p>
                                </div>
                                <?= $application_html ?>
                            </div>
                        </div>
                    </div>

                </div>
                <section>
                    <div class="row">
                        <div class="col mt-3 mb-3">
                            <h5>Core Skills</h5>
                            <div class="skillsBig">
                                <?= $user_skills_html ?>
                            </div>
                        </div>
                        <div class="reviews my-2">
                            <?= $reviews_html ?>
                        </div>
                </section>
            </div>
        </div>
    </div>



    <div>

        <!-- begin footer and js -->
        <?php include 'components/footer.php'; ?>

    </div>
    <?php require_once 'components/bootjs.php' ?>
    <!-- end footer and js -->

</body>

</html>