<?php
# quick and dirty, just like this course ;)
session_start();
require_once 'components/db_connect.php';
require_once 'components/get_details.php';

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}


if (isset($_POST['status'])) {
  $app_id = $_POST['app_id'];
  $status = $_POST['status'];
  $modify_app_sql = "UPDATE applications SET status = $status where id = $app_id";
  mysqli_query($connect, $modify_app_sql);
  if ($status == 1) {
    $set_mentor_sql = "UPDATE mentees set fk_mentor_id = (select fk_mentor_id from applications where id = ${app_id}) where id = (select fk_mentee_id from applications where id = ${app_id})";
    mysqli_query($connect, $set_mentor_sql);
    $del_app = "DELETE from applications where id = {$app_id}";
    print($del_app);
    mysqli_query($connect, $del_app);
  }
  header("Location: home.php");
  exit;
} else {
  echo "go away!";
}
