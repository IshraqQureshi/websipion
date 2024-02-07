"use strict";
const select_init = (Select2emailCC, select2Tags) => {
    if (document.querySelector('.Select2emailCC') && Select2emailCC) {
        $('.Select2emailCC').select2({
            width: 'resolve',
            dropdownParent: $('#createWebsite'),
            tags: true,
            tokenSeparators: [',', ' '],
            language: {
                noResults: function () {
                    return "Add multiple emails with space key";
                }
            }
        });
    }

    if (document.querySelector('.select2Tags') && select2Tags) {
        $('.select2Tags').select2({
            width: 'resolve',
            dropdownParent: $('#createWebsite'),
            tags: true,
            tokenSeparators: [',', ' '],
            language: {
                noResults: function () {
                    return "Add multiple tags with space key";
                }
            }
        });
    }
}
function cc_email_list(url) {
    var formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    CustomAjax(
        url,
        "POST",
        formData,
        null,
        function (response) {
            $('.ShowDataemailCC').html('');
            if ($('.Select2emailCC').data('select2')) {
                $('.Select2emailCC').select2('destroy');
            }
            $('.ShowDataemailCC').html(response);
            select_init(1, 1);
        },
        function () {

        },
        function () {

        }
    );
}

function tag_list(url) {
    var formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    CustomAjax(
        url,
        "POST",
        formData,
        null,
        function (response) {
            $('.select2Tags').html('');
            if ($('.select2Tags').data('select2')) {
                $('.select2Tags').select2('destroy');
            }
            $('.select2Tags').html(response);
            select_init(1, 1);
        },
        function () {
        },
        function () {
        }
    );
}

$(function () {
    var url = $('#WebsiteTable').attr('data-URL');
    var cc_email_list_url = $('#WebsiteTable').attr('data-cc_email_list');
    var tag_lists = $('#WebsiteTable').attr('data-tag-list');
    cc_email_list(cc_email_list_url);
    tag_list(tag_lists);
    var dataTable = $('#WebsiteTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        searching: true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'domainName', name: 'domainName' },
            { data: 'tags', name: 'tags' },
            { data: 'ssl_check', name: 'ssl_check' },
            { data: 'frequency', name: 'frequency' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', className: 'action text-end' },
        ],
        ajax: {
            url: url,
            data: function (data) {
                data.tagSearch = $('#tagSearch').val();
            }
        }
    });

    $('#WebsiteTable_filter').hide();

    $('#WebsiteSearch').on('keyup', function () {
        dataTable.search(this.value).draw();
    });

    $(body).on('change', '#tagSearch', function () {
        // dataTable.ajax.reload(); // Reload the table with the updated data
    });

    $(body).on('mouseover', 'input[name="domainName"]', function () {
        if (!$(this).val()) {
            $(this).val('https://');
        }
    });

    $('body').on('keyup', 'input[name="domainName"]', function () {
        var inputValue = $(this).val();
        $('.SSLCertificate').addClass('d-none');
        if (inputValue.startsWith("http://")) {
            $('.SSLCertificate').addClass('d-none');
        } else if (inputValue.startsWith("https://")) {
            $('.SSLCertificate').removeClass('d-none');
        }
    });

    if (document.querySelector('.select2')) {
        $('.select2').select2(
            {
                width: 'resolve',
                dropdownParent: $('#createWebsite')
            }
        );
    }

    if (document.querySelector('.select2TagSearch')) {
        $('.select2TagSearch').select2(
            {
                placeholder: "Select Tags",
                width: 'resolve',
            }
        );
    }

    // createWebsite pop box
    $(document).ready(function () {
        select_init(1, 1);
    });

    $('body').on('click', '.createWebsite', function () {
        // $('select').val('').change();
        select_init(1, 1)
        formReset();
    });

    $('body').on('click', '#save', function () {
        let btn = document.querySelector('#save').textContent;
        $('#FromID').find('[disabled]').attr('disabled', false).attr('remove-disabled', true);
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').attr('data-URL');
        CustomAjax(
            urlInsert,
            "POST",
            formData,
            null,
            function (response) {
                $('#FromID').find('[remove-disabled]').attr('disabled', true).removeAttr('remove-disabled');
                if (response.status === 200) {
                    $('#createWebsite').modal('hide')
                    Swal.fire({
                        text: response.msg,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Okay!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    formReset();
                    cc_email_list(cc_email_list_url);
                    tag_list(tag_lists);
                    dataTable.draw();
                } else if (response.status === 201) {
		$("#save").attr('disabled',false);
                    sAlert('error', response.msg);
                    errorShow(response.errors);
                }else if (response.status === 302) {
		$("#save").attr('disabled',false);
                    sAlert('error', response.msg);

                }
            },
            function () {
            // $("#save").attr('disabled',true);
                $("#save").html('Please Wait...');
            },
            function () {
                // $("#save").attr('disabled',false);
                document.querySelector('#save').textContent = btn;
            }
        );
    });

    $('body').on('click', '.EditWebsite', function () {

        if (document.querySelector('.select2TagsEdit')) {
            $('.select2TagsEdit').select2(
                {
                    width: 'resolve',
                    dropdownParent: $('#editWebsite'),
                    tags: true,
                    tokenSeparators: [',', ' ']
                }
            );
        }

        if (document.querySelector('.Select2emailCCEdit')) {
            $('.Select2emailCCEdit').select2(
                {
                    width: 'resolve',
                    dropdownParent: $('#editWebsite'),
                    tags: true,
                    tokenSeparators: [',', ' '],
                    language: {
                        noResults: function () {
                            return "Add multiple emails with space key";
                        }
                    }
                }
            );
        }

        var inputValue = $(this).attr('data-domain');
        $('.SSLCertificate').addClass('d-none');
        if (inputValue.startsWith("http://")) {
            $('.SSLCertificate').addClass('d-none');
        } else if (inputValue.startsWith("https://")) {
            $('.SSLCertificate').removeClass('d-none');
        }

        if ($(this).attr('data-ssl_check') == 'on') {
            $('input[name="ssl_check"]').prop('checked', true);
        } else {
            $('input[name="ssl_check"]').prop('checked', false);
        }

        $("#editWebsite").find('input[name=domainName]').val($(this).attr('data-domain'));
        $("#editWebsite").find('input[name=id]').val($(this).attr('data-id'));
        $("#editWebsite").find('input[name=email_cc_recipients]').val($(this).attr('data-email_cc_recipients'));

        var $selectEmailCc = $("#editWebsite").find('.Select2emailCCEdit');

        // Initialize Select2 if not already initialized
        if (!$selectEmailCc.hasClass('select2-hidden-accessible')) {
            $selectEmailCc.select2();
        }

        var dataCc_email = $(this).attr('data-email_cc_recipients');

        var emailAddresses = [];
        // Create a temporary DOM element to parse the HTML string
        var tempElement = document.createElement('div');
        tempElement.innerHTML = $('.ShowDataemailCC').html();

        // Find all <option> elements and extract email addresses
        var optionElements = tempElement.querySelectorAll('option');
        optionElements.forEach(function (option) {
            var email = option.textContent.trim();
            emailAddresses.push(email);
        });

        var uniqueArraycc = emailAddresses.filter(item => !dataCc_email.split(',').includes(item));

        // Clear existing options
        $selectEmailCc.html('');

        // Add new options and set them as selected
        $.each(dataCc_email.split(','), function (index, option) {
            var newOptions = new Option(option, option, true, true);
            $selectEmailCc.append(newOptions);
        });

        // Trigger the change event to notify Select2 about the change

        $.each(uniqueArraycc, function (index, option) {
            var newOptionss = new Option(option, option, false, false);
            $selectEmailCc.append(newOptionss);
        });

        $selectEmailCc.trigger('change');



        // tag code
        var $selectElement = $("#editWebsite").find('.select2TagsEdit');

        // Initialize Select2 if not already initialized
        if (!$selectElement.hasClass('select2-hidden-accessible')) {
            $selectElement.select2();
        }

        var dataTags = $(this).attr('data-tags');

        var alltag = [];
        // Create a temporary DOM element to parse the HTML string
        var tempElement = document.createElement('div');
        tempElement.innerHTML = $('.select2Tags').html();

        // Find all <option> elements and extract email addresses
        var optionElements = tempElement.querySelectorAll('option');
        optionElements.forEach(function (option) {
            var tag = option.textContent.trim();
            alltag.push(tag);
        });

        var uniqueArray = alltag.filter(item => !dataTags.split(',').includes(item));


        // Clear existing options
        $selectElement.html('');

        // Add new options and set them as selected
        $.each(dataTags.split(','), function (index, option) {
            var newOption = new Option(option, option, true, true);
            $selectElement.append(newOption);
        });

        $.each(uniqueArray, function (index, option) {
            var newOptionss = new Option(option, option, false, false);
            $selectElement.append(newOptionss);
        });


        // Trigger the change event to notify Select2 about the change
        $selectElement.trigger('change');

        $('#editWebsite').modal('show');
        return false;
    });

    $('body').on('click', '#update', function () {
        let btn = document.querySelector('#update').textContent;
        var formData = new FormData(document.forms.namedItem("UpdateFromID"));
        var urlInsert = $('#WebsiteTable').attr('data-update-URL');
        CustomAjax(
            urlInsert,
            "POST",
            formData,
            null,
            function (response) {
                if (response.status === 200) {
                    $('#editWebsite').modal('hide');
                    sAlert('success', response.msg);
                    cc_email_list(cc_email_list_url);
                    tag_list(tag_lists);
                    dataTable.draw();
                    document.getElementById("UpdateFromID").reset();
                } else if (response.status === 201) {
                    sAlert('error', response.msg);
                    errorShow(response.errors);
                }else if(response.status ===302){
                    sAlert('error', response.msg);
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

    // delete #Website
    $('#WebsiteTable').on('click', '.client-delete', function () {
        var url = $('#WebsiteTable').attr("data-Delete-URL");

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
                            cc_email_list(cc_email_list_url);
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

    $('#WebsiteTable').on('click', '.website-status', async function () {
        var url = $('#WebsiteTable').attr("data-status-URL");
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

    $('body').on('change', 'select[name=ownerID]', function () {
        let frequency = $('option:selected', this).data('frequency');
        if (frequency) {
            $('select[name=frequency]').val(frequency).change().attr('disabled', true);
        } else {
            $('select[name=frequency]').val('').change().attr('disabled', false);
        }
    })

    $('body').on('click', '.EditClient', function () {
        $('#createWebsite').modal('show');
    });

});


