<?php
session_start();
require_once 'components/db_connect.php';

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
// variable for no results found
$profile_results_negative = '';

if (isset($_GET['search'])) {

    //Get words that were put into search bar into the SQL statement
    $searchstr = mysqli_real_escape_string($connect, $_GET['search']);

    //The search begins
    $search_sql = "SELECT * from skills join user_skills on skills.id = fk_skill_id join users on users.id = user_skills.fk_user_id join mentors on users.id = mentors.fk_user_id where name like '%$searchstr%'";
    $search_result = mysqli_query($connect, $search_sql);

    $search_result_display = mysqli_num_rows($search_result);

    $profile_results = array();

    if ($search_result_display > 0) {
        $ids = [];
        while ($user_row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
            //the rating of mentors. nerds lol
            if (in_array($user_row['fk_user_id'], $ids)) {
                continue;
            }
            $ids[] = $user_row['fk_user_id'];
            $rating_sql = "SELECT count(1), avg(rating) from user_reviews join mentees on user_reviews.fk_mentee_id = mentees.id join users on mentees.fk_user_id = users.id where user_reviews.fk_mentor_id = (select id from mentors where fk_user_id = {$user_row['fk_user_id']})";
            $rating_result = mysqli_query($connect, $rating_sql);
            $rating_row = mysqli_fetch_array($rating_result, MYSQLI_ASSOC);

            //the search for skills
            $skills_sql = "SELECT name from skills join user_skills on skills.id = fk_skill_id join users on users.id = user_skills.fk_user_id where users.id = {$user_row['fk_user_id']}";
            $skills_data = mysqli_query($connect, $skills_sql);
            $skills_rows = mysqli_num_rows($skills_data);

            $user_rating = "";
            if ($rating_row['count(1)'] > 0) {
                for ($i = 0; $i < $rating_row['avg(rating)']; ++$i) {
                    $user_rating = $user_rating . "<i class='fa-solid fa-star' data-rating='1'></i>";
                }
            } else {
                $user_rating = "No reviews";
            }


            "</div>";

            $users_skills_html = "<div class='skills'>";
            while ($skills_row = mysqli_fetch_assoc($skills_data)) {
                $skill_name = urlencode($skills_row['name']);
                $users_skills_html = $users_skills_html . "<a href=search.php?search={$skill_name}><span class='skill' id='skillBig'>{$skills_row['name']}</span></a>";
            }
            $users_skills_html = $users_skills_html . "</div>";

            $profile_card = "<div class='card mx-auto mb-5 shadow' style='max-width: 70%;'>
            <div class='row g-0'>
                <div class='col-md-3 p-2'>
                    <img src='pictures/{$user_row['picture']}' class='img-fluid rounded-start' alt='...'>
                    <p class='card-text p-2'><small class='text-muted'>Last online 3 mins ago</small></p>
                </div>
                <div class='col-md-6 p-2'>
                    <div class='card-body'>
                        <h5 class='card-title'><strong>{$user_row['first_name']} {$user_row['last_name']}</strong></h5>
                        <p class='card-text'>{$user_row['occupation']}</p>
                        <p class='card-text'>{$user_row['location']}</p>
                        <span class='star-rating'>
                            {$user_rating}
                        </span>
                        <span>({$rating_row['count(1)']})</span>
                        <hr>
                        <i class='fa-solid fa-comment-dots ms-1 me-1'></i><span>Chat</span>
                        <i class='fa-solid fa-phone ms-1 me-1'></i><span>4 x Month</span>
                        <i class='fa-solid fa-bolt-lightning ms-1 me-1'></i><span>Fast Responder</span>
                        <hr>
                        <p class='card-text'>{$user_row['about']}</p>
                        <hr>
                        {$users_skills_html}
                    </div>
                </div>
                <div class='col-md-3 p-2'>
                    <div class='card-body'>
                        <h7 class='card-text'>What can you expect from this mentor?</h7>
                        <hr>
                        <p class='card-text small'>Unlimited chat and email responses.</p>
                        <hr>
                        <p class='card-text small'>Up to four calls per month.</p>
                        <hr>
                        <a href='profile.php?id={$user_row['fk_user_id']}'><button type='button' class='btn btn-brand btn-lg btn-brand-lg'>View Profile</button></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of jane doe card --> ";
            $profile_results[] = $profile_card;
        }
    } else {
        $profile_results_negative = 'There are no results matching this search!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Tree | Find a Mentor</title>
    <?php require_once 'components/head.php'; ?>
    <style>
        <?php include 'styles.css'; ?>
    </style>
</head>


<body>

    <?php echo $smartNav ?>


    <div class="container-fluid mt-5">
        <!-- start search div -->
        <div class="search mx-auto mb-5">
            <h3 class="p-2 text-center mb-5">Find a mentor.</h3>

            <form method="GET" class="w-50 mx-auto input-group rounded input-group-lg">

                <input type="search" name="search" class="form-control rounded shadow mainSearchInput" placeholder="Try &rdquo;Web Developer&rdquo; or &rdquo;Project Management&rdquo;" aria-label="Search" aria-describedby="search-addon" />

                <button type="submit" class="btn btn-brand mainSearchButton shadow" id="search-addon">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <?php
            if (!isset($_GET['search']))
            $profile_results_negative = "Begin your search, the perfect mentor is waiting..."
            ?>
            <!--<div class="d-flex justify-content-evenly align-items-center mt-3 mb-3 p-3">
                <span class="filter">Skill</span>
                <span class="filter">Location</span>
                <span class="filter">Rating</span>
                <span class="filter">Occpation</span>
            </div> -->
        </div>
        <!-- end search div -->

        <div class="searchResults">
            <!-- begin dynamic card -->
            <?php
            if (isset($profile_results)) {
                foreach ($profile_results as $profile_details) {
                    echo $profile_details;
                }
            }
            ?>
            <!-- end of dynamic card -->

            <h2 class="text-center mt-5"><?php echo $profile_results_negative ?></h2>
        </div>
    </div>


    <!-- begin footer and js -->
    <?php include 'components/footer.php'; ?>
    <?php require_once 'components/bootjs.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- end footer and js -->
</body>

</html>
</body>

</html>