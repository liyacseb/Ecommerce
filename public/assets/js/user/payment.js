$(document).ready(function(){
    var orderurl = $('#orderurl').attr('href');
    $.ajaxSetup({
        headers: {
            'X-CSSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept':'application/json'
        }
    });

    var rzpKey = $('#rzpKey').val();
    var razorpayOrder = $('#razorpayOrder').val();
    var grandtotal = $('#grandtotal').val();
    var username = $('#username').val();
    var useremail = $('#useremail').val();
    var paymentstore = $('#razorpayform').attr('data-razorpayurl');
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
                    amount:grandtotal,
                    response:JSON.stringify(response)
                },
                url:paymentstore,
                success:function(data){
                    $('#rzp-button1').attr('disabled',true);
                    if(data.paymentStatus==1){
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
        var paymentfailstore = $('#razorpayform').attr('data-razorpayurl');
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
                    url:paymentfailstore,
                    success:function(data){
                        $('#rzp-button1').attr('disabled',true);                   
                        orderModal(0);
                    }
                });
        });
    }
    $('#rzp-button1').click(function(e){
    // document.getElementById('rzp-button1').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    //}
    });
    
    $('#cod-button').click(function(e){
        e.preventDefault();
        var orderstore = $('#codform').attr('data-codurl');
        $.ajax({
            dataType:'json',
            type:'post',
            data:{
                _token:$('meta[name="csrf-token"]').attr('content'), 
                amount:grandtotal,
            },
            url:orderstore,
            success:function(data){
                if(data.orderID){
                    $('#rzp-button1').attr('disabled',true);
                    orderModal(1);
                }
            }
        });
    });
    $('#wallet-button1').click(function(e){
        e.preventDefault();
        var orderstore = $('#walletform').attr('data-walleturl');
        $.ajax({
            dataType:'json',
            type:'post',
            data:{
                _token:$('meta[name="csrf-token"]').attr('content'), 
                amount:grandtotal,
            },
            url:orderstore,
            success:function(data){
                if(data.orderID){
                    $('#wallet-button1').attr('disabled',true);
                    orderModal(1);
                }
            }
        });
    });

    function orderModal($status){
        var orderurl = $('#orderurl').attr('data-orderurl');
        $('#orderModalBody').empty();
        if($status==1){
            $('#orderModalBody').append('<div class="alert alert-success alert-dismissible fade show" style="height:250px">'+
                '<center> <strong>Success!</strong> '+
                '<p>Your payment has been sent successfully.</p>'+
                '<p><a href="'+orderurl+'" id="orderurl">Go to Order page.</a></p>'+
                '</center>'+
            '</div>');
        }else{
            $('#orderModalBody').append('<div class="alert alert-danger alert-dismissible fade show" style="height:250px">'+
                '<center> <strong>Failure!</strong> '+
                '<p>Your payment has been Failed.</p>'+
                '<p><a href="'+orderurl+'" id="orderurl">Go to Order page.</a></p>'+
                '</center>'+
            '</div>');
        }
        $('#orderModal').show();
        $('#orderModal').attr('backdrop',false);
        $('#orderModal').addClass('modal-backdrop');
        setTimeout(function () {
            window.location.href = orderurl;
        }, 1000);
    }
   // stripe payment gateway
   $('#stripe-button1').click(function(){
        var amount = $('#grandtotal').val();
        var handler = StripeCheckout.configure({
            key: $('#stripeKey').val(), // your publisher key id
            locale: 'auto',
            token: function(token) {
                // You can access the token ID with `token.id`.
                // Get the token ID to your server-side code for use.
                // console.log('Token Created!!');
                // console.log(token);
                $('#stripe-button1').attr('disabled',true);
                $('#res_token').html(JSON.stringify(token));
                $.ajax({
                    url: $('#stripe-button1').attr('data-stripeurl'),
                    method: 'post',
                    data: {
                        _token:$('meta[name="csrf-token"]').attr('content'), 
                        tokenId: token.id,
                        amount: amount,
                        response:JSON.stringify(token)
                    },
                    success:function(data){
                        $('#stripe-button1').attr('disabled',true);
                        if(data.paymentStatus==1){
                            orderModal(1);
                        }
                        else{
                            orderModal(0);
                        }
                    },
                    error: (error) => {
                        console.log(error);
                        alert('Oops! Something went wrong')
                        orderModal(0);
                    }
                })
            }
        });
        handler.open({
            name: 'Webandcrafts ecommerce',
            amount: amount * 100,
            currency: 'INR'
        });
    }); 
});