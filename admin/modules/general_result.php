<?php
include("../header.php");
include "dash/general_results.php"; // Include this file to access $general_result
?>
<style>
    table {
        table-layout: auto;
        width: 100%;

    }

    td,
    th {
        text-wrap: wrap;
    }
</style>
<h5><i class="fa fa-trophy"></i> General Tabulated Result</h5>
<hr>
<div class="card radius-10">
    <div class="card-body">
        <h6> General Tabulated Summary Based on Percentage Per Judge</h6>
        <hr>
        <div class="table-responsive">
            <table id="my_table" class="table display table-bordered bg-light" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" colspan="2"></th>
                        <!-- Dynamic columns for judge percentages -->
                        <?php
                        $query = "SELECT DISTINCT tb.user_id, us.full_name FROM tbl_tabulations as tb 
                LEFT JOIN tbl_users as us ON us.user_id = tb.user_id";
                        $result = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<th colspan = '2' class = 'text-center'>" . $row['full_name'] . "</th>";
                        }
                        ?>
                        <th class="text-center" colspan="2"></th>
                    </tr>

                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-left">Contestant Name</th>
                        <!-- Dynamic columns for judge percentages -->
                        <?php
                        $query = "SELECT DISTINCT tb.user_id, us.full_name FROM tbl_tabulations as tb 
                LEFT JOIN tbl_users as us ON us.user_id = tb.user_id";
                        $result = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<th>% Score</th>";
                            echo "<th>Rank</th>";
                        }
                        ?>
                        <th class="text-center">Avg Percentage</th>
                        <th class="text-center">Final Rank</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($general_result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['seq_no'] . "</td>";
                        echo "<td>" . $row['contestant_name'] . "</td>";
                        // Display dynamic judge percentages
                        // Display dynamic criteria scores
                        foreach ($row as $key => $value) {
                            if (strpos($key, 'judge_') !== false) {
                                if ($value !== null) {
                                    // Split the concatenated value into total percentage and rank per judge
                                    list($percentage, $rank) = explode(' ', $value);
                                    echo '<td class="text-center bg-light">' . $percentage . '</td>';
                                    echo '<td class="text-center bg-light">' . $rank . '</td>';
                                    $hasData = true; // Data exists, set flag to true
                                } else {
                                    echo '<td class="text-center"></td>';
                                    echo '<td class="text-center"></td>';
                                }
                            }
                        }

                        echo "<td class='text-center'>" . $row['average_percentage'] . "</td>";
                        // Apply background color based on rank
                        $rank = (int)$row['overall_rank'];
                        $bg_color = '';
                        switch ($rank) {
                            case 1:
                                $bg_color = 'bg-danger';
                                break;
                            case 2:
                                $bg_color = 'bg-warning';
                                break;
                            case 3:
                                $bg_color = 'bg-success';
                                break;
                            case 4:
                                $bg_color = 'bg-primary';
                                break;
                            case 5:
                                $bg_color = 'bg-secondary';
                                break;
                            default:
                                $bg_color = '';
                        }
                        echo "<td class='text-center overall-rank $bg_color'>" . $row['overall_rank'] . "</td>";

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<div class="card radius-10">
    <div class="card-body">
        <h6> General Tabulated Summary Based on Rank Per Judge</h6>
        <hr>
        <div class="table-responsive">
            <table id="my_table_2" class="table display table-bordered bg-light" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" colspan="2"></th>
                        <!-- Dynamic columns for judge percentages -->
                        <?php
                        $query = "SELECT DISTINCT tb.user_id, us.full_name FROM tbl_tabulations as tb 
                LEFT JOIN tbl_users as us ON us.user_id = tb.user_id";
                        $result = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<th colspan = '2' class = 'text-center'>" . $row['full_name'] . "</th>";
                        }
                        ?>
                        <th class="text-center" colspan="2"></th>
                    </tr>

                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-left">Contestant Name</th>
                        <!-- Dynamic columns for judge percentages -->
                        <?php
                        $query = "SELECT DISTINCT tb.user_id, us.full_name FROM tbl_tabulations as tb 
                LEFT JOIN tbl_users as us ON us.user_id = tb.user_id";
                        $result = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<th>% Score</th>";
                            echo "<th>Rank</th>";
                        }
                        ?>
                        <th class="text-center">Avg Rank</th>
                        <th class="text-center">Final Rank</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($general_result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['seq_no'] . "</td>";
                        echo "<td>" . $row['contestant_name'] . "</td>";
                        // Display dynamic judge percentages
                        // Display dynamic criteria scores
                        foreach ($row as $key => $value) {
                            if (strpos($key, 'judge_') !== false) {
                                if ($value !== null) {
                                    // Split the concatenated value into total percentage and rank per judge
                                    list($percentage, $rank) = explode(' ', $value);
                                    echo '<td class="text-center bg-light">' . $percentage . '</td>';
                                    echo '<td class="text-center bg-light">' . $rank . '</td>';
                                    $hasData = true; // Data exists, set flag to true
                                } else {
                                    echo '<td class="text-center"></td>';
                                    echo '<td class="text-center"></td>';
                                }
                            }
                        }

                        echo "<td class='text-center'>" . $row['average_rank'] . "</td>";
                        // Apply background color based on rank
                        $rank_avg = (int)$row['average_final_rank'];
                        $bg_color_rank = '';
                        switch ($rank_avg) {
                            case 1:
                                $bg_color_rank = 'bg-danger';
                                break;
                            case 2:
                                $bg_color_rank = 'bg-warning';
                                break;
                            case 3:
                                $bg_color_rank = 'bg-success';
                                break;
                            case 4:
                                $bg_color_rank = 'bg-primary';
                                break;
                            case 5:
                                $bg_color_rank = 'bg-secondary';
                                break;
                            default:
                                $bg_color_rank = '';
                        }
                        echo "<td class='text-center overall-rank $bg_color_rank'>" . $row['average_final_rank'] . "</td>";

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include "../footer.php"; ?>
<script>
    $(document).ready(function() {
        $('#my_table').DataTable({
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false,
            dom: "Bfrtip",
            buttons: [{
                    extend: "csv",
                    className: "btn-sm ",
                },
                {
                    extend: "excel",
                    className: "btn-sm btn btn-success",
                },
                {
                    extend: "print",
                    className: "btn-sm btn btn-success",
                    title: '.',
                    message: function() {
                        return '<div style="position:relative;">\
                            <img src="../assets/images/loreto1.png" height="100px" width="100px" style="position: absolute;top:0;left:50px;">\
                            <img src="../assets/images/sfxc.png" height="100px" width="100px" style="position: absolute;top:0;left:150px;">\
                            <center><h4 style="margin-top:-40px;">GENERAL TABULATED SUMMARY</h4><h6>SFXC TABULATION SYSTEM</h6></center><br><br>\
                        </div>';
                    },
                    customize: function(win) {

                        $(win.document.body).find('table').addClass('table-bordered'); // Add border to printed table

                        // Apply background color to the last column of each row based on row data
                        $(win.document.body).find('table tr').each(function() {
                            var rank = parseInt($(this).find('td:last-child').text().trim());
                            var bgColor = '';
                            switch (rank) {
                                case 1:
                                    bgColor = 'red';
                                    break;
                                case 2:
                                    bgColor = 'yellow';
                                    break;
                                case 3:
                                    bgColor = 'lightgreen';
                                    break;
                                case 4:
                                    bgColor = 'skyblue';
                                    break;
                                case 5:
                                    bgColor = 'gray';
                                    break;
                                case 6:
                                    bgColor = 'violet';
                                    break;
                                case 7:
                                    bgColor = 'lightgray';
                                    break;
                                case 8:
                                    bgColor = 'pink';
                                    break;
                                default:
                                    bgColor = '';
                            }
                            $(this).find('td:last-child').css('background-color', bgColor);
                            $(this).find('td:last-child').css('font-weight', 'bold');
                        });
                        //Remove Body Background color
                        $(win.document.body).css('background-color', 'transparent');
                        $(win.document.body).find('table').addClass('table-bordered').css('border-color', 'green');
                    }
                }
            ]
        });

        $('#my_table_2').DataTable({
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false,
            dom: "Bfrtip",
            buttons: [{
                    extend: "csv",
                    className: "btn-sm ",
                },
                {
                    extend: "excel",
                    className: "btn-sm btn btn-success",
                },
                {
                    extend: "print",
                    className: "btn-sm btn btn-success",
                    title: '.',
                    message: function() {
                        return '<div style="position:relative;">\
                            <img src="../assets/images/loreto1.png" height="100px" width="100px" style="position: absolute;top:0;left:50px;">\
                            <img src="../assets/images/sfxc.png" height="100px" width="100px" style="position: absolute;top:0;left:150px;">\
                            <center><h4 style="margin-top:-40px;">GENERAL TABULATED SUMMARY</h4><h6>SFXC TABULATION SYSTEM</h6></center><br><br>\
                        </div>';
                    },
                    customize: function(win) {

                        $(win.document.body).find('table').addClass('table-bordered'); // Add border to printed table

                        // Apply background color to the last column of each row based on row data
                        $(win.document.body).find('table tr').each(function() {
                            var rank = parseInt($(this).find('td:last-child').text().trim());
                            var bgColor = '';
                            switch (rank) {
                                case 1:
                                    bgColor = 'red';
                                    break;
                                case 2:
                                    bgColor = 'yellow';
                                    break;
                                case 3:
                                    bgColor = 'lightgreen';
                                    break;
                                case 4:
                                    bgColor = 'skyblue';
                                    break;
                                case 5:
                                    bgColor = 'gray';
                                    break;
                                case 6:
                                    bgColor = 'violet';
                                    break;
                                case 7:
                                    bgColor = 'lightgray';
                                    break;
                                case 8:
                                    bgColor = 'pink';
                                    break;
                                default:
                                    bgColor = '';
                            }
                            $(this).find('td:last-child').css('background-color', bgColor);
                            $(this).find('td:last-child').css('font-weight', 'bold');
                        });
                        //Remove Body Background color
                        $(win.document.body).css('background-color', 'transparent');
                        $(win.document.body).find('table').addClass('table-bordered').css('border-color', 'green');
                    }
                }
            ]
        });
    });
</script>