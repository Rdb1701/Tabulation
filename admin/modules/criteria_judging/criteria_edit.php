<?php
include("../../includes/connection.php");


$criteria_id = mysqli_real_escape_string($db, trim($_POST['criteria_id']));

$data = array();

$criteria       = '';
$criteria_desc  = '';
$percentage     = '';
$round          = '';
$active         = '';



$query = "
SELECT * FROM tbl_criteria
WHERE criteria_id = '$criteria_id'
";

$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {

  $row = mysqli_fetch_assoc($result);

  $criteria          = $row['criteria_desc'];
  $criteria_desc     = $row['criteria_definition'];
  $percentage        = $row['percentage'];
  $round             = $row['round_no'];
  $active            = $row['is_active'];
 
}

$data['criteria_id']       = $criteria_id;
$data['criteria']          = $criteria;
$data['criteria_desc']     = $criteria_desc;
$data['percentage']        = $percentage;
$data['round']             = $round;
$data['active']            = $active;



echo json_encode($data);


?>