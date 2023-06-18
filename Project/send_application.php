<?php
session_start();
require_once 'components/db_connect.php';
require_once 'components/get_details.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}


if (isset($_POST['apply'])) {
  $mentor_id = $_POST['mentor_id'];
  $mentee_id = $_POST['mentee_id'];
  $perform_app_sql = "insert into applications values(NULL, (select id from mentees where fk_user_id=${mentee_id}), (select id from mentors where fk_user_id=${mentor_id}), 0, now())";
  print($perform_app_sql);
  $apply_db = mysqli_query($connect, $perform_app_sql);
  header("Location: profile.php?id=${_POST['mentor_id']}");
  exit;
} else {
  echo "go away!";
}
