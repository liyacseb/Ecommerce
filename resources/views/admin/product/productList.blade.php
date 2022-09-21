@extends('admin.layout.layoutbody')

@php
    $breadcrumbs = [['title' => 'Product List','route' =>null ]];
@endphp
   
@push('css')
<!-- <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css"> -->
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
    <h3 class="card-title">Product</h3>

    <div class="card-tools">
      <a href="{{route('productcreate')}}" class="btn btn-primary"   title="Add new Product">
      Add Product
      </a>
      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
        <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped projects datatable dataTable data-table">
        <thead>
            <tr>
                <th style="width: 20%">
                    #
                </th>
                <th style="width: 15%">
                    Product Name
                </th>
                <th style="width: 15%">
                    Category
                </th>
                <th style="width: 15%">
                    Tax (%)
                </th>
                <th style="width: 15%">
                    Amount
                </th>
                <th style="width: 10%">
                    Status
                </th>
                <th style="width: 10%">
                </th>
            </tr>
        </thead>
        <tbody>
            
           
        </tbody>
    </table>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
    
</section>
<!-- /.content -->

@endsection

@push('js')
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
        // lengthMenu: [
        //         [10, 20, 40, 60, 80, 100, -1],
        //         [10, 20, 40, 60, 80, 100, "All"],
        //     ],
        ajax: "{{ route('productListing') }}",
        columns: [
            {data: 'DT_RowIndex', name: '', orderable: false, searchable: true,sWidth: '20'},
            {data: 'product_name', name: 'product_name',orderable: true, searchable: true,sWidth: '15%'},
            {data: 'getall_category.category_name', name: 'getall_category.category_name',orderable: true, searchable: true,sWidth: '15%'},
            {data: 'get_tax.tax', name: 'get_tax.tax',orderable: true, searchable: true,sWidth: '15%'},
            {data: 'actual_price', name: 'actual_price',orderable: true, searchable: true,sWidth: '25%'},
            {data: 'status', name: 'status',orderable: true, searchable: true,sWidth: '15%'},
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
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
                            window.location.href = baseurl+'/product/product-list';
                            
                        });
                        setTimeout(function () {
                        window.location.href = baseurl+'/product/product-list';
                        }, 1000);
                    }else{
                        Swal.fire({
                            html: data.message,// add html attribute if you want or remove
                            allowOutsideClick: false
                        }).then(function() {
                            // window.location = "redirectURL";
                            window.location.href = baseurl+'/product/product-list';
                        
                        });
                        setTimeout(function () {
                            window.location.href = baseurl+'/product/product-list';
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
</script>

@endpush