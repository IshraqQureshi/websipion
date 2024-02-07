"use strict";

function CustomAjax(url, type, formData, id, successCallback, beforeSendCallback, completeCallback,errorCallback) {
    var ajaxSettings = {
        url: url,
        type: type,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            if (typeof beforeSendCallback === "function") {
                beforeSendCallback();
            }
        },
        success: function (response) {
            if (successCallback && typeof successCallback === "function") {
                successCallback(response);
            }
        },
        error:function(error) {
            if (typeof errorCallback === "function") {
                errorCallback(error);
            }
        },
        complete: function () {
            if (typeof completeCallback === "function") {
                completeCallback();
            }
        }

    };

    if (type === "GET") {
        if (id) {
            ajaxSettings.url += "/" + id;
        }
    } else if (type === "POST") {
        ajaxSettings.data = formData;
    } else if (type === "DELETE") {
        ajaxSettings.url += "/" + id;
    }

    $.ajax(ajaxSettings);
}

function errorShow(response) {
    $('.error-text').text('');
    $('.form-control').removeClass('is-invalid is-valid');
    $('.invalid-feedback').text('');

    $.each(response, function (key, value) {
        $('.' + key + '_error').text(value[0]);
        $('input[name="' + key + '"]').addClass('is-invalid');
        $('select[name="' + key + '"]').addClass('is-invalid');
        $('radio[name="' + key + '"]').addClass('is-invalid');
        $('.' + key + '_error').addClass('invalid-feedback');
    });
}

$('.form-control').on('keyup', function () {
    $(this).removeClass('is-invalid');
    $(this).siblings('.error-text').text('');
});

function formReset() {
    $('#FromID')[0].reset();
    $('.form-control').removeClass('is-invalid');
    $('.form-control').siblings('.error-text').text('');
}


function sAlert(icon, title, url = '') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    if (url != "") {
        Toast.fire({
            icon: icon,
            title: title,
        }).then((Toast) => {
            if (Toast) {
                window.location.href = url;
            }
        });
    } else {
        Toast.fire({
            icon: icon,
            title: title,
        })
    }
}

// form-switch
$(function () {
    var theme = $("html").attr("data-bs-theme");
    var logo_light = $("body").attr("data-logo");
    var logo_dark = $("body").attr("data-dark-logo");
    if(theme == 'dark'){
        $(".login-logo").attr("src", logo_dark);
    }else{
        $(".login-logo").attr("src", logo_light);
    }
    $('#DarkLightLogo').on('click', function () {
        logoUpdateDark();
    });
});


function logoUpdateDark() {
    var theme = $("html").attr("data-bs-theme");
    var logo_light = $("body").attr("data-logo");
    var logo_dark = $("body").attr("data-dark-logo");
    $(".login-logo").attr("src", "");
    if (theme == 'dark') {
        $(".login-logo").attr("src", logo_light);
    } else {
        $(".login-logo").attr("src", logo_dark);
    }
}


document.addEventListener(
    "DOMContentLoaded",
    function() {
        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    },
    false
);


$(function ($) {
    "use strict";
    $("#crawlDomainFormHeader").on("click", function () {
        var _token = $('meta[name="csrf-token"]').attr('content');
        var crawlDomainUrl = $("#crawlDomainUrl").val();
        if (validURL(crawlDomainUrl) == false) {
            Swal.fire({
                text: 'Enter a valid domain!',
                icon: "info",
                buttonsStyling: false,
                confirmButtonText: "Okay!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        } else {
            var regex = /^(http|https)/;
            if (regex.test(String(crawlDomainUrl).toLowerCase()) == true) {
                $.ajax({
                    type: "POST",
                    url: BaseUrl + "/crawl-domain",
                    data: { crawlDomainUrl: crawlDomainUrl, _token: _token },
                    beforeSend: function () {
                        $("#crawlDomainFormHeader").html('Wait...');

                    },
                    success: function (response) {
                        document.querySelector('#crawlDomainFormHeader').textContent = 'Check';
                        if (response.statusCode == 200) {
                            Swal.fire({
                                text: 'Website is ' + response.status,
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Okay!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        } else if (response.statusCode == 201) {
                            Swal.fire({
                                text: 'Website is ' + response.status,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Okay!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    }
                });
            } else {
                Swal.fire({
                    text: 'The website address is not valid ' + crawlDomainUrl,
                    icon: "info",
                    buttonsStyling: false,
                    confirmButtonText: "Okay!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        }
    });


    function validURL(str) {
        var pattern = new RegExp(
            '^(http?:\\/\\/)?' + // protocol
            '^(https?:\\/\\/)?' + // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
            '(\\#[-a-z\\d_]*)?$', 'i'
        ); // fragment locator
        return !!pattern.test(str);
    }

});
