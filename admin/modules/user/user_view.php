<?php
include("../../includes/connection.php");

$users = array();
$data  = array();

$query = "
  SELECT us.*, ur.roles_desc
  FROM tbl_users as us
  LEFT JOIN tbl_users_role as ur ON ur.roles_id = us.roles_id
  ORDER BY us.user_id ASC
";

$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $temp_arr = array();

        $active = "";
        if ($row['active'] == 0) {
            $active = '<span class="text-white bg-warning" style="padding: 3px 8px; border-radius: 5px;">Inactive</span>';
        }
        if ($row['active'] == 1) {
            $active = '<span class="text-white bg-success" style="padding: 3px 8px; border-radius: 5px;">Active</span>';
        }

        $temp_arr['user_id']     = $row['user_id'];
        $temp_arr['username']    = $row['username'];
        $temp_arr['full_name']   = $row['full_name'];
        $temp_arr['roles_desc']  = $row['roles_desc'];
        $temp_arr['active']      = $active;


        $users[] = $temp_arr;
    }
}

foreach ($users as $key => $value) {
    $button = "
  <td class='text-center'>
  <div class='d-flex justify-content-center order-actions'>
 <button class = 'btn btn-primary btn-sm' onclick= 'edit_user(" . $value['user_id'] . ")'>Edit</button>&nbsp;
 <button class = 'btn btn-danger btn-sm' onclick= 'delete_user(" . $value['user_id'] . ")'>Delete</button>
  </div>
</td>
  ";
    $data['data'][] = array($value['full_name'], $value['roles_desc'], $value['active'], $button);
}


echo json_encode($data);
