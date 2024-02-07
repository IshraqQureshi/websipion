"use strict";
$(function () {
    if (document.querySelector('.select2')) {
        $('.select2').select2(
            {
                width: 'resolve',
            }
        );
    }

    $('body').on('click', '#UpdateProfile', function () {
        let btn = document.querySelector('#UpdateProfile').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').attr('data-URL');
        CustomAjax(
            urlInsert,
            "POST",
            formData,
            null,
            function (response) {
                if (response.status === 200) {
                    sAlert('success', response.msg, response.url);
                } else if (response.status === 201) {
                    errorShow(response.errors);
                }
            },
            function () {
                $("#UpdateProfile").html('Please Wait...');
            },
            function () {
                document.querySelector('#UpdateProfile').textContent = btn;
            }
        );
    });


});