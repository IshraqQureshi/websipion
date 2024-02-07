"use strict";
$(function () {
    $("#saveupdate").on("click", function () {
        var formData = new FormData(document.forms.namedItem("FromID"));
        let url = $('#FromID').attr('data-URL');
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === 302){
                    sAlert('error', response.msg)
                }else{


                Swal.fire({
                    text: "Updated successfully!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Okay!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });}

            }
        });
    });

});
