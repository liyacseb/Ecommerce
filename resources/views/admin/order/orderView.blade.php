@extends('admin.layout.layoutbody')
@php
    $breadcrumbs = [['title' => 'Order List','route' =>route('orderList') ],['title' => 'Order View','route' =>null ]];
@endphp
   
@push('css')
<style>
.prodImg{
    width:20%;
    height:20%;
}
input[type="checkbox"]:disabled:checked {
    cursor: default;
    background-color: -internal-light-dark(rgba(239, 239, 239, 0.3), rgba(59, 59, 59, 0.3));
    color: -internal-light-dark(rgb(84, 84, 84), rgb(170, 170, 170));
    border-color: rgb(203 27 27);
}
</style>

@endpush
@section('maincontent')
@component('component.breadcrump',compact('breadcrumbs')) @endcomponent
<!-- Main content -->
<section class="content">
 <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                {{-- <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> AdminLTE, Inc.
                    <small class="float-right">Date: 2/10/2014</small>
                  </h4>
                </div> --}}
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  Order By
                  <address>
                    <strong>{{$userDetail->name}}</strong><br>
                    Phone:{{$userDetail->phone_number}}<br>
                    Email: {{$userDetail->email}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                   Shipping Address
                  <address>
                    <strong>{{$orderDetail[0]['getOrderDetail']['name']}}</strong>&nbsp;<span class="badge badge-secondary adrresstype">@if($orderDetail[0]['getOrderDetail']['adress_type']==0) Home @else Work @endif</span><br>
                     {{$orderDetail[0]['getOrderDetail']['adrs_line_1']}},  {{$orderDetail[0]['getOrderDetail']['adrs_line_2']}}<br>
                    {{$orderDetail[0]['getOrderDetail']['district']}},{{$orderDetail[0]['getOrderDetail']['state']}},{{$orderDetail[0]['getOrderDetail']['country']}}<br>
                    Phone: {{$orderDetail[0]['getOrderDetail']['phone_number']}}<br>
                    Pincode: {{$orderDetail[0]['getOrderDetail']['pincode']}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  {{-- <b>Invoice #007612</b><br> --}}
                  <br>
                  <b>Order ID:</b> #{{$orderDetail[0]['getOrderDetail']['id']}}<br>
                  @php
                    $date=date_create($orderDetail[0]['getOrderDetail']['order_date']);
                    $ordrDate= date_format($date,'d/m/Y');
                  @endphp
                  <b>Order Date:</b> {{$ordrDate}}<br>
                  @if($orderDetail[0]['getOrderDetail']['payment_status']==0)
                    @if($orderDetail[0]['getOrderDetail']['payment_gateway']==4)
                    <button class="mt-2 btn btn-primary" data-toggle="modal" data-target="#paymentstatus-modal">payment status</button>
                    @endif
                  @endif
                  {{-- <b>Account:</b> 968-34567 --}}
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th style="width:10%">#</th>
                      <th style="width:15%">Product</th>
                      <th style="width:10%">Quantity</th>
                      <th style="width:15%">Unit Price</th>
                      <th style="width:15%">Discount</th>
                      <th style="width:15%">Total</th>
                      <th style="width:10%">Status</th>
                      <th style="width:10%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orderDetail as $value)
                    <tr>
                      <td>1</td>
                      <td>
                      <a><img class="prodImg" src="{{asset('assets/product/'.$value->cover_image)}}" alt=" {{$value->product_name}} "></a><br>
                      <a>{{$value->product_name}}</a><br>
                      <a>Color : {{$value['getColor']['color']}}</a>
                      @if($value['getSize'])
                      <br><a>Size : {{$value['getSize']['size']}}</a>
                      @endif
                      </td>
                      <td>{{$value->prod_count}}</td>
                      <td>₹{{$value->actual_price}}</td>
                      @php
                          $discount=0;
                      @endphp
                      @if($value->offer_price)
                          @php
                            $price = $value->offer_price;
                            $discount=$value->actual_price-$value->offer_price;
                          @endphp
                          @else
                          @php
                            $price = $value->actual_price;
                          @endphp
                        @endif
                        <td> ₹ {{$discount}}</td>
                      <td>₹{{$price}}</td>
                      <td>@php $array=(config('options')) @endphp
                         @foreach($array['purchase_status'] as $key => $ans )
                            @if($key==$value['order_status'])
                              {{$ans}}
                            @endif
                         @endforeach</td>
                         <td>
                          @if($value['order_status']!=2)
                         <button class="btn btn-info orderstatuschange" 
                          data-toggle="modal" data-target="#orderstatus-modal" 
                          data-proname="{{$value->product_name}}" data-id="{{$value['id']}}" 
                          data-currntstatus="{{$value['order_status']}}" >Change order status
                          </button>
                         @endif
                         </td>
                    </tr>
                    @endforeach
                   
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                    @if($paymentDetail!=null)
                        <p class="lead">Payment Details:</p>
                        @if($orderDetail[0]['getOrderDetail']['payment_gateway']==1)
                            <p>Method : Razorpay</p>
                            @php                        
                            $json_decoded = json_decode($paymentDetail[0]['response']);
                            @endphp
                            @foreach($json_decoded as $key=>$result)
                            <p> {{$key}} : {{$result}}</p>
                            @endforeach
                        @elseif($orderDetail[0]['getOrderDetail']['payment_gateway']==2)
                        <p>Method : Stripe</p>
                        <p>ID :{{ $paymentDetail[0]['payment_id']}} </p>
                        @endif
                    @endif
                </div>
                <!-- /.col -->
                <div class="col-6">
                  {{-- <p class="lead">Amount Due 2/22/2014</p> --}}

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        @if($orderDetail[0]['getOrderDetail']['coupon_discount'])
                            @php $total = $orderDetail[0]['getOrderDetail']['grand_total']-$orderDetail[0]['getOrderDetail']['coupon_discount']; @endphp
                        @else
                            @php $total = $orderDetail[0]['getOrderDetail']['grand_total'];  @endphp
                        @endif
                        <th style="width:50%">Subtotal:</th>
                        <td>₹{{$total}}</td>
                      </tr>
                      <tr>
                        <th>Coupon Discount</th>
                        <td>₹{{$orderDetail[0]['getOrderDetail']['coupon_discount']}}</td>
                      </tr>
                      <tr>
                        <th>Payment Mode</th>
                        <td>@if($orderDetail[0]['getOrderDetail']['payment_gateway']==4)
                          Cash On Delivery
                          @if($orderDetail[0]['getOrderDetail']['payment_status']==0)
                          <span class="badge badge-secondary">Not paid</span>
                          @else
                          <span class="badge badge-success">paid</span>
                          @endif
                        @elseif($orderDetail[0]['getOrderDetail']['payment_gateway']==3)
                          Wallet
                        @else
                          Online
                        @endif</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>₹{{$orderDetail[0]['getOrderDetail']['grand_total']}}</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              {{-- <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                  <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                  </button>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                  </button>
                </div>
              </div> --}}
            </div>
         
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
<div id="orderstatus-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true" class="modal fade">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b>Change Order Status</b></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <form method="post" id="orderchangeform" action="javascript:">
        @csrf
          <div class="row">
            <div class="col-md-6 col-lg-6 mt-2">
              <label>change status</label>
                <div class=" d-flex ">
                  @foreach($array['purchase_status'] as $key => $ans )
                  <div class="ml-4">
                    <input type="checkbox" class="orderstatuscls" name="orderstatus" value="{{$key}}" id="status_{{$key}}" >  
                  </div>
                      &nbsp;&nbsp;{{$ans}}
                  @endforeach
                </div>
                <span class="m-3 text-danger" id="orderstatusErr" ></span>
              </div>
              
            </div>
            <!-- /.row-->
          <input type="hidden" name="orderdetIdHid" id="orderdetIdHid" value="0" >
          <p class="text-center">
            <button class="btn btn-primary" id="orderchangebtn" data-updateorderurl="{{route('orderupdate')}}"><i class="fa fa-sign-in"></i> Save</button>
          </p>
        </form>
        
      </div>
    </div>
  </div>
</div>
<div id="paymentstatus-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true" class="modal fade">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b>Change Payment Status</b></h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <form method="post" id="orderchangeform" action="javascript:">
        @csrf
            <div class="form-group">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="paystatus" name="paystatus" value="0">
                <label class="custom-control-label" for="paystatus">Payment Received</label>
              </div>
            </div>
            <!-- /.row-->
            <div class="form-group">
              <input type="hidden" name="orderIdHid" id="orderIdHid" value="{{$orderDetail[0]['order_id']}}" >
              <p class="text-center">
                <button class="btn btn-primary" id="paymentchangebtn" data-updateorderurl="{{route('paymentupdate')}}"><i class="fa fa-sign-in"></i> Save</button>
              </p>
            </div>
          </form>
        
      </div>
    </div>
  </div>
</div>
    
</section>
<!-- /.content -->

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="{{asset('assets/js/admin/orderview.js')}}"></script>
@endpush