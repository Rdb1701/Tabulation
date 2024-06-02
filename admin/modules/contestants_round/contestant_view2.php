<?php
include("../../includes/connection.php");

extract($_POST);
$contestant = array();
$data  = array();

$query = "
  SELECT cpr.*, c.contestant_name,c.photo, c.seq_no
  FROM tbl_contestant_round as cpr 
  LEFT JOIN tbl_contestant as c ON c.contestant_id = cpr.contestant_id
  WHERE cpr.round_no  = '$tvalue'
  ORDER BY cpr.contestant_round_id ASC
";

$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $temp_arr = array();


        $temp_arr['contestant_round_id']   = $row['contestant_round_id'];
        $temp_arr['contestant_id']         = $row['contestant_id'];
        $temp_arr['contestant_name']       = $row['contestant_name'];
        $temp_arr['round_no']              = $row['round_no'];
        $temp_arr['photo']                 = $row['photo'];
        $temp_arr['sequece_no']            = $row['seq_no'];

        $contestant[] = $temp_arr;
    }
}

foreach ($contestant as $key => $value) {

    $image = "<img src='contestants/uploads/".$value['photo']."' alt='No Photo' width='70px'>";

    $button = "
  <td class='text-center'>
  <div class='d-flex justify-content-center order-actions'>
 <button class = 'btn btn-danger btn-sm' onclick= 'delete_contestant_round(" . $value['contestant_round_id'] . ")'>Delete</button>
  </div>
</td>
  ";

    $data['data'][] = array($value['sequece_no'],$image, $value['contestant_name'],$value['round_no'],$button,$value['contestant_round_id']);
}


echo json_encode($data);
