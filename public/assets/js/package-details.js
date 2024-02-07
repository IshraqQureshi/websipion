"use strict";
$(function () {
    // on select set color
    $(".pricing").click(function () {
        $(".pricing").css("background-color", "#fff").css("color", "#60707F");
        $(this).css("background-color", "#4361BB").css("color", "#fff");
    });

    $("#PayMethod").attr("disabled", "disabled");

    $('body').on('click', '.packageSelected', function () {
        console.log('Package Selected');
        var packageID = $(this).attr('data-packageID');
        var price = $(this).attr('data-price');
        var type = $(this).attr('data-type');
        var packageName = $(this).attr('data-packageName');
        var paymentType = $(this).attr('data-paymentType');
        // set payment amt
        $('.totalPrice').text(price);
        $('#priceShow').val(price);
        $('#packageID').val(packageID);
        $('#packageName').val(packageName);
        $('#paymentType').val(paymentType);
        $('#type').val(type);
        $('.priceInput').val(1);
        $("#PayMethod").removeAttr("disabled");
        $('.packagesMsg').text('');
    });



    $('.minus').on("click", function () {
        if ($("#priceShow").val() == '') {
            $('.packagesMsg').text('Please select package');
            return false;
        }
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        if ($input.val() != '1') {
            count = count < 1 ? 1 : count;
            var originalPrice = $("#priceShow").val();
            var price = $('.totalPrice').text();
            $input.val(count);
            document.querySelector('.totalPrice').textContent = (price - originalPrice);
            $input.change();
            return false;
        }
    });

    $('.plus').on("click", function () {
        if ($("#priceShow").val() == '') {
            $('.packagesMsg').text('Please select package');
            return false;
        }
        var $input = $(this).parent().find('input');
        if ($input.val() != '15') {
            var originalPrice = $("#priceShow").val();
            $input.val(parseInt($input.val()) + 1);
            document.querySelector('.totalPrice').textContent = originalPrice * $input.val();
        }
    });


    $('.priceInput').on('keyup', function () {
        var inputValue = $(this).val();
        $('.totalPrice').val($("#priceShow").val());
        if (inputValue === '' || inputValue == 0) {
            $(this).val('1');
        }
        priceCalculation(inputValue, $("#priceShow").val());
    });

});


// PayMethod js
$('body').on('click', '#PayMethod', function () {
    let packageID = $('#packageID').val();
    let type = $('#type').val();
    let priceShow = $('#priceShow').val();
    let totalPrice = $('.totalPrice').text();
    let websiteTotal = $('.priceInput').val();

    // set pop data
    $('.showpriceinlinePrice').text(totalPrice);

    $('.method-pay').removeClass('Subscription');
    $('.method-pay').removeClass('OneTime');
    $('.method-pay').addClass(type);

    $('.method-pay').attr('data-packageID-pay', packageID);
    $('.method-pay').attr('data-priceShow-pay', priceShow);
    $('.method-pay').attr('data-totalPrice-pay', totalPrice);
    $('.method-pay').attr('data-websiteTotal-pay', websiteTotal);
});



function priceCalculation(qty, price) {
    if(qty == '' || qty == 0){
    }
    if (qty == '' && price == '') {
        $('.packagesMsg').text('Please select package');
        return false;
    }
    var totalPrice = price * qty;
    if(totalPrice === 0 || totalPrice == ''){
       var totalPrice = $("#priceShow").val();
    }
    document.querySelector('.totalPrice').textContent = totalPrice;
}