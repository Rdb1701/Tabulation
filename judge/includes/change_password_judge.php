<?php

require_once 'connection.php';

$data = array();

$password = mysqli_real_escape_string($db, trim($_POST['password']));

$query  = "
  UPDATE tbl_users
  SET password = '".md5($password)."' 
  WHERE user_id= '".$_SESSION['judge']['user_id']."'
";
mysqli_query($db, $query);

echo json_encode($data);

?>
