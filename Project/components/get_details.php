<?php
$backBtn = '';
if (isset($_SESSION["user"])) {
  $backBtn = "home.php";
}
if (isset($_SESSION["admin"])) {
  $backBtn = "dashboard.php";
}

$user_found = false;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM users WHERE id = {$id}";
  $result = mysqli_query($connect, $sql);
  if (mysqli_num_rows($result) == 1) {
    $data = mysqli_fetch_assoc($result);
    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $email = $data['email'];
    $location = $data['location'];
    $website = $data['website'];
    $occupation = $data['occupation'];
    $about = $data['about'];
    $picture = $data['picture'];
    $user_found = true;
  }
}
