$(document).ready(function() {
    $("#register").validate({
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
            password : {
                required: true,
                minlength:4
            },
            confirmPassword : {
                required: true,
                minlength:4,
                equalTo: "#password"
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
                        Swal.fire({
                            html: "Can't Register",// add html attribute if you want or remove
                            allowOutsideClick: false                        
                        });
                    }else{
                        if(detail.message=='Succesfully login'){
                            Swal.fire({
                                html: detail.message,// add html attribute if you want or remove
                                allowOutsideClick: false
                            }).then(function() {
                                // window.location = "redirectURL";
                                window.location.href = baseurl;
                                
                            });
                            setTimeout(function () {
                                window.location.href = baseurl;
                            }, 1000);
                        }else{
                            Swal.fire({
                                html: detail.message,// add html attribute if you want or remove
                                allowOutsideClick: false
                            });
                        }
                       
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