"use strict";

$(function ($) {
    // Close button click event
    $('.modalHide').on('click', function () {
        $("#configuration-modal").modal("hide");
    });

    $('.responderBtn').on('click', function () {
        GetInputValue(this);
    });
});

function GetInputValue(btn) {
    var title = $(btn).data("whatever");
    var key = $(btn).data("key");
    var GetInputsURL = $(btn).data("getinputsurl");
    $('#ModalTitle').text(title);

    var formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('key', key);
    formData.append('title', title);

    CustomAjax(
        GetInputsURL,
        "POST",
        formData,
        null,
        function (response) {
            $("#FromID")[0].reset();
            $('.spinner-border').hide();
            $('.ShowInputs').html(response);
        },
        function () {

        },
        function () {

        }
    );
}


$("#saveConfig").on("click", function () {
    let btn = document.querySelector('#saveConfig').textContent;
    var formData = new FormData(document.forms.namedItem("FromID"));
    var urlInsert = $('#FromID').data('urlinsert');
    CustomAjax(
        urlInsert,
        "POST",
        formData,
        null,
        function (response) {
            if (response.status == 200) {
                Swal.fire({
                    text: response.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Okay!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        location.href = "";
                    }
                });
                document.getElementById("FromID").reset();
                $('#configuration-modal').modal('hide');
            } else {
                Swal.fire({
                    text: response.msg,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Okay!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                })
            }
        },
        function () {
            $("#saveConfig").html('Please Wait...');
        },
        function () {
            document.querySelector('#saveConfig').textContent = btn;
        },
        function (error) {
            // console.log(error.responseJSON);
            errorShow(error.responseJSON.errors);
            // showError(error.responseJSON)
        }

    );
});


$("#defaultSet").on("change", function () {
    var urlInsert = $('#FromIDdefaultSet').data('urlinsert');

    var formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('id', $('#defaultSet').val());

    CustomAjax(
        urlInsert,
        "POST",
        formData,
        null,
        function (response) {
            Swal.fire({
                text: response.msg,
                icon: response.status,
                buttonsStyling: false,
                confirmButtonText: "Set campaign list",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            }).then(function (result) {
                if (result.isConfirmed) {
                    if (response.id != '') {
                        $('#campaignlistModel').modal('show');
                        $('.showResponder').html(response.html);
                        $('#ResponderID').val(response.id);
                    }
                }
            });
        },
        function () {

        },
        function () {

        }
    );
});


// responders-set-campaign-id
$("#RespondersCampaignID").on("click", function () {
    var urlInsert = $('#FromIDCampaign').data('urlinsert');

    var formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('ResponderID', $('#ResponderID').val());
    formData.append('CampaignID', $('#responder_list').val());

    CustomAjax(
        urlInsert,
        "POST",
        formData,
        null,
        function (response) {
            Swal.fire({
                text: 'Saved successfully',
                icon: 'success',
                buttonsStyling: false,
                confirmButtonText: "ok",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            }).then(function (result) {
                if (result.isConfirmed) {
                    location.href = "";
                }
            });
        },
        function () {

        },
        function () {

        }
    );
});
