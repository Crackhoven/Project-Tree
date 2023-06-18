<?php
// connect to db
require_once 'components/db_connect.php';

// set content-type to json
header('Content-type: application/json');

$output = array();

// check "q" (query) get parameter
if (!isset($_GET['q']) || empty($_GET['q'])) {
  $output['error'] = 'No query provided.';
  echo json_encode($output);
  return;
}

// create search string
$search = trim($_GET['q'], '%');
$search = "{$search}%";

// sql statement
$sql = "SELECT name FROM skills WHERE name LIKE ?";
$stmt = $connect->prepare($sql);

// use bind parameters to prevent sql injection
$stmt->bind_param("s", $search);
// execute statement
$stmt->execute();
// get result
$result = $stmt->get_result();
// close db connection
$stmt->close();

// iterate fetched result and extend the output
while ($row = $result->fetch_assoc()) {
  $output[] = $row;
}

// return output to json 
echo json_encode($output);
