<?php
include("../../includes/connection.php");

$contestant = array();
$data  = array();

$query = "
  SELECT * FROM tbl_contestant ORDER BY seq_no ASC
";

$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $temp_arr = array();

        $active = "";
        if ($row['is_active'] == 0) {
            $active = '<span class="text-white bg-warning" style="padding: 3px 8px; border-radius: 5px;">Inactive</span>';
        }
        if ($row['is_active'] == 1) {
            $active = '<span class="text-white bg-success" style="padding: 3px 8px; border-radius: 5px;">Active</span>';
        }

        $temp_arr['contestant_id']         = $row['contestant_id'];
        $temp_arr['contestant_name']       = $row['contestant_name'];
        $temp_arr['photo']                 = $row['photo'];
        $temp_arr['sequece_no']            = $row['seq_no'];
        $temp_arr['active']                = $active;

        $contestant[] = $temp_arr;
    }
}

foreach ($contestant as $key => $value) {

    $image = "<img src='contestants/uploads/".$value['photo']."' alt='No Photo' width='70px'>";

    $button = "
  <td class='text-center'>
  <div class='d-flex justify-content-center order-actions'>
  <button class = 'btn btn-warning btn-sm' onclick= 'upload_photo(" . $value['contestant_id'] . ")'><i class='fa fa-upload'></i></button>&nbsp;
 <button class = 'btn btn-primary btn-sm' onclick= 'edit_contestant(" . $value['contestant_id'] . ")'>Edit</button>&nbsp;
 <button class = 'btn btn-danger btn-sm' onclick= 'delete_contestant(" . $value['contestant_id'] . ", \"".$value['photo']."\")'>Delete</button>
  </div>
</td>
  ";

    $data['data'][] = array($value['sequece_no'],$image, $value['contestant_name'], $value['active'],$button);
}


echo json_encode($data);
