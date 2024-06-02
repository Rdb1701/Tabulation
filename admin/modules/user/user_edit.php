<?php 
include('../../includes/connection.php');

$user_id = mysqli_real_escape_string($db, trim($_POST['user_id']));

$data = array();

$username     = '';
$name         = '';
$roles        = '';
$active       = '';


$user_types = array();

$query = "
  SELECT *
  FROM tbl_users
  WHERE user_id = '$user_id'
";
$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {

  $row = mysqli_fetch_assoc($result);

  $username     = $row['username'];
  $name         = $row['full_name'];
  $roles        = $row['roles_id'];
  $active       = $row['active'];

}

$data['user_id']      = $user_id;
$data['username']     = $username;
$data['name']         = $name;
$data['roles']        = $roles;
$data['active']       = $active;

echo json_encode($data);


?>
