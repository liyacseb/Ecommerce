$(document).ready(function(){
    $('.removeCart').click(function(){
        var action = $(this).attr('data-href');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: false,
            closeOnCancel: true 
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: action,
                    method: "get",
                    success: function (details) {
                        if(details.data){
                            swal("Deleted!",  "success");
                            location.reload();
                        }
                    }
                });
                
            } else {
                //swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });
    });
    
    $("#couponForm").validate({
        errorPlacement: function (error, element) {
            // console.log('dd', element.attr("name"))
            if (element.attr("name") == "coupon") {
                error.appendTo("#couponErr");
            } else {
                error.insertAfter(element)
            }
        },
        rules: {
            coupon : {
                required: true
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
            var action = $('#couponForm').attr('data-href');
            var coupon = $('#coupon').val();
            $.ajaxSetup({
                headers: {
                    'X-CSSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept':'application/json'
                }
            });
            $.ajax({
                dataType:'json',
                type:'get',
                data:{coupon:coupon},
                url:action,
                // processData:false,
                // cache:false,
                // contentType:false,
                success:function(detail){
                    console.log(detail);
                    var total=$('#grandtotalHid').val();
                    $('#couponAmount').val('0');
                    $('#couponType').val('%');
                    $('#couponIdHid').val(0);
                    $('#grandtotal_th').html("₹"+total);
                    $('#coupon_th').html('- ₹0.00');
                    $('#couponHid').val('0');
                    
                    var x = document.getElementById("snackbar");
                    // Add the "show" class to DIV
                    x.className = "show";                  
                    // After 3 seconds, remove the show class from DIV
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);

                    if(detail.id>0){
                        // coupon applied
                        // console.log(detail.coupon_type);
                        // console.log(detail.coupon_amount);
                        $('#couponIdHid').val(detail.id);
                        $('#couponAmount').val(detail.coupon_amount);
                        $('#couponType').val(detail.coupon_type);
                        
                        if(detail.coupon_type=='₹'){
                            if(detail.coupon_amount<total){
                                $('#couponapplied').html(detail.coupon_type+detail.coupon_amount+' applied');
                               
                                $('#snackbar').html(detail.coupon_type+detail.coupon_amount+' applied');
                                $('#snackbar').css('background-color','green');
                                // alert(detail.coupon_type+detail.coupon_amount+' applied');

                                console.log(parseFloat(total));
                                var amount = parseFloat(total)-parseFloat(detail.coupon_amount);
                                $('#coupon_th').html('- ₹'+detail.coupon_amount.toFixed(2));
                                $('#couponHid').val(detail.coupon_amount.toFixed(2));
                                $('#grandtotal_th').html('₹'+amount.toFixed(2));
                            }else{
                                $('#snackbar').html("can't apply coupon.You need to purchase more than ₹"+detail.coupon_amount.toFixed(2));
                                $('#snackbar').css('background-color','red');
                                // alert("can't apply coupon");
                            }
                        }else{
                            $('#couponapplied').html(detail.coupon_amount+detail.coupon_type+' applied');

                            
                            $('#snackbar').html(detail.coupon_amount+detail.coupon_type+' applied');
                            $('#snackbar').css('background-color','green');
                            // alert(detail.coupon_amount+detail.coupon_type+' applied');

                            var dis_amnt1 =detail.coupon_amount/100;
                            var dis_amnt2 =  parseFloat(total)*parseFloat(dis_amnt1);
                            var dis_amnt3 = dis_amnt2.toFixed(2);
                            // console.log(dis_amnt3);
                            var amount = parseFloat(total)-parseFloat(dis_amnt3);
                            $('#coupon_th').html('- ₹'+dis_amnt3);
                            $('#couponHid').val(dis_amnt3);
                            $('#grandtotal_th').html('₹'+amount.toFixed(2));
                        }
                    }else if(detail.id==0){
                       //already used
                        
                        $('#snackbar').html('coupon already used');
                        $('#snackbar').css('background-color','red');
                    //    alert('coupon already used');
                    }else{
                        //doesn't exist
                       
                       $('#snackbar').html("coupon doesn't exist");
                       $('#snackbar').css('background-color','red');
                        // alert("coupon doesn't exist");
                    }
                },
                error: function(resp){
                    console.log(resp);
                    //     let errors=resp.responseJSON.errors;
                    //             //  console.log(errors);
                    // Object.keys(errors).forEach((item,index)=>{
                    //     $('input[name='+item+']')
                    //     .closest('div')
                    //     .append('<p class="error" style="color: red">'+errors[item][0]+'</p>')
                    // });
                }
            })
        }
    });

    $('.prodCount').keypress(function(event){

        if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
            event.preventDefault(); //stop character from entering input
        }
       
    });
   
    $('.prodCount').keyup(function(event){
        if($(this).val()==0){
            $(this).val(1);
        }
        // var cartID = $(this).attr('data-cartID');
        // var perPrice = $(this).attr('data-perPrice');
        // var count = $(this).val();
        // calculateTotal(count,cartID,perPrice);
    });
    $('.prodCount').change(function(event){
        var cartID = $(this).attr('data-cartID');
        var perPrice = $(this).attr('data-perPrice');
        var count = $(this).val();
        calculateTotal(count,cartID,perPrice);
    });
    function calculateTotal(count,cartID,perPrice){
        
        // console.log(count);
        // console.log(cartID);
        // console.log(perPrice);
        $('#total_'+cartID).html('₹'+count*perPrice);
        $.ajax({
            url: baseurl+'/updateCartCount',
            method: "post",
            data: {
                _token:$('meta[name="csrf-token"]').attr('content'), 
                cartID:cartID,
                count:count
            },
            success: function (details) {
                if(details.data==-1){
                     var x = document.getElementById("snackbar");
                    // Add the "show" class to DIV
                    x.className = "show";                  
                    // After 3 seconds, remove the show class from DIV
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                    $('#snackbar').html('out of stock ');
                    $('#snackbar').css('background-color','red');
                    // alert('out of stock ');
                }
                if(details.data==-2){
                    $('#number_'+cartID).val(details.stock);
                     var x = document.getElementById("snackbar");
                    // Add the "show" class to DIV
                    x.className = "show";                  
                    // After 3 seconds, remove the show class from DIV
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                    $('#snackbar').html('we are sorry there is only limited product stock');
                    $('#snackbar').css('background-color','red');
                    // alert('we are sorry there is only limited product stock');
                }else{
                    var x = document.getElementById("snackbar");
                    // Add the "show" class to DIV
                    x.className = "show";                  
                    // After 3 seconds, remove the show class from DIV
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                    $('#snackbar').html('succesfully added to cart');
                    $('#snackbar').css('background-color','black');
                    // alert('succesfully added to cart');

                    var total=0;
                    var offerprice_total=0;
                    $(".prodCount").each(function() {
                        var stock = $(this).attr('data-stock');
                        if(stock>0){
                            var price = $(this).attr('data-perPrice');
                            var offerPrice = $(this).attr('data-offerPrice');
                            var cart_id = $(this).attr('data-cartID');
                            var productCount = $(this).val();
                            var offer_total =parseFloat(offerPrice)*parseFloat(productCount);
                            offerprice_total = parseFloat(offerprice_total)+offer_total;
                            var product_total =parseFloat(price)*parseFloat(productCount);
                            total = parseFloat(total)+product_total;
                            $('#total_'+cart_id).html('₹'+product_total.toFixed(2));
                        }
                    });
                    var subtotal = parseFloat(offerprice_total)+parseFloat(total);
                    $('#subtotal').html('₹'+subtotal.toFixed(2));
                    $('#discount_total').html('- ₹'+offerprice_total.toFixed(2));
                    var couponIdHid= $('#couponIdHid').val();
                    var coupon_offfer= 0;
                    if(couponIdHid!=0){
                        var couponAmount= $('#couponAmount').val();
                        var couponType= $('#couponType').val();
                        if(couponType=='%'){
                            var dis_amnt1 = couponAmount/100;
                            var dis_amnt2 = parseFloat(total)*parseFloat(dis_amnt1);
                            $('#couponHid').val(dis_amnt2.toFixed(2));
                            $('#coupon_th').html('- ₹'+dis_amnt2.toFixed(2));
                        }else{
                            $('#couponHid').val(couponAmount);
                        }
                    }
                    coupon_offfer = $('#couponHid').val();
                    var grandtotal = parseFloat(total)-parseFloat(coupon_offfer);
                    $('#grandtotal_th').html('₹'+grandtotal.toFixed(2));
                    // $('#grandtotalHid').val(grandtotal);
                    
                }
            }
        });
    }
});