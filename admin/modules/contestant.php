<?php include "../header.php"; ?>
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
<h5>Contestant</h5><br>
<button class="btn btn-md btn-rasied btn-success btn-sm" onclick="add_contestant()"><i class="fa fa-plus"></i> Add Contestant</button><br><br>
<div class="card radius-10">
    <div class="card-body">
        <div class="table-responsive table-wrapper">
            <table class="table table-bordered table-hover" id="myTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 5px;">No.</th>
                        <th class="text-center" style="width: 50px;">Photo.</th>
                        <th class="text-center">Contestant</th>
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
<?php include "../footer.php"; ?>
<?php include "modal/modal_contestant.php"; ?>

<script>
    function add_contestant() {
        $('#list_add_modal').modal({
                backdrop: 'static',
                keyboard: false
            })
        $('#list_add_modal').modal('show');
    }

    function upload_photo(contestant_id) {
        $('#upload_id').val(contestant_id);
        $('#upload_modal').modal({
            backdrop: 'static',
            keyboard: false
        })
        $('#upload_modal').modal('show');
    }


       //EDIT 
       function edit_contestant(contestant_id) {
        $.ajax({
            url: 'contestants/contestant_edit',
            type: 'POST',
            data: {
                contestant_id: contestant_id

            },
            dataType: 'JSON',
            beforeSend: function() {

            }
        }).done(function(res) {

            $("#edit_contestant_id").val(res.contestant_id);
            $("#edit_contestant").val(res.contestant);
            $("#edit_no").val(res.round_no);
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

    function delete_contestant(contestant_id,photo) {
        if (confirm("Are you sure you want to delete Contestant?")) {
            $.ajax({
                url: 'contestants/contestant_delete',
                type: 'POST',
                data: {
                    contestant_id: contestant_id,
                    photo : photo

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
        ajax: 'contestants/contestant_view', 
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
            }
        ]
    });


    $(document).ready(function() {
        //-------------------------------------------- ADD ---------------------------------------//
        $('#form_insert').on('submit', function(e) {
            e.preventDefault();

            let contestant = $('#add_contestant').val();
            let sequence_no = $('#add_no').val();
            let active = $('#add_active').val();


            $.ajax({
                url: 'contestants/contestant_add',
                type: 'POST',
                data: {
                    contestant: contestant,
                    sequence_no: sequence_no,
                    active: active,

                },
                dataType: 'JSON',
                beforeSend: function() {

                }
            }).done(function(res) {
                if (res.res_success == 1) {
                    swal('Successfully Added', '', 'success');
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


        //============================================ UPLOAD PICTURE =========================================>

        $("#upload_form").on("submit", function(e) {
            e.preventDefault();

            var fd = new FormData($("#upload_form")[0]);
            var files = $("#file")[0].files;

            for (item of fd) {
                console.log(item[0], item[1]);
            }
            // Check file selected or not
            if (files.length > 0) {
                fd.append('file', files[0]);


                $.ajax({
                    url: 'contestants/contestant_upload',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response != 0) {
                            alert('Successfully Uploaded');
                            var currentPageIndex = table.page.info().page;
                            table.ajax.reload(function() {
                                table.page(currentPageIndex).draw(false);
                            }, false);

                            $('#upload_modal').modal('hide');
                        } else {
                            alert('file not uploaded');
                        }
                    },
                });
            } else {
                alert("Please select a file.");
            }
        })


        //--------------------------------------------UPDATE ---------------------------------------//
        $('#form_update').on('submit', function(e) {
            e.preventDefault();

            let contestant     = $('#edit_contestant').val();
            let contestant_id  = $('#edit_contestant_id').val();
            let sequence_no    = $('#edit_no').val();
            let active         = $('#edit_active').val();

            $.ajax({
                url: 'contestants/contestant_update',
                type: 'POST',
                data: {
                    contestant    : contestant,
                    contestant_id : contestant_id,
                    sequence_no   : sequence_no,
                    active        : active
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