$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept':'application/json'
        }
    });

    $('#addwalletbtn').click(function(e){
        e.preventDefault();
        var wallet=$('#wallet').val();
        if(wallet.length==0){
            $('#walletErr').html('Please enter amount');
        }else{
            $('#walletErr').html('');
            var orderaction = $('#addwalletform').attr('data-orderaction');
            var paymentaction = $('#addwalletform').attr('data-paymentaction');
            $.ajax({
                dataType:'json',
                type:'post',
                data:new FormData($('#addwalletform')[0]),
                processData:false,
                cache:false,
                contentType:false,
                url:orderaction,
                success:function(rzp_order_id){
                    console.log(rzp_order_id);

                    var rzpKey = $('#rzpKey').val();
                    var razorpayOrder = rzp_order_id;
                    var grandtotal = $('#wallet').val();
                    var username = $('#name').val();
                    var useremail = $('#email').val();
                   
                    var options = {
                        "key": rzpKey, // Enter the Key ID generated from the Dashboard
                        "amount": grandtotal, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                        "currency": "INR",
                        "name": username,
                        "description": "Transaction",
                        "image": "https://webandcrafts.com/images/webandcrafts-logo.svg",
                        "order_id": razorpayOrder, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                        "handler": function (response){
                            // alert(response.razorpay_payment_id);
                            // alert(response.razorpay_order_id);
                            // alert(response.razorpay_signature);
                            // alert(JSON.stringify(response));
                            $.ajax({
                                dataType:'json',
                                type:'post',
                                data:{
                                    _token:$('meta[name="csrf-token"]').attr('content'), 
                                    razorpay_order_id:response.razorpay_order_id,
                                    razorpay_payment_id:response.razorpay_payment_id,
                                    razorpay_signature:response.razorpay_signature,
                                    amount:$('#wallet').val(),
                                    response:JSON.stringify(response)
                                },
                                url:paymentaction,
                                success:function(data){
                                    console.log(data.status);
                                    $('#rzp-button1').attr('disabled',true);
                                    if(data.status==1){
                                        orderModal(1);
                                    }
                                    else{
                                        orderModal(0);
                                    }
                                }
                            });
                        },
                        "prefill": {
                            "name": username,
                            "email": useremail,
                            "contact": ""
                        },
                        "notes": {
                            "address": "Razorpay Corporate Office"
                        },
                        "theme": {
                            "color": "#4fbfa8"
                        }
                    };
                    // console.log(options.key);
                    if(options.key){
                        var rzp1 = new Razorpay(options);
                        var grandtotal = $('#grandtotal').val();
                        var paymentfailurl = $('#addwalletform').attr('data-paymentfailedaction');
                        rzp1.on('payment.failed', function (response){
                                // alert(response.error.code);
                                // alert(response.error.description);
                                // alert(response.error.source);
                                // alert(response.error.step);
                                // alert(response.error.reason);
                                // alert(response.error.metadata.order_id);
                                // alert(response.error.metadata.payment_id);
                                $.ajax({
                                    dataType:'json',
                                    type:'post',
                                    data:{
                                        _token:$('meta[name="csrf-token"]').attr('content'), 
                                        amount:grandtotal,
                                        response:JSON.stringify(response)
                                    },
                                    url:paymentfailurl,
                                    success:function(data){
                                        $('#rzp-button1').attr('disabled',true);                   
                                        orderModal(0);
                                    }
                                });
                        });
                    }
                    rzp1.open();
                }
            });
        }
    });
    function orderModal(status){
        var orderurl = $('#orderurl').attr('data-orderurl');
        var x = document.getElementById("snackbar");
        // Add the "show" class to DIV
        x.className = "show";                  
        // After 3 seconds, remove the show class from DIV
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
       if(status==1){
           $('#snackbar').html("Payment success");
           $('#snackbar').css('background-color','green');
       }else{
           $('#snackbar').html("Payment failed");
           $('#snackbar').css('background-color','red');
           
       }
        setTimeout(function () {
            location.reload();
        }, 1000);
    }
    $("#profileForm").validate({
        errorPlacement: function (error, element) {
            // console.log('dd', element.attr("name"))
            if (element.attr("name") == "correct_answer") {
                error.appendTo("#radioErr");
            } else {
                error.insertAfter(element)
            }
        },
        rules: {
            name : {
                required: true,
                minlength: 2
            },
            email : {
                required: true,
                email: true
            },
            mob: {
                digits:10
            }
        },
        // messages: {
        //     name: {
        //         required: "Please provide name",
        //         minlength: "Name must be at least 2 characters long"
        //     },
        //     email: {
        //         required: "Please provide email"
        //     }
        // },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(form) {
            var action = $('#actionurl').attr('data-href');
            $.ajaxSetup({
                headers: {
                    'X-CSSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
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
                success:function(detail){
                    if(detail.data==0){
                        $('.divDanger').show();
                        setTimeout(function () {
                            // $('.divDanger').hide();
                            location.reload();
                        }, 1000); 
                    }else{
                        $('.divSuccess').show();  
                        setTimeout(function () {
                            location.reload();
                            // $('.divSuccess').hide(); 
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
        }
    });
});