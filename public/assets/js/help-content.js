"use strict";
$(function () {
    $('body').on('click', '#HelpSubmit', function () {
        let btn = document.querySelector('#HelpSubmit').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').attr('data-URL');
        CustomAjax(
            urlInsert,
            "POST",
            formData,
            null,
            function (response) {
                if (response.status === 200) {
                    Swal.fire({
                        text: response.msg,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Okay!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                } else if (response.status === 201) {
                    sAlert('error', response.msg);
                }else if (response.status === 302) {
                    sAlert('error', response.msg);
                }
            },
            function () {
                $("#HelpSubmit").html('Please Wait...');
            },
            function () {
                document.querySelector('#HelpSubmit').textContent = btn;
            }
        );
    });
});
