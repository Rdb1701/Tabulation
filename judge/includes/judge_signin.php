<?php

include('connection.php');


$data        = array();
$res_success = 0;
$res_message = 0;
$errors = array();

$us = mysqli_escape_string($db, trim($_POST['username']));
$pw = mysqli_escape_string($db, trim($_POST['password']));

if (empty($us)) {
  array_push($errors, "Username is Required");
}
if (empty($pw)) {
  array_push($errors, "Password is Required");
}
if (count($errors) == 0) {

  // LOGIN
    $query = "
      SELECT * FROM tbl_users 
      WHERE 
      (username = '$us' AND password = '".md5($pw)."')
      AND
      active = 1 AND roles_id = 3
        ";

    $result = mysqli_query($db, $query) or die('Error in Inserting users in ' . $query);
    if (mysqli_num_rows($result) == 1) {
      //log user in
      $res_success          = 1;
      $row = mysqli_fetch_array($result);
      $_SESSION['judge']     = $row;
    } else {
      array_push($errors, "Wrong username/password combination");
    }
  }


$data['post'] = $_POST;
$data['res_success'] = $res_success;
$data['res_message'] = $errors;


print_r(json_encode($data));


?>