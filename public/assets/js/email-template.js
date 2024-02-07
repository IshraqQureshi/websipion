"use strict";
$(function () {
    $('body').on('click', '#UpdateSubmit', function () {
        let btn = document.querySelector('#UpdateSubmit').textContent;
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
                $("#UpdateSubmit").html('Please Wait...');
            },
            function () {
                document.querySelector('#UpdateSubmit').textContent = btn;
            },

            function(error){
                errorShow(error.responseJSON.errors);
                // $.each(error.responseJSON.errors, function(key, value){
                //     console.log( value);
                //     sAlert(value[0]);
                // });

            }
        );
    });
});
