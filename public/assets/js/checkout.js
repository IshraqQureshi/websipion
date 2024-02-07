"use strict";
$(function () {
    // razorpay Normal
    $('body').on('click', '.razorpay.OneTime', function (e) {
        let packageID = $(this).attr('data-packageID-pay');
        let priceShow = $(this).attr('data-priceShow-pay');
        let totalPrice = $(this).attr('data-totalPrice-pay');
        let websiteTotal = $(this).attr('data-websiteTotal-pay');
        let url = $(this).attr('data-url');

        let rzpKEY = $('#rzpKEY').val();
        let APP_NAME = $('#APP_NAME').val();
        let logo = $('#logo').val();
        let email = $('#email').val();
        let mobile = $('#mobile').val();
        var options = {
            "key": rzpKEY,
            "amount": (totalPrice * 100), // 2000 paise = INR 20
            "currency": "USD",
            "name": APP_NAME,
            "description": "Payment on website",
            "image": logo,
            "handler": function (response) {
                var razorpay_payment_id = response.razorpay_payment_id
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        type: 'razorpay',
                        websiteTotal: websiteTotal,
                        packageID: packageID,
                        priceShow: priceShow,
                        totalPrice: totalPrice,
                        payment_id: razorpay_payment_id,
                    },

                    success: function (res) {
                        Swal.fire({
                            text: res.msg,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Okay!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                location.href = res.url;
                            }
                        });
                    }
                });
            },
            "prefill": {
                "contact": mobile,
                "email": email,
            },
            "theme": {
                "color": "#006FD6"
            }
        };

        var rzp1 = new Razorpay(options);
        rzp1.open();
        e.preventDefault();
        $("#pay .close").click();
    });

    $('body').on('click', '.razorpay.Subscription', function (e) {
        let packageID = $(this).attr('data-packageID-pay');
        let priceShow = $(this).attr('data-priceShow-pay');
        let totalPrice = $(this).attr('data-totalPrice-pay');
        let websiteTotal = $(this).attr('data-websiteTotal-pay');
        let url = $(this).attr('data-url');

        let rzpKEY = $('#rzpKEY').val();
        let APP_NAME = $('#APP_NAME').val();
        let logo = $('#logo').val();
        let userName = $('#userName').val();
        let email = $('#email').val();
        let mobile = $('#mobile').val();


        var formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            packageID: packageID,
            packageName: $('#packageName').val(),
            paymentType: $('#paymentType').val(),
            websiteTotal: websiteTotal,
            price: totalPrice,
            type: 'subscription',
            priceShow: priceShow,
            rzpKEY: rzpKEY,
            APP_NAME: APP_NAME,
            logo: logo,
            userName: userName,
            email: email,
            mobile: mobile,
            url: url,
        };

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            beforeSend: function () {
                $('.razorpay.Subscription').html('Please Wait...');
            },
            success: function (response) {
                $("#pay").modal('hide');
                delete formData.type;
                RazorpaySubscription(formData, response);
            }
        });
    });

    // paypal and stripe payment on normal
    $('body').on('click', '.stripepay.OneTime', function (e) {
        let url = $(this).attr('data-url');

        var formData = new FormData();

        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('packageID', $(this).attr('data-packageID-pay'));
        formData.append('websiteTotal', $(this).attr('data-websiteTotal-pay'));
        formData.append('price', $(this).attr('data-totalPrice-pay'));

        StripeNormal(formData, url);
    });


    $('body').on('click', '.stripepay.Subscription', function (e) {
        let url = $(this).attr('data-url');
        let packageID = $(this).attr('data-packageID-pay');
        let totalPrice = $(this).attr('data-totalPrice-pay');
        let websiteTotal = $(this).attr('data-websiteTotal-pay');
        let packageName = $('#packageName').val();
        let userName = $('#userName').val();
        let email = $('#email').val();

        var formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('packageID', packageID);
        formData.append('websiteTotal', websiteTotal);
        formData.append('price', totalPrice);
        formData.append('email', email);
        formData.append('userName', userName);
        formData.append('packageName', packageName);
        formData.append('type', 'subscription');
        StripeSubscription(formData, url);
    });

    $('body').on('click', '.paypal.OneTime', function (e) {
        let url = $(this).attr('data-url');

        var formData = new FormData();

        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('packageID', $(this).attr('data-packageID-pay'));
        formData.append('websiteTotal', $(this).attr('data-websiteTotal-pay'));
        formData.append('price', $(this).attr('data-totalPrice-pay'));

        PayPalNormal(formData, url);
    });

    $('body').on('click', '.paypal.Subscription', function (e) {
        let url = $(this).attr('data-url');

        var formData = new FormData();

        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('packageID', $(this).attr('data-packageID-pay'));
        formData.append('websiteTotal', $(this).attr('data-websiteTotal-pay'));
        formData.append('price', $(this).attr('data-totalPrice-pay'));

        CustomAjax(
            url,
            "POST",
            formData,
            null,
            function (response) {
                window.location = response.url;
            },
            function () {
                $('.paypal.Subscription').html('Please Wait...');
            },
            function () {
                document.querySelector('.paypal.Subscription').textContent = 'Pay Now';
            }
        );

    });

});

function StripeNormal(formData, url) {
    CustomAjax(
        url,
        "POST",
        formData,
        null,
        function (response) {
            window.location = response.url;
        },
        function () {
            $('.stripepay.OneTime').html('Please Wait...');
        },
        function () {
            document.querySelector('.stripepay.OneTime').textContent = 'Pay Now';
        }
    );

}

function PayPalNormal(formData, url) {
    CustomAjax(
        url,
        "POST",
        formData,
        null,
        function (response) {
            window.location = response.url;
        },
        function () {
            $('.paypal.OneTime').html('Please Wait...');
        },
        function () {
            document.querySelector('.paypal.OneTime').textContent = 'Pay Now';
        }
    );
}

//Subscription Payment Method

function RazorpaySubscription(Data, response) {
    var options = {
        "key": response.Razorpay_key,
        "subscription_id": response.subscription_id,
        "name": Data.APP_NAME,
        "description": response.description,
        "image": Data.logo,
        "handler": function (res) {
            var formData = new FormData();
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('websiteTotal', Data.websiteTotal);
            formData.append('packageID', Data.packageID);
            formData.append('totalPrice', Data.price);
            formData.append('payment_id', res.razorpay_payment_id);
            formData.append('subscription_id', response.subscription_id);
            RazorpaySubscriptionSave(formData, response.url);
        },
        "prefill": {
            "name": Data.userName,
            "email": Data.email,
            "contact": Data.mobile
        },
        "notes": {
            "note_key_1": response.description,
        },
        "theme": {
            "color": "#006FD6"
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
}

function RazorpaySubscriptionSave(formData, url) {
    CustomAjax(
        url,
        "POST",
        formData,
        null,
        function (response) {
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
                    location.href = response.url;
                }
            });
        },
        function () {
        },
        function () {
        }
    );
}

function StripeSubscription(formData, url){
    CustomAjax(
        url,
        "POST",
        formData,
        null,
        function (response) {
            window.location = response.url;
        },
        function () {
            $('.stripepay.Subscription').html('Please Wait...');
        },
        function () {
            document.querySelector('.stripepay.Subscription').textContent = 'Pay Now';
        }
    );

}
