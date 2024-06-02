<?php
include("../../includes/connection.php");


$contestant_id = mysqli_real_escape_string($db, trim($_POST['contestant_id']));

$data = array();

$contestant     = '';
$round_no       = '';
$active         = '';

$query = "
SELECT * FROM tbl_contestant
WHERE contestant_id = '$contestant_id'
";

$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {

  $row = mysqli_fetch_assoc($result);

  $contestant          = $row['contestant_name'];
  $round_no            = $row['seq_no'];
  $active              = $row['is_active'];
  
 
}

$data['contestant_id']       = $contestant_id;
$data['contestant']          = $contestant;
$data['round_no']            = $round_no;
$data['active']              = $active;



echo json_encode($data);


?>