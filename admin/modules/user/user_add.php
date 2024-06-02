<?php date_default_timezone_set('Asia/Manila');

include("../../includes/connection.php");
$username    = mysqli_real_escape_string($db, trim($_POST['username']));
$name        = mysqli_real_escape_string($db, trim($_POST['name']));
$roles       = mysqli_real_escape_string($db, trim($_POST['roles']));
$active      = mysqli_real_escape_string($db, trim($_POST['active']));

$data = array();
$res_success = 0;
$res_message = "";

$query = "
SELECT * FROM tbl_users
WHERE username = '$username'
";

$result = mysqli_query($db, $query);

if (!mysqli_num_rows($result)) {

    $query = "
    INSERT INTO tbl_users(username,
        password,
        full_name,
        roles_id,
        active) VALUES('$username',
        '".md5($username)."',
        '$name',
        '$roles',
        '$active'
    )
    ";

    if (mysqli_query($db, $query)) {
        $res_success = 1;
    } else {
        $res_message = "Query Failed";
    }

} else {
    $res_message = "Username already Exists ";
}

$data['res_success'] = $res_success;
$data['res_message'] = $res_message;


echo json_encode($data);





?>