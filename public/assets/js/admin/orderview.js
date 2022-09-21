$(document).ready(function(){
     $.ajaxSetup({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept':'application/json'
        }
    });
    $('.orderstatuscls').click(function(){
        var id= $(this).val();
        var checkedstat=false;
        if ( $(this).is(':checked') ) {  
            checkedstat=true;
        }
        for(var i=0;i<id;i++){
            // console.log(i);
            if (! $('#status_'+i).is(':disabled') ) {  
            $('#status_'+i).attr('checked',checkedstat);
            }
        }
    });
    $('#orderchangebtn').click(function(){
        var actionurl=$(this).attr('data-updateorderurl');
        var orderDetID= $('#orderdetIdHid').val();
        var allVals = [];
       
        $.each($("input[name='orderstatus']:checked"), function(){
            if (! $(this).is(':disabled') ) {  
            allVals.push($(this).val());
            }
        });
        
        if(allVals.length>0){
            $('#orderstatusErr').html('');
            $('#orderstatus-modal').hide();
            $.ajax({
                type:'POST',
                data:{orderDetID:orderDetID,status:allVals},
                url:actionurl,
                success:function(data)
                {
                    // console.log(data);
                    Swal.fire({
                        html: 'Order status updated succesfully',// add html attribute if you want or remove
                        allowOutsideClick: false                        
                    }).then(function() {
                        // window.location = "redirectURL";
                        location.reload();
                        
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            });
        }else{
            $('#orderstatusErr').html('Please change order status');
        }
    });
    $("#orderstatus-modal").on("hidden.bs.modal", function(){
        $(this).find('form').trigger('reset');
    });
   $('.orderstatuschange').click(function(){
        $('#orderstatusErr').html('');       
        var id=$(this).attr('data-id');
        var status=$(this).attr('data-currntstatus');
        var proname=$(this).attr('data-proname');
        $('.modal-title').empty();
        $('.modal-title').html('<b>'+proname+' - Change Order Status</b>');
        // console.log(status);
        $('#orderdetIdHid').val(id);
        $('.orderstatuscls').attr('disabled',false);
        $('.orderstatuscls').attr('checked',false);
        for(var i=0;i<=status;i++){
            $('#status_'+i).attr('disabled',true);
            $('#status_'+i).attr('checked',true);
        }
    });

    $('#paystatus').change(function(){
        var value=$(this).val();
        if(value==0){
            $(this).val(1);
           
        }else{            
            $(this).val(0);
        }
    });
    $('#paymentchangebtn').click(function(){
        var value=$('#paystatus').val();
        if(value==1){
            var orderIdHid=$('#orderIdHid').val();
            var actionurl = $(this).attr('data-updateorderurl');
            $.ajax({
                type:'POST',
                data:{orderID:orderIdHid,status:1},
                url:actionurl,
                success:function(data)
                {
                    // console.log(data);
                    Swal.fire({
                        html: 'Payment status updated succesfully',// add html attribute if you want or remove
                        allowOutsideClick: false                        
                    }).then(function() {
                        // window.location = "redirectURL";
                        location.reload();
                        
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            });
        }
    });
});