"use strict";
$(function () {

    $("#LogoSubmit").on("click", function () {
        let btn = document.querySelector('#LogoSubmit').textContent;
        var formData = new FormData(document.forms.namedItem("FormID"));
        var urlInsert = $('#FormID').attr('data-URl');
        // POST data with id and formData
        CustomAjax(
            urlInsert,
            "POST",
            formData,
            null,
            function (response) {
                if (response.status === 200) {
                    sAlert('success', response.msg, response.url);
                    document.getElementById("FromID").reset();
                } else if (response.status === 201) {
                    sAlert('error', response.msg);
                    errorShow(response.errors);
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


});
