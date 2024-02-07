"use strict";
$(function () {


    var url = $('#PackagesTable').attr('data-URL');
    var dataTable = $('#PackagesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        searching: true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'packageName', name: 'packageName' },
            { data: 'crawlFrequency', name: 'crawlFrequency' },
            { data: 'type', name: 'type' },
            { data: 'paymentType', name: 'paymentType' },
            { data: 'price', name: 'price' },
            { data: 'webStatus', name: 'webStatus' },
            { data: 'action', name: 'action', className: 'action text-end' },
        ]
    });

    $('#PackagesTable_filter').hide();

    $('#PackageSearch').on('keyup', function () {
        dataTable.search(this.value).draw();
    });


    if (document.querySelector('.select2')) {
        $('.select2').select2(
            {
                width: 'resolve',
                dropdownParent: $('#createPackages')
            }
        );
    }


    $('#price').hide();
    $('.paymentType').hide();

    $('.typeSubscription').on('click', function () {
        if ($(this).val() == 'Fixed') {
            $("#paymentType").val("");
            $('.paymentType').hide();
            $('#price').show();
            $('#price').removeClass('col-md-6');
            $('#price').addClass('col-md-12');
        } else if ($(this).val() == 'Subscription') {
            $('#price').removeClass('col-md-12');
            $('#price').addClass('col-md-6');
            $('#price').show();
            $('.paymentType').show();
        }
    });


    // save
    $('body').on('click', '#save', function () {
        let btn = document.querySelector('#save').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').attr('data-URL');
        CustomAjax(
            urlInsert,
            "POST",
            formData,
            null,
            function (response) {
                if (response.status === 200) {
                    $('#createPackages').modal('hide')
                    sAlert('success', response.msg);
                    dataTable.draw();
                } else if (response.status === 201) {
                    sAlert('error', response.msg);
                    errorShow(response.errors);
                }else if (response.status === 302) {
                    sAlert('error', response.msg);

                }
            },
            function () {
                $("#save").html('Please Wait...');
            },
            function () {
                document.querySelector('#save').textContent = btn;
            }
        );
    });


    $('#PackagesTable').on('click', '.client-delete', function () {
        var url = $('#PackagesTable').attr("data-Delete-URL");

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
                        if(response.status === 302){
                            sAlert('error', response.msg);
                        }else{
                            sAlert('success', response.msg);

                        }
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



    $('#PackagesTable').on('click', '.package-status', async function () {
        var url = $('#PackagesTable').attr("data-status-URL");
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


    $('body').on('click', '.createPackage', function () {
        formReset();

        if (document.querySelector('.select2')) {
            $('.select2').select2(
                {
                    width: 'resolve',
                    dropdownParent: $('#createPackages')
                }
            );
        }

        $(".modal-title").text('Create Package');
        $('input[name="id"]').val('');
        $("#save").text('Submit');
    });


    // PackageEdit
    $('body').on('click', '.PackageEdit', function () {
        formReset();
        $("#createPackages").modal('show');
        $("#save").text('Update & Save');
        $(".modal-title").text('Edit Package');

        // get data from dataTable
        var id = $(this).attr('data-id');
        var packageName = $(this).attr('data-packageName');
        var crawlFrequency = $(this).attr('data-crawlFrequency');
        var type = $(this).attr('data-type');
        var paymentType = $(this).attr('data-paymentType');
        var price = $(this).attr('data-price');

        $('input[name="id"]').val(id);
        $('input[name="packageName"]').val(packageName);
        $('input[name="price"]').val(price);

        $('#crawlFrequency').val(crawlFrequency).trigger('change');
        $('#paymentType').val(paymentType).trigger('change');

        if (type == 'Fixed') {
            // Set the "checked" attribute for the radio button with the value "Fixed"
            $('input[name="type"][value="Fixed"]').prop('checked', true).trigger('click');

        } else {
            // Set the "checked" attribute for the radio button with the value "Subscription"
            $('input[name="type"][value="Subscription"]').prop('checked', true).trigger('click');
        }
    });
});
