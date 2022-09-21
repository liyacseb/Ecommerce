$(document).ready(function() {
    $("#couponform").validate({
        errorPlacement: function (error, element) {
            // console.log('dd', element.attr("name"))
            if (element.attr("name") == "correct_answer") {
                error.appendTo("#radioErr");
            } else {
                error.insertAfter(element)
            }
        },
        rules: {
            coupon_code : {
                required: true,
                minlength: 2
            },
            coupon_amount : {
                required: true,
                digits: true
            },
            coupon_type : {
                required: true
            }
        },
        messages: {
            coupon_code: {
                required: "Please provide coupon code",
                minlength: "Coupon code must be at least 2 characters long"
            },
            coupon_amount: {
                required: "Please provide amount"
            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(form) {
            var coupon_type = $('#coupon_type').val();
            var error=0;
            if(coupon_type=='%'){
                var coupon_amount = parseFloat($('#coupon_amount').val());
                if (isNaN(coupon_amount) || coupon_amount < 0 || coupon_amount > 99) {
                    // value is out of range
                    $('#coupontyperr').html('Please enter valid amount');
                    error=1;
                }
            }
            if(error==0){
                $('#coupontyperr').html('');
                var action = $('#actionurl').attr('data-href');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept':'application/json'
                    }
                });
                $.ajax({
                    dataType:'json',
                    type:'post',
                    data:new FormData($(form)[0]),
                    url:action,
                    processData:false,
                    cache:false,
                    contentType:false,
                    success:function(data){
                        if(data.status==0){
                            Swal.fire({
                                html: data.message,// add html attribute if you want or remove
                                allowOutsideClick: false                        
                            }).then(function() {
                                // window.location = "redirectURL";
                                window.location.href = listurl;
                                
                            });
                            setTimeout(function () {
                            window.location.href = listurl;
                            }, 1000);
                        }else{
                            Swal.fire({
                                html: data.message,// add html attribute if you want or remove
                                allowOutsideClick: false
                            }).then(function() {
                                // window.location = "redirectURL";
                                window.location.href = listurl;
                            
                            });
                            setTimeout(function () {
                                window.location.href = listurl;
                            }, 1000);
                        }
                    },
                    error: function(resp){
                        console.log(resp);
                            let errors=resp.responseJSON.errors;
                                    //  console.log(errors);
                        Object.keys(errors).forEach((item,index)=>{
                            $('input[name='+item+']')
                            .closest('div')
                            .append('<p class="error" style="color: red">'+errors[item][0]+'</p>')
                        });
                    }
                })
            }else{
                return false;
            }
        }
    });
});