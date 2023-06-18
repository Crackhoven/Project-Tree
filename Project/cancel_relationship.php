<?php
# quick and dirty, just like this course ;)
session_start();
require_once 'components/db_connect.php';
require_once 'components/get_details.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}


if (isset($_POST['cancel'])) {
  $id = $_POST['id'];
  $cancel_sql = "UPDATE mentees SET fk_mentor_id = NULL where fk_user_id = $id";
  print($cancel_sql . "<br>");
  mysqli_query($connect, $cancel_sql);
  // set mentor_id in mentees
  // if ($status == 1) {
  //   $set_mentor_sql = "UPDATE mentees set fk_mentor_id = (select fk_mentor_id from applications where id = ${app_id}) where id = (select fk_mentee_id from applications where id = ${app_id})";

  //   print($set_mentor_sql . "<br>");
  // mysqli_query($connect, $set_mentor_sql);
  // }
  header("Location: home.php");
  exit;
} else {
  echo "go away!";
}
