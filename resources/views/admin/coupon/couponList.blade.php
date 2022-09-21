@extends('admin.layout.layoutbody')

@php
    $breadcrumbs = [['title' => 'Coupon List','route' =>null ]];
@endphp
   
@push('css')
<!-- <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('maincontent')
@component('component.breadcrump',compact('breadcrumbs')) @endcomponent
<!-- Main content -->
<section class="content">

<!-- Default box -->
<div class="card">
    @if(session()->has('success'))
        <div class="mt-4"><center><span class="text-success"><strong> {{session()->get('success'); }} </strong></span></center></div>
    @endif
    @if(session()->has('successbulk'))
        <div class="mt-4"><center><span class="text-success"><strong> {{session()->get('successbulk'); }} </strong></span></center></div>
    @endif
    @if(session()->has('errors'))
        <div class="mt-4"><center><span class="text-danger"><strong> {{session()->get('errors'); }} </strong></span></center></div>
    @endif
  <div class="card-header">
    <h3 class="card-title">Coupon</h3>

    <div class="card-tools">
      <a href="#" data-toggle="dropdown" class="btn btn-primary"   title="Add new Coupon">
      Add Coupon
      </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="{{route('couponcreate')}}" class="dropdown-item">Single Coupon
          </a>
          <a href="#" data-toggle="modal" data-target="#coupon-import" class="dropdown-item">Unlimited Coupon
          </a>
        </div>
      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
        <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>
  <div class="card-body p-0">
  <div class="table-responsive">
    <table class="table table-striped projects datatable dataTable data-table">
        <thead>
            <tr>
                <th style="width: 10%">
                    #
                </th>
                <th style="width: 25%">
                    Coupon Code
                </th>
                <th style="width: 25%">
                    Amount
                </th>
                <th style="width: 15%">
                    Used Status
                </th>
                <th style="width: 15%">
                    Applicable user
                </th>
                <th style="width: 10%">
                </th>
            </tr>
        </thead>
        <tbody>
            
           
        </tbody>
    </table>
  </div>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
      <div class="modal fade" id="coupon-import">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Coupon Code Generation</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form data-href="{{route('unlimitedcoupon')}}" name="unlimitedcouponform" id="unlimitedcouponform" method="post" >
                @csrf
            <div class="modal-body">
                <div class="row">
                  <div class="col-md-4">
                    <label for="inputName">Coupon Limit</label>
                    <input type="text" name="limit" id="limit" class="form-control" required>
                  </div>
                  <div class="col-md-4">
                    <label for="inputName">Coupon Amount </label>
                    <input type="text" name="amount" id="amount" class="form-control" required>
                    <span id="coupontyperr" class="text-danger"></span>
                  </div>
                  <div class="col-md-4">
                    <label for="coupon_type">Coupon Type </label>
                    @php $array=(config('options')) @endphp
                    <select name="coupon_type" id="coupon_type" class="form-control custom-select" required>
                      <option selected disabled>Select one</option>
                      @foreach($array['coupon_type'] as $key => $ans )
                        <option value="{{$key}}" ><i class="fas {{$ans}}"></i>{{$ans}}</option>                           
                       @endforeach
                    </select>                        
                  </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary " >Save</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</section>
<!-- /.content -->

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>  


<script src="{{asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script><script>
$(function () {
  bsCustomFileInput.init();
});
</script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript">
  $(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        responsive:true,
        // lengthMenu: [
        //         [10, 20, 40, 60, 80, 100, -1],
        //         [10, 20, 40, 60, 80, 100, "All"],
        //     ],
        ajax: "{{ route('couponListing') }}",
        columns: [
            {data: 'DT_RowIndex', name: '', orderable: false, searchable: true,sWidth: '10'},
            {data: 'coupon_code', name: 'coupon_code',orderable: true, searchable: true,sWidth: '25%'},
            {data: 'amount', name: 'amount',orderable: true, searchable: true,sWidth: '25%'},
            {data: 'used', name: 'used',orderable: true, searchable: true,sWidth: '15%'},
            {data: 'user', name: 'user',orderable: true, searchable: true,sWidth: '15%'},
            {data: 'action', name: 'action', orderable: true, searchable: true,sWidth: '10%'},
        ],
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            
        'pageLength'
        ],
        
    });
    
  });
</script>
<script>
$(document).ready(function(){
    
$('.data-table').on('click', '.actionDelete', function() {
    href = $(this).attr('data-href');
    Swal.fire({
        title: 'Do you want to delete?',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No, cancel!',
        cancelButtonColor: '#d33',
        // customClass: {
        //     actions: 'my-actions',
        //     cancelButton: 'order-1 right-gap',
        //     confirmButton: 'order-2',
        //     denyButton: 'order-3',
        // }
    }). then((isConfirm) => {
        if (isConfirm.value) {
            window.location.href = href;
        }
        // else{
        //     console.log("bikgu");
        // }
        return false;
    });
});
});
</script>
<script>
$(document).ready(function() {
    $("#unlimitedcouponform").validate({
        errorPlacement: function (error, element) {
            // console.log('dd', element.attr("name"))
            if (element.attr("name") == "correct_answer") {
                error.appendTo("#radioErr");
            } else {
                error.insertAfter(element)
            }
        },
        rules: {
            limit : {
                required: true,
                digits: true
            },
            amount : {
                required: true,
                digits: true
            },
            coupon_type : {
                required: true
            }
        },
        messages: {
            limit: {
                required: "Please provide coupon code"
            },
            amount: {
                required: "Please provide amount"
            }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(form) {
            var coupon_type = $('#coupon_type').val();
            var error=0;
            if(coupon_type=='%'){
                var coupon_amount = parseFloat($('#amount').val());
                console.log(coupon_amount);
                if (isNaN(coupon_amount) || coupon_amount < 0 || coupon_amount > 99) {
                    // value is out of range
                    $('#coupontyperr').html('Please enter valid amount');
                    error=1;
                }
            }
            if(error==0){
                $('#coupontyperr').html('');
                var action = $('#unlimitedcouponform').attr('data-href');
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
                                window.location.href = baseurl+'/coupon/coupon-list';
                                
                            });
                            setTimeout(function () {
                            window.location.href = baseurl+'/coupon/coupon-list';
                            }, 1000);
                        }else{
                            Swal.fire({
                                html: data.message,// add html attribute if you want or remove
                                allowOutsideClick: false
                            }).then(function() {
                                // window.location = "redirectURL";
                                window.location.href = baseurl+'/coupon/coupon-list';
                            
                            });
                            setTimeout(function () {
                                window.location.href = baseurl+'/coupon/coupon-list';
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
            }else{
                return false;
            }
        }
    });
});
</script>

@endpush