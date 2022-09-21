$(document).ready(function(){
    $('#sort-by').change(function(){
        // console.log($(this).val());
        var sortBy = $(this).val();
        var action = $('#sortbyurl').val();
        var catid = $('#catid').val();
        $.ajax({
            dataType:'json',
            type:'get',
            data:{sortBy:sortBy,catid:catid},
            url:action,
            success:function(data){
                console.log(data);
                if(data.length>0){
                    $('.products').empty();
                    $('.products').append(data);                    
                }
            }
        });
    });
});