$(document).ready(function() {
    $("#categoryaddform").validate({
        errorPlacement: function (error, element) {
            // console.log('dd', element.attr("name"))
            if (element.attr("name") == "correct_answer") {
                error.appendTo("#radioErr");
            } else {
                error.insertAfter(element)
            }
        },
        rules: {
            category_name : {
                required: true,
                minlength: 2
            },
            category_status : {
                required: true
            }
        },
        messages: {
            category_name: {
                required: "Please provide category name",
                minlength: "Category name must be at least 2 characters long"
            },
            category_status: {
                required: "Please select status"
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
                    // console.log( window.location);
                        Swal.fire({
                            html: data.message,// add html attribute if you want or remove
                            allowOutsideClick: false                        
                        }).then(function() {
                            window.location =listurl;
                            
                        });
                        setTimeout(function () {
                        window.location = listurl;
                        }, 1000);
                    
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