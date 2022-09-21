@extends('admin.layout.layoutbody')
@php
    $breadcrumbs = [['title' => 'User List','route' =>route('userList') ],['title' => 'User View','route' =>null ]];
@endphp
   
@push('css')
<style>
</style>
@endpush
@section('maincontent')
@component('component.breadcrump',compact('breadcrumbs')) @endcomponent
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  {{-- <img class="profile-user-img img-fluid img-circle"
                       src="../../dist/img/user4-128x128.jpg"
                       alt="User profile picture"> --}}
                </div>
                <h3 class="profile-username text-center">{{$basicdetail['name']}}</h3>

                <p class="text-muted text-center">{{$basicdetail['email']}}</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Joined On</b> <a class="float-right">{{$basicdetail['created_at']}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Wallet Amount</b> <a class="float-right">{{$basicdetail['wallet_amount']}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Phone Number</b> <a class="float-right">{{$basicdetail['phone_number']}}</a>
                  </li>
                </ul>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            {{-- <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
              <!-- /.card-body -->
            </div> --}}
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#orders" data-toggle="tab">Orders</a></li>
                  <li class="nav-item"><a class="nav-link" href="#address" data-toggle="tab">Address</a></li>
                  <li class="nav-item"><a class="nav-link" href="#wallettransaction" data-toggle="tab">Wallet Transaction</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                <!-- /.tab-pane -->
                  <div class="active tab-pane" id="orders">
                   <table class="table table-striped projects datatable dataTable order-data-table">
                        <thead>
                            <tr>
                                <th style="width: 10%">
                                    #
                                </th>
                                <th style="width: 30%">
                                Order Number
                                </th>
                                <th style="width: 30%">
                                    Total
                                </th>
                                <th style="width: 15%">
                                    Order Date
                                </th>
                                <th style="width: 15%">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        
                        </tbody>
                    </table>
                  </div>
                  <div class="tab-pane" id="address">
                  @foreach($addressdetail as $addressVal)
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <span class="">
                          <a href="javascript:"><strong>{{$addressVal['name']}}</strong></a>&nbsp;&nbsp;<span class="badge badge-secondary "> @if($addressVal['adress_type']==0) Home @else Work @endif</span>
                        </span>
                      </div>
                      <!-- /.user-block -->
                      <p>  <b>Phone Number : </b> {{$addressVal['phone_number']}}  </p>
                      <p>  <b>Company : </b> {{$addressVal['company']}}  </p>
                      <p>  <b>Address : </b> {{$addressVal['adrs_line_1']}} , {{$addressVal['adrs_line_2']}}, {{$addressVal['district']}}  , {{$addressVal['state']}} , {{$addressVal['country']}}  </p>
                      <p> <b>Pincode : </b>{{$addressVal['pincode']}}</p>

                    </div>
                    <!-- /.post -->
                    @endforeach

                    <!-- Post -->
                    {{-- <div class="post clearfix">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Sent you a message - 3 days ago</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <form class="form-horizontal">
                        <div class="input-group input-group-sm mb-0">
                          <input class="form-control form-control-sm" placeholder="Response">
                          <div class="input-group-append">
                            <button type="submit" class="btn btn-danger">Send</button>
                          </div>
                        </div>
                      </form>
                    </div> --}}
                    <!-- /.post -->
                  </div>
                  
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="wallettransaction">
                    <table class="table table-striped projects datatable dataTable wallet-data-table">
                        <thead>
                            <tr>
                                <th style="width: 10%">
                                    #
                                </th>
                                <th style="width: 15%">
                                Payment Amount
                                </th>
                                <th style="width: 25%">
                                    Payment Id
                                </th>
                                <th style="width: 30%">
                                    Response
                                </th>
                                <th style="width: 20%">
                                    Payment Date
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        
                        </tbody>
                    </table>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection

@push('js')
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript">
  $(function () {
    
    var table = $('.wallet-data-table').DataTable({
        processing: true,
        serverSide: true,
        responsive:true,
        // lengthMenu: [
        //         [10, 20, 40, 60, 80, 100, -1],
        //         [10, 20, 40, 60, 80, 100, "All"],
        //     ],
        ajax: "{{ route('walletTransaction',$basicdetail['id']) }}",
        columns: [
            {data: 'DT_RowIndex', name: '', orderable: false, searchable: true,sWidth: '10'},
            {data: 'amount', name: 'amount',orderable: true, searchable: true,sWidth: '15%'},
            {data: 'payment_id', name: 'payment_id',orderable: true, searchable: true,sWidth: '25%'},
            {data: 'responsedet', name: 'responsedet',orderable: true, searchable: true,sWidth: '30%'},
            {data: 'date', name: 'date',orderable: true, searchable: true,sWidth: '20%'},
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
    
    var table = $('.order-data-table').DataTable({
        processing: true,
        serverSide: true,
        responsive:true,
        // lengthMenu: [
        //         [10, 20, 40, 60, 80, 100, -1],
        //         [10, 20, 40, 60, 80, 100, "All"],
        //     ],
        ajax: "{{ route('individualorderListing',$basicdetail['id']) }}",
        columns: [
            {data: 'DT_RowIndex', name: '', orderable: false, searchable: true,sWidth: '10'},
            {data: 'ordernumber', name: 'ordernumber',orderable: true, searchable: true,sWidth: '30%'},
            {data: 'grand_total', name: 'grand_total',orderable: true, searchable: true,sWidth: '30%'},
            {data: 'date', name: 'date',orderable: true, searchable: true,sWidth: '15%'},
            {data: 'action', name: 'action',orderable: true, searchable: false,sWidth: '15%'},
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
@endpush