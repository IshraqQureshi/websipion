$('#UpdateSubmit').click(function(e){

    e.preventDefault();
    let formdata = $('#FromID').serialize();
    let url = $('#url').val();

    $.ajax({
        url: url,
        type: 'POST',
        data:formdata,
        success: function(response) {
            if(response.status == 'success'){
                sAlert('success',response.message);
                console.log(response);
            }else if(response.status == 302){
                // window.location.reload();
                sAlert('error',response.msg);
            }
        },
        error:function(jqXHR, textStatus, errorThrown) {

        }
    });
});