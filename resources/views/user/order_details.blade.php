@extends('user.layouts.layout')
@php
    $breadcrumbs = [['title' => 'My Orders','route' =>route('orders') ],['title' => 'Order # '.$orderdetails[0]['getOrderDetail']['id'],'route' =>null ]];
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
            <div id="customer-order" class="col-lg-9">
              <div class="box">
                <h1>Order #{{$orderdetails[0]['getOrderDetail']['id']}}</h1>
                <p class="lead">Order #{{$orderdetails[0]['getOrderDetail']['id']}} was placed on <strong>
                @php
                  $order_date = date_create($orderdetails[0]['getOrderDetail']['order_date']);                  
                @endphp
                {{date_format($order_date,'d/m/Y')}}
                </strong> .</p>
                {{-- <p class="text-muted">If you have any questions, please feel free to <a href="contact.html">contact us</a>, our customer service center is working for you 24/7.</p> --}}
                <hr>
                <div class="table-responsive mb-4">
                  <table class="table">
                    <thead>
                      <tr>
                        <th colspan="2">Product</th>
                        <th>Quantity</th>
                        <th>Unit price</th>
                        <th>Discount</th>
                        <th>Total</th>
                        <th>Purchase Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($orderdetails as $orderVal)
                      <tr>
                        <td><a href="{{route('detail',$orderVal['prod_id'])}}"><img src="{{asset('assets/product/'.$orderVal['cover_image'])}}" alt=" {{$orderVal['product_name']}} "></a></td>
                        <td><a href="{{route('detail',$orderVal['prod_id'])}}"> {{$orderVal['product_name']}} </a>
                        <br><span>Color : {{$orderVal->getColor['color']}} </span>
                        @if($orderVal->getSize)
                        <br><span>Size : {{$orderVal->getSize['size']}} </span>
                        @endif
                        </td>
                        <td> {{$orderVal['prod_count']}} </td>
                        <td>₹ {{$orderVal['actual_price']}} </td>
                        <td>@if($orderVal['offer_price'])
                          @php
                            $price = $orderVal['offer_price'];
                            $price = $price*$orderVal['prod_count'];
                            $discount=$orderVal['actual_price']-$orderVal['offer_price'];
                          @endphp
                          ₹ {{$discount}}
                          @else
                          @php
                            $price =  $orderVal['actual_price'];
                            $price =  ($price*$orderVal['prod_count']);
                          @endphp
                        @endif
                         </td>
                        <td>₹ {{$price}} </td>
                        <td>
                        @php $array=(config('options')) @endphp
                         @foreach($array['purchase_status'] as $key => $ans )
                            @if($key==$orderVal['order_status'])
                              {{$ans}}
                            @endif
                         @endforeach
                        </td>
                      </tr>
                    @endforeach
                      
                    </tbody>
                    <tfoot>
                    @if($orderdetails[0]['getOrderDetail']['coupon_discount'])
                      @php $total = $orderdetails[0]['getOrderDetail']['grand_total']+$orderdetails[0]['getOrderDetail']['coupon_discount']; @endphp
                    @else
                    @php $total = $orderdetails[0]['getOrderDetail']['grand_total'];  @endphp
                    @endif
                      <tr>
                        <th colspan="6" class="text-right">Order subtotal</th>
                        <th>₹ {{$total}} </th>
                      </tr>
                      <tr>
                        <th colspan="6" class="text-right">Coupon Discount</th>
                        <th>₹{{$orderdetails[0]['getOrderDetail']['coupon_discount']}}</th>
                      </tr>
                      <tr>
                        <th colspan="6" class="text-right">Payment Mode</th>
                        <th>
                        @if($orderdetails[0]['getOrderDetail']['payment_gateway']==4)
                          Cash On Delivery
                        @elseif($orderdetails[0]['getOrderDetail']['payment_gateway']==3)
                          Wallet
                        @else
                          Online
                        @endif
                        </th>
                      </tr>
                      <tr>
                        <th colspan="6" class="text-right">Total</th>
                        <th>₹ {{$orderdetails[0]['getOrderDetail']['grand_total']}} </th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.table-responsive-->
                <div class="row addresses">
                  <div class="col-lg-6">
                    {{-- <h2>Invoice address</h2>
                    <p>John Brown<br>13/25 New Avenue<br>New Heaven<br>45Y 73J<br>England<br>Great Britain</p> --}}
                  </div>
                  <div class="col-lg-6">
                    <h2>Shipping address</h2>
                    <p>{{$orderdetails[0]['getOrderDetail']['name']}}
                    @if($orderdetails[0]['getOrderDetail']['company'])
                      <br>Company  : {{$orderdetails[0]['getOrderDetail']['company']}}
                    @endif
                    <br>{{$orderdetails[0]['getOrderDetail']['adrs_line_1']}}, {{$orderdetails[0]['getOrderDetail']['adrs_line_2']}}<br>
                    {{$orderdetails[0]['getOrderDetail']['district']}}, {{$orderdetails[0]['getOrderDetail']['state']}}
                    <br>{{$orderdetails[0]['getOrderDetail']['country']}}<br>
                    Pincode : {{$orderdetails[0]['getOrderDetail']['pincode']}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
@push('js')
{{-- <script src="{{asset('assets/js/user/orders.js')}}"></script> --}}

@endpush