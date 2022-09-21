@extends('user.layouts.layout')
@php
    $breadcrumbs = [['title' => 'My Orders','route' =>null ]];
@endphp
@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  
<style>
</style>
@endpush
@section('maincontent')
    <div id="all">
      <div id="content">
        <div class="container">
          <div class="row">
          
             @component('user.layouts.breadcrump',compact('breadcrumbs')) @endcomponent
            <div class="col-lg-3">
              <!--
              *** CUSTOMER MENU ***
              _________________________________________________________
              -->
              <div class="card sidebar-menu">
                <div class="card-header">
                  <h3 class="h4 card-title">Customer section</h3>
                </div>
                <div class="card-body">
                  <ul class="nav nav-pills flex-column">
                   @include('user.userlink')
                  </ul>
                </div>
              </div>
              <!-- /.col-lg-3-->
              <!-- *** CUSTOMER MENU END ***-->
            </div>
            <div id="customer-orders" class="col-lg-9">
              <div class="box">
                <h1>My orders</h1>
                <p class="lead">Your orders on one place.</p>
                {{-- <p class="text-muted">If you have any questions, please feel free to <a href="contact.html">contact us</a>, our customer service center is working for you 24/7.</p> --}}
                
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Order</th>
                        <th>Date</th>
                        <th>Total</th>
                        {{-- <th>Status</th> --}}
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @if(count($orderdetails)>0)
                      @foreach($orderdetails as $val)
                        <tr>
                          <td># {{$val['id']}}</td>
                          <td> 
                          @php $date=date_create($val['order_date']); @endphp
                          {{date_format($date,"d/m/Y");}}
                          </td>
                          <td>₹  {{$val['grand_total']}}</td>
                          {{-- <td>
                          @if($val['payment_status']==2)
                            <span class="badge badge-danger">Order Failed</span>
                          @else
                            <span class="badge badge-info">Being prepared</span>
                          @endif
                          </td> --}}
                          <td><a href="{{route('orderdetail',$val['id'])}}" class="btn btn-primary btn-sm">View</a></td>
                        </tr>
                      @endforeach
                    @else
                      <tr>
                        <td colspan="5"><center><span class="text-danger">Not Yet Purchased!!!</span></center></td>
                      </tr>
                    @endif
                      {{-- <tr>
                        <th># 1735</th>
                        <td>22/06/2013</td>
                        <td>$ 150.00</td>
                        <td><span class="badge badge-success">Received</span></td>
                        <td><a href="customer-order.html" class="btn btn-primary btn-sm">View</a></td>
                      </tr>
                      <tr>
                        <th># 1735</th>
                        <td>22/06/2013</td>
                        <td>$ 150.00</td>
                        <td><span class="badge badge-danger">Cancelled</span></td>
                        <td><a href="customer-order.html" class="btn btn-primary btn-sm">View</a></td>
                      </tr>
                      <tr>
                        <th># 1735</th>
                        <td>22/06/2013</td>
                        <td>$ 150.00</td>
                        <td><span class="badge badge-warning">On hold</span></td>
                        <td><a href="customer-order.html" class="btn btn-primary btn-sm">View</a></td>
                      </tr> --}}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
{{-- <script src="{{asset('assets/js/user/orders.js')}}"></script> --}}

@endpush