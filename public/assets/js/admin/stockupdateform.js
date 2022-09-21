$(document).ready(function() {
    var stock = 0;
    var stk=0;
    $('#product').change(function(){
        var proID = $('#product').val();
        // console.log(proID);
        $.ajaxSetup({
            headers: {
                'X-CSSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept':'application/json'
            }
        });

        $.ajax({
            dataType:'json',
            type:'get',
            data:{'proID':proID},
            url:baseurl+'/stock/getprodcolorsize',
            // async:false,
            // processData:false,
            // cache:false,
            // contentType:false,
            success:function(details){
                if(details.data){
                    if(details.data.color.length!=0){
                        $('#stkBody').empty();
                        var hidStkName =[];
                        $.each(details.data.color, function(key,val) {
                            
                            // console.log (key+val.color);
                            if(details.data.size.length>0){
                              
                                $.each(details.data.size, function(key2,val2) {
                                     stock = fetchproductstock(proID,val.id,val2.id);
                                    console.log(stock);
                                    hidStkName.push('stock_'+val.id+'_'+val2.id);
                                    $('#stkBody').append('<tr>'+
                                        '<td>'+val.color+'</td>'+
                                        '<td>'+val2.size+'</td>'+
                                        '<td><input required class="number" type="text" value="" name="stock_'+val.id+'_'+val2.id+'" id="stock_'+val.id+'_'+val2.id+'"></td>'+
                                    '</tr>');
                                });
                            }else{
                                hidStkName.push('stock_'+val.id+'_0');
                                 stock = fetchproductstock(proID,val.id,0);
                                console.log(stock);
                                $('#stkBody').append('<tr>'+
                                    '<td>'+val.color+'</td>'+
                                    '<td>Nill</td>'+
                                    '<td><input required class="number" type="text" value="" name="stock_'+val.id+'_0" id="stock_'+val.id+'_0"></td>'+
                                '</tr>');
                            }
                            $('#stkNames').val(hidStkName.toString())
                        });
                    }
                    
                }
            },
            error: function(resp){
                console.log(resp);
                let errors=resp.responseJSON.errors;
                // console.log(errors);
                
            }
        });
    });
    $("#stockform").validate({
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
                success:function(data){
                    if(data.status==0){
                        Swal.fire({
                            html: data.message,// add html attribute if you want or remove
                            allowOutsideClick: false                        
                        }).then(function() {
                            // window.location = "redirectURL";
                            window.location.href = baseurl+'/stock/stock-list';
                            
                        });
                        setTimeout(function () {
                        window.location.href = baseurl+'/stock/stock-list';
                        }, 1000);
                    }else{
                        Swal.fire({
                            html: data.message,// add html attribute if you want or remove
                            allowOutsideClick: false
                        }).then(function() {
                            // window.location = "redirectURL";
                            window.location.href = baseurl+'/stock/stock-list';
                        
                        });
                        setTimeout(function () {
                            window.location.href = baseurl+'/stock/stock-list';
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
    $('.number').keypress(function(event){

        if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
            event.preventDefault(); //stop character from entering input
        }
 
    });

    $("#product").trigger("change");

    function fetchproductstock(proID,colorID,sizeID){
        $.ajaxSetup({
            headers: {
                'X-CSSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept':'application/json'
            }
        });

        $.ajax({
            dataType:'json',
            type:'get',
            data:{'proID':proID,'colorID':colorID,'sizeID':sizeID},
            url:baseurl+'/stock/fetchproductstock',
            // async:false,
            // processData:false,
            // cache:false,
            // contentType:false,
            success:function(details){
                if(details.data){
                   console.log(details.data[0]['stock']);
                //    return details.data[0]['stock'];
                 stk = details.data[0]['stock'];
                 $('#stock_'+colorID+'_'+sizeID).val(stk);
                // alert(1);
                   return stk;
                }else{
                    return 0;
                }
            }
        });
    }
});