<?php
session_start();
require_once 'components/db_connect.php';

// if adm will redirect to dashboard
if (isset($_SESSION['adm'])) {
    header("Location: dashboard.php");
    exit;
}
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}


// select logged-in users details - procedural style
$user_res = mysqli_query($connect, "SELECT * FROM users WHERE id=" . $_SESSION['user']);
$user_details = mysqli_fetch_array($user_res, MYSQLI_ASSOC);

if ($_SESSION['account_type'] == "mentor") {
    $rel_sql = "SELECT users.* from mentors join mentees on mentors.id = mentees.fk_mentor_id join users on users.id = mentees.fk_user_id where mentors.fk_user_id = {$_SESSION['user']}";
    $app_sql = "SELECT applications.id as app_id, applications.*, users.* from applications join mentees on mentees.id = applications.fk_mentee_id join users on users.id = mentees.fk_user_id where applications.fk_mentor_id = (select id from mentors where fk_user_id = {$_SESSION['user']}) and status != 1";
} else {
    $rel_sql = "SELECT users.*, mentees.id as mentee_id from mentees join mentors on mentors.id = mentees.fk_mentor_id join users on users.id = mentors.fk_user_id where mentees.id = (select id from mentees where fk_user_id = {$_SESSION['user']})";
    $app_sql = "SELECT applications.id as app_id, applications.*, users.* from applications join mentors on mentors.id = applications.fk_mentor_id join users on users.id = mentors.fk_user_id where applications.fk_mentee_id = (select id from mentees where fk_user_id = {$_SESSION['user']}) and status != 1";
}

$mentorships = mysqli_query($connect, $rel_sql);
$relationships_html = "";
$applications = mysqli_query($connect, $app_sql);
$applications_html = "";
$status['0'] = "Pending";
$status['1'] = "Active";
$status['2'] = "Rejected";

while ($row = mysqli_fetch_assoc($mentorships)) {
    $mentee_id = $row['id'];
    if ($_SESSION['account_type'] == "mentee") {
        $mentee_id = mysqli_fetch_assoc(mysqli_query($connect, "select fk_user_id from mentees where id = {$row['mentee_id']}"));
        $mentee_id = $mentee_id['fk_user_id'];
    }
    $relationships_html =  $relationships_html .
        "<div class='card shadow'>
    <div class='row p-3'>
    
    <div class='col-md-8'>
      <div class='card-body'>
        <h5 class='card-title'>{$row['first_name']} {$row['last_name']}</h5>
        <p class='card-text'>{$row['occupation']}</p>
        <p class='card-text'>{$row['location']}</p>
        <p class='card-text'>{$row['email']}</p>
        <p class='card-text' id='longTxt'>{$row['about']}</p>    
      </div>
    </div>
    <div class='col-md-4'>
      <img src='pictures/{$row['picture']}' class='img-fluid rounded-start' alt='...'>
    </div>
  </div>
        <form class='text-center mb-3' action='cancel_relationship.php' method='post'>
            <button type='submit' name='cancel' value='true' class='btn btn-danger btn-lg'>End Relationship</button>
            <input type='hidden' name='id' value='{$mentee_id}'>
        </form>
</div>";
}


while ($row = mysqli_fetch_assoc($applications)) {
    $applications_html = $applications_html . "<tr id='apps'>
    <td>{$status[$row['status']]}</td>
    <td>{$row['date']}</td>
    <td>{$row['first_name']}</td>
    <td>{$row['last_name']}</td>
    <td>{$row['email']}</td>";
    if ($_SESSION['account_type'] == "mentor" && $row['status'] == 0) {
        $applications_html = $applications_html . "<td>
        <form action='modify_application.php' method='post'>
            <button type='submit' name='status' value=1 class='btn btn-brand'>Accept</button>
            <button type='submit' name='status' value=2 class='btn btn-danger'>Reject</button>
            <input type='hidden' name='app_id' value='{$row["app_id"]}' />
        </form>
        </td>";
    }

    $applications_html = $applications_html . "</tr>";
}

$_SESSION['account_type'];


mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Tree | Home</title>
    <?php require_once 'components/head.php'; ?>

    <style>
        <?php include 'styles.css'; ?>
    </style>

</head>

<body>
    <!-- begin navbar -->
    <?php include 'components/navUser.php'; ?>
    <!-- end navbar -->
    <div class="container">

        <section class="p-5">
            <h1 class="p-3 relationships-table">Active Relationship(s)</h1>

            <?= $relationships_html ?>

        </section>

        <!-- Mentors -->
        <section class="p-5">
            <h1 class="p-3 applications-title">Applications</h1>
            <!-- Applications -->
            <table class="table shadow" id="applications-table">
                <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">E-Mail</th>
                    <?php
                    if ($_SESSION['account_type'] == "mentor") {
                        echo '<th scope="col">Actions</th>';
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                    <?= $applications_html ?>
                </tbody>
            </table>
    </div>
    </div>
    </div>
    </section>
    </div>

    <!-- begin footer and js -->
    <?php include 'components/footer.php'; ?>


    <?php require_once 'components/bootjs.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- ugly workaround, we got no time! -->
    <script>
        function myFunction() {
            var x = document.getElementById("applications-table");
            if (document.getElementById("apps")) {
                console.log("its there")
                x.style.display = "default";
            } else {
                x.style.display = "none";
                console.log("its not there")
            }
        }
        myFunction();
    </script>
    <!-- end footer and js -->
</body>

</html>