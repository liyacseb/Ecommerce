$(document).ready(function() {
    $("#sizeform").validate({
        errorPlacement: function (error, element) {
            // console.log('dd', element.attr("name"))
            if (element.attr("name") == "correct_answer") {
                error.appendTo("#radioErr");
            } else {
                error.insertAfter(element)
            }
        },
        rules: {
            size : {
                required: true,
                minlength: 1
            }
        },
        messages: {
            size: {
                required: "Please provide size name",
                minlength: "Size must be at least 1 characters long"
            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(form) {
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
        }
    });
});