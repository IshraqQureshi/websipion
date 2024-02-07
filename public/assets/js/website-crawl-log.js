"use strict";
$(function () {
    "use strict";
    hideOverlayLoader();
    var url = $('#CrawlDetailsTable').attr('data-URL');
    var dataTable = $('#CrawlDetailsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        searching: true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'websiteID', name: 'websiteID' },
            { data: 'frequency', name: 'frequency' },
            { data: 'crawlTime', name: 'crawlTime' },
            { data: 'status', name: 'status' },
        ]
    });

    if (document.querySelector('.select2DeleteLog')) {
        $('.select2DeleteLog').select2(
            {
                placeholder: "Schedule Delete",
                width: 'resolve',
            }
        );
    }

    $('#CrawlDetailsTable_filter').hide();

    $('#CrawlDetailsSearch').on('keyup', function () {
        dataTable.search(this.value).draw();
    });

    $('body').on('click', '.crawlManually', function () {
        var url = $('#CrawlDetailsTable').attr('data-crawlManually');
        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        CustomAjax(
            url,
            "POST",
            formData,
            null,
            function (response) {
                dataTable.draw();
                hideOverlayLoader();

            },
            function () {
                showOverlayLoader();

            },
            function () {

            }
        );

    });

    $('body').on('change', '.select2DeleteLog', function () {
        var url = $('#select2DeleteLog').attr('data-url');
        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('delete_type', $(this).val());
        formData.append('id', $('#select2DeleteLog').attr('data-id'));

        CustomAjax(
            url,
            "POST",
            formData,
            null,
            function (response) {
                sAlert('success', response.msg, response.url);
            },
            function () {
            },
            function () {
            }
        );

    });

    // deleteAllLogs

    $('body').on('click', '.deleteAllLogs', function () {
        var url = $('#CrawlDetailsTable').attr('data-deleteAllLogs');
        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        Swal.fire({
            text: "Are you sure delete all?",
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
                        if (response.status === 302) {
                            sAlert('error',response.msg);
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

    $('#select2DeleteLog').select2({
        templateResult: function(option) {
            if (!option.id) {
                return option.text;
            }
            var $image = $('<img>').attr('src', option.element.dataset.image)
                .addClass('select2-option-image')
                .css('height', '20px'); // Adjust the height value as needed
            var $icon = $('<i>').addClass('fa fa-check-circle select2-option-icon');
            var $text = $('<span>').text(option.text);
            return $('<span>').append($image).append($icon).append($text);
        },
        templateSelection: function(option) {
            if (!option.id) {
                return option.text;
            }
            var $image = $('<img>').attr('src', option.element.dataset.image)
                .addClass('select2-option-image')
                .css('height', '20px'); // Adjust the height value as needed
            return $('<span>').append($image).append(option.text);
        }
    });

});

// Loader
function showOverlayLoader() {
    document.getElementById("overlay-loader").style.display = "flex";
}

function hideOverlayLoader() {
    document.getElementById("overlay-loader").style.display = "none";
}
// crawlManually
