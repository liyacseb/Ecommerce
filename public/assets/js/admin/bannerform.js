$(document).ready(function() {
    $.validator.setDefaults({
        ignore: ":hidden:not('.hiddenclass')" // validate all hidden fields with specified class
      });
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept':'application/json'
        }
    });
    $("#bannerform").validate({
        errorPlacement: function (error, element) {
            // console.log('dd', element.attr("name"))
            if (element.attr("name") == "banner_upload") {
                error.appendTo("#bannerErr");
            } else {
                error.insertAfter(element)
            }
        },
        rules: {
            banner_upload : {
                required: true,
            },
            status : {
                required: true,
            }
        },
        messages: {
            banner_upload: {
                required: "Please upload banner image",
            },
            status: {
                required: "Please provide status ",
            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(form) {
            $.ajax({
                dataType:'json',
                type:'post',
                data:new FormData($(form)[0]),
                url:storeurl,
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
        }
    });
    $("#bannerupdateform").validate({
        errorPlacement: function (error, element) {
            // console.log('dd', element.attr("name"))
            if (element.attr("name") == "banner_upload") {
                error.appendTo("#bannerErr");
            } else {
                error.insertAfter(element)
            }
        },
        rules: {
            status : {
                required: true,
            }
        },
        messages: {
            status: {
                required: "Please provide status ",
            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(form) {
           
            $.ajax({
                dataType:'json',
                type:'post',
                data:new FormData($(form)[0]),
                url:storeurl,
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
        }
    });
    $('#status').change(function(){
        var status = $(this).val();
        if(status==0){
            $.ajax({
                dataType:'json',
                type:'get',
                data:{status:status},
                url:checkurl,
                // processData:false,
                // cache:false,
                // contentType:false,
                success:function(data){
                    console.log(data.bannercount);
                    if(data.bannercount<2){
                        $('#statusErr').html('Atleast one banner should be active');
                        $('#updbtn').attr('disabled',true);
                    }else{
                        $('#statusErr').html('');    
                        $('#updbtn').attr('disabled',false);                
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
            });
        }else{
            $('#statusErr').html('');
            $('#updbtn').attr('disabled',false);
        }
    });
    
});