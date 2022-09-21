$(document).ready(function(){
    
    $.ajaxSetup({
        headers: {
            'X-CSSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept':'application/json'
        }
    });
    $('.checkoutbtn').click(function(e){
        e.preventDefault();
        if( $('input[name=checkout_address]:checked', '#checkoutaddressform').val()){           
            $("#adrressRequireErr").html('');
            $('#checkoutaddressform').submit();
        }else{
            $("#adrressRequireErr").html('Please chose address');
        }
        
    });
    $('.addressbox').on("click",".checkout_address",function(){
        $("#adrressRequireErr").html('');
    });
   
    var validator =$("#addressform").validate({
        errorPlacement: function (error, element) {
            // console.log('dd', element.attr("name"))
            if (element.attr("name") == "addressType") {
                error.appendTo("#addressTypeErr");
            } else {
                error.insertAfter(element)
            }
        },
        rules: {
            name : {
                required: true
            },
            phone_number : {
                required: true,
                digits:true
            },
            adrs_line_1 : {
                required: true
            },
            adrs_line_2 : {
                required: true
            },
            zip : {
                required: true
            },
            district : {
                required: true
            },
            state : {
                required: true
            },
            country : {
                required: true
            },
            addressType : {
                required: true
            }
        },
        submitHandler: function(form) {
            var datas = new FormData($(form)[0]);
            console.log(datas);
            if($('#adderssIdHid').val()==0){
                var action = $('#addressform').attr('data-addaddressurl');
            }else{
                var action = $('#addressform').attr('data-editaddressurl');
            }
            
            $.ajax({
                dataType:'json',
                type:'post',
                data:datas,
                url:action,
                processData:false,
                cache:false,
                contentType:false,
                success:function(detail){
                    console.log(detail);
                    if(detail.addressid){
                        var name = $('#name').val();
                        var phone_number = $('#phone_number').val();
                        var adrs_line_1 = $('#adrs_line_1').val();
                        var adrs_line_2 = $('#adrs_line_2').val();
                        var zip = $('#zip').val();
                        var district = $('#district').val();
                        var state = $('#state').val();
                        var country = $('#country').val();
                        var addressType = $('input[name=addressType]:checked', '#addressform').val();
                        console.log(addressType);
                        if(addressType=='0'){
                            addressType='Home';
                        }else{
                            addressType='Work';
                        }
                        
                        if($('#adderssIdHid').val()==0){
                            $('.addressbox').append('<div class="col-md-6 address-col-'+detail.addressid+'">'+                  
                                '<div class="box row addressdiv">'+
                                    '<div class="addressbox-left text-left col-2">'+
                                        '<input type="radio" class="checkout_address" name="checkout_address" value="'+detail.addressid+'">'+                          
                                    '</div>'+
                                    '<div class="col-8 ml-3" id="divaddressdet_2">'+
                                        '<h5 style="display:inline-flex">'+
                                        '<b>'+name+'</b>&nbsp;<span class="badge badge-secondary adrresstype"> '+addressType+' </span> '+                           
                                        '</h5><br>'+
                                        '<b>'+phone_number+'</b><br>'+
                                        '<span>'+adrs_line_1+','+adrs_line_2+'<br>'+district+','+state+'<br>'+country+'</span><br>'+
                                        '<span>'+zip+'</span>'+
                                    '</div>'+
                                    '<div class="addressbox-right col-2">'+
                                    '<a class="text-info mt-2 editaddress" data-id="'+detail.addressid+'" data-toggle="modal" data-target="#address-modal"><i class="fa fa-pencil" aria-hidden="true"></i></a>                        '+
                                  '</div>'+
                                ' </div>'+
                            '</div>');
                        }else{
                            var addressidhid= $('#adderssIdHid').val();
                            $(".addressbox").find('.address-col-'+addressidhid).empty();
                            console.log(detail.addressid.id);
                            // $('#divaddressdet_'+$('#adderssIdHid').val()).empty();
                            $(".addressbox").find('.address-col-'+addressidhid).append('<div class="box row addressdiv">'+
                                '<div class="addressbox-left text-left col-2">'+
                                    '<input type="radio" class="checkout_address" name="checkout_address" value="'+detail.addressid.id+'">'+                          
                                '</div>'+
                                '<div class="col-8 ml-3" id="divaddressdet_2">'+
                                    '<h5 style="display:inline-flex">'+
                                    '<b>'+name+'</b>&nbsp;<span class="badge badge-secondary adrresstype"> '+addressType+' </span> '+                           
                                    '</h5><br>'+
                                    '<b>'+phone_number+'</b><br>'+
                                    '<span>'+adrs_line_1+','+adrs_line_2+'<br>'+district+','+state+'<br>'+country+'</span><br>'+
                                    '<span>'+zip+'</span>'+
                                ' </div>'+
                                '<div class="addressbox-right col-2">'+
                                    '<a class="text-info mt-2 editaddress" data-id="'+detail.addressid.id+'" data-toggle="modal" data-target="#address-modal"><i class="fa fa-pencil" aria-hidden="true"></i></a>                        '+
                                '</div>'+
                            '</div>');
                        }
                        resetaddressfield();
                        $('#address-modal').modal('hide');
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
            });
        }
    });

    $('.addaddress').click(function(){
        resetaddressfield();        
    });
    $('.addressbox').on("click",".editaddress",function(){
        console.log('fe');
        resetaddressfield();
        var id = $(this).attr('data-id');
        $.ajax({
            dataType:'json',
            type:'get',
            url:baseurl+'/getuseraddress/'+id,
            // processData:false,
            // cache:false,
            // contentType:false,
            success:function(detail){
                if(detail.addressDet){
                    $('#adderssIdHid').val(detail.addressDet.id);
                    $('#name').val(detail.addressDet.name);
                    $('#adrs_line_1').val(detail.addressDet.adrs_line_1);
                    $('#adrs_line_2').val(detail.addressDet.adrs_line_2);
                    $('#phone_number').val(detail.addressDet.phone_number);
                    $('#company').val(detail.addressDet.company);
                    $('#zip').val(detail.addressDet.pincode);
                    $('#district').val(detail.addressDet.district);
                    $('#state').val(detail.addressDet.state);
                    $('#country').val(detail.addressDet.country);
                    $('input[name="addressType"][value="' + detail.addressDet.adress_type + '"]').prop('checked', true);
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
        });
    });
    function resetaddressfield(){
        $('.adrresstags').val('');
        $('#adderssIdHid').val(0);
        validator.resetForm();
        $('#addressform .error').removeClass('error');
    }

    $('#phone_number').keypress(function(event){

        if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
            event.preventDefault(); //stop character from entering input
        }
       
    });

    // payment method cheking
    $('#paymentbtn').click(function(e){
        e.preventDefault();
        
        if( $('input[name=payment]:checked', '#checkoutpaymentform').val()){           
            $("#paymentRequireErr").html('');
            $('#checkoutpaymentform').submit();
        }else{
            $("#paymentRequireErr").html('Please chose payment method');
        }
    });
   
    // $('.payment').click(function(){
    //     var paymentMethod = $(this).val();
    //     paymentRadiobuttonClickEvent(paymentMethod);
    // });
    $('.payment-method').click(function(){
        var paymentMethod = $(this).attr('data-paymentMethod');
        paymentRadiobuttonClickEvent(paymentMethod);
    });
    function paymentRadiobuttonClickEvent(paymentMethod){
        
        var walletAmount = $('#walletAmount').val();
        var grandtotal = $('#grandtotal').val();
        console.log(walletAmount+'-'+grandtotal);
        $('#paymentbtn').attr('disabled',false);
        $('#paymentbtn').css('cursor','pointer');
        $("#paymentRequireErr").html('');
        if(paymentMethod==3){
            //wallet option
            if(parseFloat(walletAmount)<parseFloat(grandtotal)){
                $('#paymentbtn').attr('disabled',true);
                $('#paymentbtn').css('cursor','not-allowed');
                $("#paymentRequireErr").html("You don't have enough wallet balance.please chose another payment method");
                // alert("You don't have enough wallet balance.please chose another payment method");
            }
        }
    }
});