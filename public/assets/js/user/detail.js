$('.radioCls').click(function(){
    $('#colorErr').hide();
});
$('#size').change(function(){
    $('#sizeErr').hide();
});
$(".update-cart").click(function (e) {
    e.preventDefault();
    var action = $('#carthref').val();
    var sizeExist = $('#sizeExist').val();
    if($('input[name="color"]:checked').val()){
        var colorID = $('input[name="color"]:checked').val();         
    }else{
        $('#colorErr').show();
        $('.colorDiv').css('animation','shake 0.8s');
        return false;
    }
    if(sizeExist==1){
        var sizeID = $('#size').val();
        if(!sizeID){
            $('#sizeErr').show();
            $('.sizeDiv').css('animation','shake 0.8s');
            return false;
        }
    }

    $.ajax({
        url: action,
        method: "post",
        data: {
            _token:$('meta[name="csrf-token"]').attr('content'), 
            prodid: $(this).attr("data-prodid"),
            colorID:colorID,
            sizeExist:sizeExist,
            sizeID:sizeID
        },
        success: function (details) {
            $('#stkoutErr').hide();
            if(details.data>0){
                $('.lblCartCount').html(details.data);
                var x = document.getElementById("snackbar");
                // Add the "show" class to DIV
                x.className = "show";                  
                // After 3 seconds, remove the show class from DIV
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                $('#snackbar').html('Item added into cart');
                $('#snackbar').css('background-color','black');
                // alert('Item added into cart');
            }
            else if(details.data==-1) {
                $('#stkoutErr').show();
                $('.stkoutDiv').css('animation','shake 0.8s');
                var x = document.getElementById("snackbar");
                // Add the "show" class to DIV
                x.className = "show";                  
                // After 3 seconds, remove the show class from DIV
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                $('#snackbar').html('Out of stock');
                $('#snackbar').css('background-color','red');
                // alert('out of stock');
                // window.location.href= baseurl+'/userlogin';
            }
            else{
                var x = document.getElementById("snackbar");
                // Add the "show" class to DIV
                x.className = "show";                  
                // After 3 seconds, remove the show class from DIV
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                $('#snackbar').html('Please login to your account');
                $('#snackbar').css('background-color','red');
                // alert('do login with cart adding');
                // window.location.href= baseurl+'/userlogin';
            }
            return false;
        }
    });
});