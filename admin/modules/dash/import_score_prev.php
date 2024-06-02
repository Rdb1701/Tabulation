<?php
include "../../includes/connection.php";

$import_prev_score = array();
$data              = array();
$res_success       = 0;
$res_message       = "";
$prev_score        = "";

$prev_round           = mysqli_real_escape_string($db, trim($_POST['prev_round']));
$curr_criteria        = mysqli_real_escape_string($db, trim($_POST['curr_criteria']));
$contestant_curr      = mysqli_real_escape_string($db, trim($_POST['contestant_curr']));

// converted Average to rating 0-10
$query = "
SET SESSION group_concat_max_len = 1000000;

SELECT
    GROUP_CONCAT(DISTINCT
        CONCAT(
            'MAX(CASE WHEN user_id = ',
            user_id,
            ' THEN total_percentage END) AS judge_',
            REPLACE(full_name, ' ', '_'), '_percentage'
        )
    ) INTO @sql
FROM
    (SELECT DISTINCT tb.user_id, us.full_name FROM tbl_tabulations as tb 
     LEFT JOIN tbl_users as us ON us.user_id = tb.user_id) judges;

SET @sql = CONCAT('
    WITH TotalPercentages AS (
        SELECT
            c.contestant_id,
            c.contestant_name,
            c.seq_no,
            tb.user_id AS user_id,
            us.username,
            tb.contestant_round_id,
            SUM(ROUND(tb.score / 10 * crt.percentage, 2)) AS total_percentage
        FROM
            tbl_tabulations AS tb
            LEFT JOIN tbl_contestant_round AS cr ON cr.contestant_round_id = tb.contestant_round_id
            LEFT JOIN tbl_contestant AS c ON c.contestant_id = cr.contestant_id
            LEFT JOIN tbl_criteria AS crt ON crt.criteria_id = tb.criteria_id
            LEFT JOIN tbl_users as us ON us.user_id = tb.user_id
        WHERE
            crt.round_no = $prev_round
        AND
        c.contestant_id IN (
            SELECT DISTINCT c.contestant_id
            FROM tbl_tabulations AS tb
            LEFT JOIN tbl_contestant_round AS cr ON cr.contestant_round_id = tb.contestant_round_id
            LEFT JOIN tbl_contestant AS c ON c.contestant_id = cr.contestant_id
            WHERE tb.contestant_round_id = $contestant_curr
        )
        GROUP BY
            c.contestant_id,
            c.contestant_name,
            c.seq_no,
            tb.user_id
    )
    SELECT
        contestant_id,
        contestant_name,
        seq_no,
        contestant_round_id,
        ROUND(AVG(total_percentage),2) AS average_percentage,
        ROUND(AVG(total_percentage) * 10 / 100, 2) AS rating_score,
        RANK() OVER (ORDER BY AVG(total_percentage) DESC) AS overall_rank
    FROM
        TotalPercentages
    GROUP BY
        contestant_id,
        contestant_name,
        seq_no
');

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
";



if ($db->multi_query($query)) {
    do {
        if ($result = mysqli_store_result($db)) {
            while ($row = mysqli_fetch_assoc($result)) {
              $prev_score =   $row['rating_score'];
  
            }
            mysqli_free_result($result);
        }
    } while (mysqli_next_result($db));
} else {
    echo "<h3 class='text-center fw-bold'>No Tabulation Yet</h3>";
}



 //IMPORT SCORES PREVIOUS ROUND
 $query_update = "
 UPDATE tbl_tabulations
 SET
 score               = '$prev_score'
 WHERE
 contestant_round_id = '$contestant_curr'
 AND 
 criteria_id         = '$curr_criteria'
 ";

if ($db->query($query_update)) {
 $res_success = 1;
} else {
 $res_message = "Failed Importing Previous Scores";
}




$data['res_success']  = $res_success;
$data['prev_score']   = $prev_score;
$data['res_message']  = $res_message;

echo json_encode($data);
