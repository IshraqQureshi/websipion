"use strict";
$(function () {
    //Payment Gateway Settings
    $('body').on('click', '#LogoSubmit', function () {
        let btn = document.querySelector('#LogoSubmit').textContent;
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
                $("#LogoSubmit").html('Please Wait...');
            },
            function () {
                document.querySelector('#LogoSubmit').textContent = btn;
            }
        );
    });
    //payment gateway settings end



});
