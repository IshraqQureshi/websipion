"use strict";

$(function () {
    $("#login").on("click", function () {
        var btn = document.querySelector('#login').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').data('urlinsert');
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
                }
            },
            function () {
                $("#login").html('Please Wait...');
            },
            function () {
                document.querySelector('#login').textContent = btn;
            }
        );
    });

    $("#register").on("click", function () {
        let btn = document.querySelector('#register').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').data('urlinsert');
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
                }
            },
            function () {
                $("#register").html('Please Wait...');
            },
            function () {
                document.querySelector('#register').textContent = btn;
            }
        );
    });



    $("#show-password").on("click", function () {
        if ($(this).is(':checked')) {
            $('#password').attr('type', 'text');
            $('#passmsg').text('Show password');
        } else {
            $('#password').attr('type', 'password');
            $('#passmsg').text('Hide password');
        }
    });



    $("#ForgotPassword").on("click", function () {
        let btn = document.querySelector('#ForgotPassword').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').data('urlinsert');
        // POST data with id and formData
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
                $("#ForgotPassword").html('Please Wait...');
            },
            function () {
                document.querySelector('#ForgotPassword').textContent = btn;
            }
        );
    });

    $("#UpdatePassword").on("click", function () {
        let btn = document.querySelector('#UpdatePassword').textContent;
        var formData = new FormData(document.forms.namedItem("FromID"));
        var urlInsert = $('#FromID').data('urlinsert');
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
                    errorShow(response.errors);
                }
            },
            function () {
                $("#UpdatePassword").html('Please Wait...');
            },
            function () {
                document.querySelector('#UpdatePassword').textContent = btn;
            }
        );
    });




});