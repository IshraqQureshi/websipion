"use strict";
$(function () {
    var url = $('#clientsTable').attr('data-URL');
    var dataTable = $('#clientsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        searching: true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'role', name: 'role' },
            { data: 'mobile', name: 'mobile' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', className: 'text-end' },
        ]
    });

    $('#clientsTable_filter').hide();


    $('#clientsSearch').on('keyup', function () {
        dataTable.search(this.value).draw();
    });


    // create client
    $('body').on('click', '#Create', function () {
        let btn = document.querySelector('#Create').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').attr('data-URL');
        CustomAjax(
            urlInsert,
            "POST",
            formData,
            null,
            function (response) {
                if (response.status === 200) {
                    $('#createClient').modal('hide');
                    Swal.fire({
                        text: response.msg,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Okay!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    dataTable.draw();
                    document.getElementById("FromID").reset();
                } else if (response.status === 201) {
                    sAlert('error', response.msg);
                    errorShow(response.errors);
                }else if (response.status === 302) {
                    sAlert('error', response.msg);
                    // errorShow(response.errors);
                }
            },
            function () {
                $("#Create").html('Please Wait...');
            },
            function () {
                document.querySelector('#Create').textContent = btn;
            }
        );
    });

    $('body').on('click', '.createClient', function () {
        formReset();
        $(".modal-title").text('Create');
        $("#update").addClass('d-none');
        $("#Create").removeClass('d-none');
        $('input[name="inlineRadioOptions"][value="2"]').click();
    });

    // EditClient
    $('body').on('click', '.EditClient', function () {
        formReset();
        $("#createClient").modal('show');
        $(".modal-title").text('Edit');

        var id = $(this).attr('data-id');
        var role = $(this).attr('data-role');
        var name = $(this).attr('data-name');
        var email = $(this).attr('data-email');
        var mobile = $(this).attr('data-mobile');

        $('input[name="inlineRadioOptions"]').removeAttr('checked');
        $('input[name="inlineRadioOptions"][value="' + role + '"]').click();

        $('input[name="id"]').val(id);
        $('input[name="name"]').val(name);
        $('input[name="email"]').val(email);
        $('input[name="mobile"]').val(mobile);

        $("#Create").addClass('d-none');
        $("#update").removeClass('d-none');
    });

    $('body').on('click', '#update', function () {
        let btn = document.querySelector('#update').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#clientsTable').attr('data-update-URL');
        CustomAjax(
            urlInsert,
            "POST",
            formData,
            null,
            function (response) {
                if (response.status === 200) {
                    $('#createClient').modal('hide');
                    sAlert('success', response.msg);
                    dataTable.draw();
                    document.getElementById("FromID").reset();
                } else if (response.status === 201) {
                    sAlert('error', response.msg);
                    errorShow(response.errors);
                }
            },
            function () {
                $("#update").html('Please Wait...');
            },
            function () {
                document.querySelector('#update').textContent = btn;
            }
        );
    });

    // Delete record
    $('#clientsTable').on('click', '.client-delete', function () {
        var url = $('#clientsTable').attr("data-Delete-URL");

        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('id', $(this).attr("id"));

        Swal.fire({
            text: "Are you sure delete?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-active-light"
            }
        }).then(function (result) {
            if (result.value) {
                CustomAjax(
                    url,
                    "POST",
                    formData,
                    null,
                    function (response) {
                        sAlert('success', response.msg);
                        dataTable.draw();
                    },
                    function () {

                    },
                    function () {

                    }
                );
            }
        });
    });

    $('#clientsTable').on('click', '.user-status', async function () {
        var url = $('#clientsTable').attr("data-status-URL");
        var status = $(this).text();
        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('id', $(this).attr("name"));
        formData.append('statusValue', status);

        if (status == 'Active') {
            $(this).removeClass('bg-success');
            $(this).addClass('bg-danger');
            $(this).text('Inactive');
        } else {
            $(this).removeClass('bg-danger');
            $(this).addClass('bg-success');
            $(this).text('Active');
        }

        CustomAjax(
            url,
            "POST",
            formData,
            null,
            function (response) {
            },
            function () {

            },
            function () {

            }
        );

    });






});
