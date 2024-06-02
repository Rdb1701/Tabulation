<?php
$dashboard = array();
$data  = array();

$round_no = "";

$sql_round = "SELECT * FROM active_round";
$result_round = $db->query($sql_round);
$numRows = $result_round->num_rows;
if ($numRows > 0) {
    $row = $result_round->fetch_assoc();

    $round_no = $row['round_no'];
}

try {

$query = "
SET SESSION group_concat_max_len = 1000000;

SELECT
    GROUP_CONCAT(
        DISTINCT CONCAT(
            'MAX(CASE WHEN tb.criteria_id = ',
            crt.criteria_id,
            ' THEN tb.score ELSE NULL END) AS ',
            CONCAT('`','criteria_', crt.criteria_desc, ' ',crt.percentage,'`')
        )
    ) INTO @criteria_scores
FROM
    tbl_criteria AS crt
WHERE
    crt.round_no = $round_no;

SET @sql = CONCAT(
    'SELECT
       u.full_name,
       c.seq_no,
        c.contestant_name,
        ', @criteria_scores, ',
        SUM(ROUND(tb.score, 2)) AS total_score,
        SUM(ROUND(tb.score / 10 * crt.percentage, 2)) AS total_percentage,
        RANK() OVER (PARTITION BY tb.user_id ORDER BY total_percentage DESC) AS rank_per_judge
    FROM
        tbl_tabulations AS tb
        LEFT JOIN tbl_contestant_round AS cr ON cr.contestant_round_id = tb.contestant_round_id
        LEFT JOIN tbl_contestant AS c ON c.contestant_id = cr.contestant_id
        LEFT JOIN tbl_criteria AS crt ON crt.criteria_id = tb.criteria_id
        LEFT JOIN tbl_users as u ON u.user_id = tb.user_id
    WHERE
        crt.round_no = $round_no
    GROUP BY
        tb.user_id,
        c.contestant_id,
        c.contestant_name,
        c.seq_no;'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

";

if (mysqli_multi_query($db, $query)) {
    do {
        if ($result = mysqli_store_result($db)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $temp_arr = array();

                $temp_arr['full_name']          = $row['full_name'];
                $temp_arr['contestant_name']    = $row['contestant_name'];
                $temp_arr['seq_no']             = $row['seq_no'];
                $temp_arr['total_score']        = $row['total_score'];
                $temp_arr['total_percentage']   = $row['total_percentage'];
                $temp_arr['rank_per_judge']     = $row['rank_per_judge'];
                // Loop through the dynamic criteria scores
                foreach ($row as $key => $value) {
                    if (strpos($key, 'criteria_') !== false) {
                        $temp_arr[$key] = $value;
                    }
                }
               
                $dashboard[] = $temp_arr;
            }
            mysqli_free_result($result);
        }
    } while (mysqli_next_result($db));
}else{
    echo "<h3 class='text-center fw-bold'>No Tabulation Yet</h3>";
}

} catch (mysqli_sql_exception $e) {
    // Handle the exception
    echo "<script>console.log(" . json_encode($e->getMessage()) . ");</script>";
    echo "<script>alert('The active round you set has no round in the criterias')</script>";
}
?>
