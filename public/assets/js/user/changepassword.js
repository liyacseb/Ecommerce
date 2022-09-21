$(document).ready(function() {
    $("#changepswdform").validate({
        errorPlacement: function (error, element) {
            // console.log('dd', element.attr("name"))
            if (element.attr("name") == "correct_answer") {
                error.appendTo("#radioErr");
            } else {
                error.insertAfter(element)
            }
        },
        rules: {
            oldPassword : {
                required: true,
                minlength:4
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
                    if(detail.status==0){
                        $('.divError').show();
                        $('.divSuccess').hide(); 
                        //  setTimeout(function () {
                        //     location.reload();
                        // }, 1000);
                    }else{
                        $('.divSuccess').show(); 
                        $('.divError').hide();   
                         setTimeout(function () {
                            location.reload();
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