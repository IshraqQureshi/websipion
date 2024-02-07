"use strict";
$(function () {
    var url = $('#TagsTable').attr('data-URL');
    var dataTable = $('#TagsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        searching: true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'action', name: 'action', className: 'text-end' },
        ]
    });

    $('#TagsTable_filter').hide();


    $('#TagsSearch').on('keyup', function () {
        dataTable.search(this.value).draw();
    });

    // create tag

    $('body').on('click', '.createTags', function () {
        formReset();
        $(".modal-title").text('Create');
        $("#update").addClass('d-none');
        $("#Create").removeClass('d-none');
        $('input[name="id"]').val('');
    });

    // create tag
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
                    $('#createTags').modal('hide');
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
                    errorShow(response.errors);
                }else if (response.status === 302) {
                    sAlert('error', response.msg)
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

    // EditTags
    $('body').on('click', '.EditTags', function () {
        formReset();
        $("#createTags").modal('show');
        $(".modal-title").text('Edit');

        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');

        $('input[name="id"]').val(id);
        $('input[name="name"]').val(name);

        $("#Create").addClass('d-none');
        $("#update").removeClass('d-none');
    });

    $('body').on('click', '#update', function () {
        let btn = document.querySelector('#update').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').attr('data-URL');
        CustomAjax(
            urlInsert,
            "POST",
            formData,
            null,
            function (response) {
                if (response.status === 200) {
                    $('#createTags').modal('hide');
                    sAlert('success', response.msg);
                    dataTable.draw();
                    document.getElementById("FromID").reset();
                } else if (response.status === 201) {
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
    $('#TagsTable').on('click', '.tag-delete', function () {
        var url = $('#TagsTable').attr("data-Delete-URL");

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


});
