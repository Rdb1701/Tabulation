<?php
include("../../includes/connection.php");

$criteria = array();
$data  = array();

$query = "
  SELECT * FROM tbl_criteria ORDER BY round_no ASC
";

$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $temp_arr = array();

        $active = "";
        if ($row['is_active'] == 0) {
            $active = '<span class="text-white bg-danger" style="padding: 3px 8px; border-radius: 5px;">Closed</span>';
        }
        if ($row['is_active'] == 1) {
            $active = '<span class="text-white bg-success" style="padding: 3px 8px; border-radius: 5px;">Open</span>';
        }

        $temp_arr['criteria_id']           = $row['criteria_id'];
        $temp_arr['criteria_desc']         = $row['criteria_desc'];
        $temp_arr['criteria_definition']   = $row['criteria_definition'];
        $temp_arr['percentage']            = $row['percentage'];
        $temp_arr['round_no']              = $row['round_no'];
        $temp_arr['active']                = $active;

        $criteria[] = $temp_arr;
    }
}

foreach ($criteria as $key => $value) {
    $button = "
  <td class='text-center'>
  <div class='d-flex justify-content-center order-actions'>
 <button class = 'btn btn-primary btn-sm' onclick= 'edit_criteria(" . $value['criteria_id'] . ")'>Edit</button>&nbsp;
 <button class = 'btn btn-danger btn-sm' onclick= 'delete_criteria(" . $value['criteria_id'] . ")'>Delete</button>
  </div>
</td>
  ";

    $data['data'][] = array($value['criteria_desc'], $value['criteria_definition'], $value['percentage']."%", $value['round_no'],$value['active'], $button);
}


echo json_encode($data);
