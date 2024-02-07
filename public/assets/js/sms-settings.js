"use strict";
$(function ($) {
    $("#Razorpayupdate").on("click", function () {
        var formData = new FormData(document.forms.namedItem("FromID"));
        let url = $(this).attr('data-url');
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                errorShow(response.errors);
                if (response.status === 302){
                    sAlert('error', response.msg);
                }else{


                Swal.fire({
                    text: "SMS settings has been Updated successfully!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Okay!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        location.href = BaseUrl + "/dashboard/sms-setting";
                    }
                });}
            },
            error: function(error){
                // console.log(error.responseJSON);
                errorShow(error.responseJSON.errors);
            }
        });
    });

});
