@extends('admin.layout.layoutbody')

@php
    $breadcrumbs = [['title' => 'Size List','route' =>null ]];
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
    <h3 class="card-title">Size</h3>

    <div class="card-tools">
      <a href="{{route('sizecreate')}}" class="btn btn-primary"   title="Add new Size">
      Add Size
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
  <div class="table-responsive">
    <table class="table table-striped projects datatable dataTable data-table">
        <thead>
            <tr>
                <th style="width: 20%">
                    #
                </th>
                <th style="width: 70%">
                    Name
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
        ajax: "{{ route('sizeListing') }}",
        columns: [
            {data: 'DT_RowIndex', name: '', orderable: false, searchable: true,sWidth: '20'},
            {data: 'size', name: 'size',orderable: true, searchable: true,sWidth: '70%'},
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

@endpush