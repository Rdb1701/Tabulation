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
<h5>Users</h5><br>
<button class="btn btn-md btn-rasied btn-success btn-sm " onclick="add_user()"><i class="fa fa-plus"></i> Add User</button><br><br>


<div class="row">
    <div class="col-12 col-md-12 d-flex">
        <div class="card flex-fill border-0">
            <div class="card-body py-4">
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="table-responsive table-wrapper">
                                    <table class="table table-bordered table-hover" id="myTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Role</th>
                                                <th class="text-center">Active</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include "../footer.php";
    include "modal/modal_user.php";
    ?>

    <script>
        function add_user() {
            $('#list_add_modal').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#list_add_modal').modal('show');
        }

        function delete_user(user_id) {
            if (confirm("Are you sure you want to delete user?")) {
                $.ajax({
                    url: 'user/user_delete',
                    type: 'POST',
                    data: {
                        user_id: user_id

                    },
                    dataType: 'JSON',
                    beforeSend: function() {

                    }
                }).done(function(res) {
                    if (res.res_success == 1) {
                        alert('Successfully Deleted');

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

        //edit
        function edit_user(user_id) {

            $.ajax({
                url: 'user/user_edit',
                type: 'POST',
                data: {
                    user_id: user_id
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('#btn_edit').prop("disabled", true);
                }
            }).done(function(res) {

                $("#edit_user_id").val(res.user_id);
                $("#edit_username").val(res.username);
                $("#edit_name").val(res.name);
                $("#edit_roles").val(res.roles);
                $("#edit_active").val(res.active);
                $('#btn_edit').prop("disabled", false);
                $('#list_edit_modal').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                $('#list_edit_modal').modal('show');

            })


        }

        // Initialize DataTable
        var table = $('#myTable').DataTable({
            ajax: 'user/user_view', 
            searching: false,
            paging: false,
            "ordering": false,
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
                }
            ]
        });



        $(document).ready(function() {

            //-------------------------------------------- ADD USER SUMBIT ---------------------------------------//
            $('#form_insert').on('submit', function(e) {
                e.preventDefault();

                let username = $('#add_username').val();
                let name = $('#add_name').val();
                let roles = $('#add_roles').val();
                let active = $('#add_active').val();

                $.ajax({
                    url: 'user/user_add',
                    type: 'POST',
                    data: {
                        username: username,
                        name: name,
                        roles: roles,
                        active: active,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {

                    }
                }).done(function(res) {
                    if (res.res_success == 1) {
                        swal('The password the username', '', 'success');
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


            //-------------------------------------------- ADD USER SUMBIT ---------------------------------------//
            $('#form_update').on('submit', function(e) {
                e.preventDefault();

                let username = $('#edit_username').val();
                let name = $('#edit_name').val();
                let roles = $('#edit_roles').val();
                let active = $('#edit_active').val();
                let user_id = $('#edit_user_id').val();

                $.ajax({
                    url: 'user/user_update',
                    type: 'POST',
                    data: {
                        username: username,
                        name: name,
                        roles: roles,
                        active: active,
                        user_id: user_id
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