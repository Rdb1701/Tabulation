<?php
include "../header.php";
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

    thead {
        position: sticky;
        top: 0;
        z-index: 100;
    }
</style>
<h5>Criteria of Judging</h5><br>

<button class="btn btn-md btn-rasied btn-success btn-sm" onclick="add_criteria()"><i class="fa fa-plus"></i> Add Criteria</button><br><br>
<div class="card radius-10">
    <div class="card-body">
        <div class="table-responsive table-wrapper">
            <table class="table table-bordered table-hover" id="myTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Criteria</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">% Criteria</th>
                        <th class="text-center">Valid Round</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>

                    </tr>
                </thead>
                <tbody style="overflow: auto;">

                </tbody>
            </table>
        </div>
    </div>
</div>




<?php
include "../footer.php";
include "modal/modal_criteria.php";
?>

<script>
    function add_criteria() {
        $('#list_add_modal').modal({
            backdrop: 'static',
            keyboard: false
        })
        $('#list_add_modal').modal('show')
    }


    //EDIT 
    function edit_criteria(criteria_id) {
        $.ajax({
            url: 'criteria_judging/criteria_edit',
            type: 'POST',
            data: {
                criteria_id: criteria_id

            },
            dataType: 'JSON',
            beforeSend: function() {

            }
        }).done(function(res) {

            $("#criteria_id").val(res.criteria_id);
            $("#edit_criteria").val(res.criteria);
            $("#edit_desc").val(res.criteria_desc);
            $("#edit_percentage").val(res.percentage);
            $("#edit_round").val(res.round);
            $("#edit_active").val(res.active);
            $('#list_edit_modal').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#list_edit_modal').modal('show');

        }).fail(function() {
            console.log("FAIL");
        })
    }

    function delete_criteria(criteria_id) {
        if (confirm("Are you sure you want to delete Criteria?")) {
            $.ajax({
                url: 'criteria_judging/criteria_delete',
                type: 'POST',
                data: {
                    criteria_id: criteria_id

                },
                dataType: 'JSON',
                beforeSend: function() {

                }
            }).done(function(res) {
                if (res.res_success == 1) {
                    swal('Successfully Deleted', '', 'success');

                    var currentPageIndex = table.page.info().page;
                    table.ajax.reload(function() {
                        table.page(currentPageIndex).draw(false);
                    }, false);

                } else {
                    alert(res.res_message);
                }
            }).fail(function() {
                console.log("FAIL");
            })
        }
    }

    // Initialize DataTable
    var table = $('#myTable').DataTable({
        ajax: 'criteria_judging/criteria_view', 
        "ordering": false,
        searching: false, paging: false,
        columns: [{
                data: [0],
                "className": "text-center"
            },
            {
                data: [1],
                "className": "text-center"
            },
            {
                data: [2],
                "className": "text-center"
            },
            {
                data: [3],
                "className": "text-center"
            },
            {
                data: [4],
                "className": "text-center"
            },
            {
                data: [5],
                "className": "text-center"
            }
        ]
    });


    $(document).ready(function() {

        //-------------------------------------------- ADD ---------------------------------------//
        $('#form_insert').on('submit', function(e) {
            e.preventDefault();

            let criteria = $('#add_criteria').val();
            let criteria_desc = $('#add_desc').val();
            let percentage = $('#add_percentage').val();
            let round = $('#add_round').val();
            let active = $('#add_active').val();

            $.ajax({
                url: 'criteria_judging/criteria_add',
                type: 'POST',
                data: {
                    criteria: criteria,
                    criteria_desc: criteria_desc,
                    percentage: percentage,
                    round: round,
                    active: active
                },
                dataType: 'JSON',
                beforeSend: function() {

                }
            }).done(function(res) {
                if (res.res_success == 1) {
                    swal('Successfully Addedss', '', 'success');
                    var currentPageIndex = table.page.info().page;
                    table.ajax.reload(function() {
                        table.page(currentPageIndex).draw(false);
                    }, false);

                    $('#list_add_modal').modal('hide');
                } else {
                    swal(`${res.res_message}`, '', 'error');
                }

            }).fail(function() {
                console.log('fail')
            })
        })



        //--------------------------------------------UPDATE ---------------------------------------//
        $('#form_update').on('submit', function(e) {
            e.preventDefault();

            let criteria = $('#edit_criteria').val();
            let criteria_desc = $('#edit_desc').val();
            let percentage = $('#edit_percentage').val();
            let round = $('#edit_round').val();
            let active = $('#edit_active').val();
            let criteria_id = $('#criteria_id').val();

            $.ajax({
                url: 'criteria_judging/criteria_update',
                type: 'POST',
                data: {
                    criteria: criteria,
                    criteria_desc: criteria_desc,
                    percentage: percentage,
                    round: round,
                    active: active,
                    criteria_id: criteria_id
                },
                dataType: 'JSON',
                beforeSend: function() {

                }
            }).done(function(res) {
                if (res.res_success == 1) {
                    swal('Successfully Updated', '', 'success');
                    var currentPageIndex = table.page.info().page;
                    table.ajax.reload(function() {
                        table.page(currentPageIndex).draw(false);
                    }, false);

                    $('#list_edit_modal').modal('hide');
                } else {
                    swal(`${res.res_message}`, '', 'error');
                }

            }).fail(function() {
                console.log('fail')
            })
        })

    })
</script>