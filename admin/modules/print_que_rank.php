<?php
include("../header.php");
include "dash/general_results.php"; 
?>
<style>
    table {
        table-layout: auto;
        width: 100%;
        margin: 20px 0;
    }

    td,
    th {
        padding: 12px;
        text-wrap: wrap;
    }

    th {
        background-color: #f8f9fa;
    }

    .overall-rank {
        font-weight: bold;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }

    .bg-warning {
        background-color: #ffc107 !important;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-primary {
        background-color: #007bff !important;
    }

    .bg-secondary {
        background-color: #6c757d !important;
    }
</style>
<h5><i class="fa fa-trophy"></i> General Tabulated Result</h5>
<hr>
<div class="card radius-10">
    <div class="card-body">
        <h6> General Tabulated Summary Based on Rank Per Judge</h6>
        <hr>
        <div class="table-responsive">
            <table id="my_table_2" class="table display table-bordered bg-light" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center" colspan="2"></th>
                    </tr>
                    <tr>
                        <th class="text-left">Contestant Name</th>
                        <th class="text-center">Avg Rank</th>
                        <th class="text-center">Final Rank</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 0;
                    foreach ($general_result as $row) {
                        if ($counter >= 5) break; // Limit to top 5
                        echo "<tr>";
                        echo "<td>" . $row['contestant_name'] . "</td>";
                        echo "<td class='text-center'>" . $row['average_rank'] . "</td>";
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
                        $counter++;
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
        $('#my_table_2').DataTable({
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false,
            dom: "Bfrtip",
            buttons: [{
                    extend: "csv",
                    className: "btn-sm",
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
                            <img src="../assets/images/angot_logo.png" height="100px" width="100px" style="position: absolute;top:0;left:50px;">\
                            <center><h4 style="margin-top:-40px;">GENERAL TABULATED SUMMARY</h4><h6>TABULATION SYSTEM</h6></center><br><br>\
                        </div>';
                    },
                    customize: function(win) {
                     
                        $(win.document.body).find('table').css('font-size', '1.5em');
                        $(win.document.body).find('table th, table td').css('padding', '15px');

                        
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
                                default:
                                    bgColor = '';
                            }
                            $(this).find('td:last-child').css('background-color', bgColor);
                            $(this).find('td:last-child').css('font-weight', 'bold');
                        });

                      
                        $(win.document.body).css('background-color', 'transparent');
                        $(win.document.body).find('table').addClass('table-bordered').css('border-color', 'green');
                    }
                }
            ]
        });
    });
</script>
