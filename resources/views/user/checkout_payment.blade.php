@extends('user.layouts.layout')
@php
    $breadcrumbs = [['title' => 'Checkout Payment','route' =>null ]];
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
            <div id="checkout" class="col-lg-9">
              <div class="box">
                @php
                    $total = 0;
                    $discounttotal = 0;
                  @endphp
                  @foreach($cartdet as $cartval)
                    @php $offer = 0 @endphp
                    @if($cartval->getProduct['offer_price'])
                      @php 
                      $price= $cartval->getProduct['offer_price'];
                      $offer = $cartval->getProduct['actual_price'] - $cartval->getProduct['offer_price'] ;
                      @endphp                      
                    @else
                      @php $price= $cartval->getProduct['actual_price']; @endphp
                    @endif
                    @php 
                      $total=$total+($price*$cartval['prod_count']);
                      $discounttotal = $discounttotal+($offer*$cartval['prod_count']);
                    @endphp
                  @endforeach
                    @php 
                      $subtotal = $total+$discounttotal;
                      $total = $total-Session::get('couponVal');
                    @endphp
                <form method="post" id="checkoutpaymentform" action="{{route('checkoutpayment')}}">
                @csrf
                  <h1>Checkout - Payment method</h1>                  
                   
                  <div class="nav flex-column flex-sm-row nav-pills">
                  <a href="{{route('checkoutAddress')}}" class="nav-link flex-sm-fill text-sm-center"> <i class="fa fa-map-marker"></i>Address</a>
                  <a href="javascript:" class="nav-link flex-sm-fill text-sm-center active"> <i class="fa fa-money"></i>Payment Method</a>
                  <a href="javascript:" class="nav-link flex-sm-fill text-sm-center disabled"> <i class="fa fa-eye"></i>Order Preview</a>
                  </div>
                  <div class="content py-3">
                    <div class="row">
                        @php
                            $paymentID = 0;
                            if(Session::get('paymentID')){
                            $paymentID=Session::get('paymentID');
                            }
                             $checked1='';  $checked2='';   $checked3='';   $checked4='';
                        @endphp
                        @if($paymentID==1)
                            @php $checked1='checked'; @endphp
                        @endif
                        @if($paymentID==2)
                            @php $checked2='checked'; @endphp
                        @endif
                        @if($paymentID==3)
                            @php $checked3='checked'; @endphp
                        @endif
                        @if($paymentID==4)
                            @php $checked4='checked'; @endphp
                        @endif
                      <div class="col-md-6">
                        <div class="box payment-method" data-paymentMethod="1">
                          <h4>Razorpay</h4>
                          <p>We like it all.</p>
                          <div class="box-footer text-center">
                          
                            <input type="radio" class="payment" name="payment" value="1" {{$checked1}} >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="box payment-method" data-paymentMethod="2">
                          <h4>Stripe</h4>
                          <p>Foriegn Payment Gateway</p>
                          <div class="box-footer text-center">
                            <input type="radio" class="payment" name="payment" value="2" {{$checked2}}>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="box payment-method" data-paymentMethod="3">
                          <h4>Wallet</h4>
                          <p>Pay from your wallet balance</p>
                          <div class="box-footer text-center">
                            <input type="radio" class="payment" name="payment" value="3" {{$checked3}}>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="box payment-method" data-paymentMethod="4">
                          <h4>Cash on delivery</h4>
                          <p>You pay when you get it.</p>
                          <div class="box-footer text-center">
                            <input type="radio" class="payment" name="payment" value="4" {{$checked4}}>
                          </div>
                        </div>
                      </div>
                    </div>
                    @php $disabled = ''; $errorMsg=''; @endphp
                    @if($paymentID==3 && $walletAmount<$total)
                      @php $disabled = 'disabled';
                      $errorMsg ="You don't have enough wallet balance.please chose another payment method";
                       @endphp
                    @endif
                    <div class="row">
                      <div class="col-md-12 "> <center><b>
                      <p class="text-danger" id="paymentRequireErr">@if($errors->has('payment')) {{$errors->first('payment')}}  @endif {{$errorMsg}}</p>
                      </b></center></div>
                    </div>
                    <!-- /.row-->
                  </div>
                  @if(session()->has('paymentErrorMessage'))<div class="alert alert-danger" role="alert">{{session()->get('paymentErrorMessage')}}</div>@endif
                  <!-- /.content-->
                  <div class="box-footer d-flex justify-content-between">
                    <a href="{{route('checkoutAddress')}}" class="btn btn-outline-secondary"><i class="fa fa-chevron-left"></i>Back to Address</a>
                    <input type="hidden" name="grandtotal" id="grandtotal" value="{{round($total,2)}}" >
                    <input type="hidden" id="walletAmount" value="{{$walletAmount}}">
                      
                    <button type="submit" class="btn btn-primary" id="paymentbtn" {{$disabled}}>Continue to Order Review<i class="fa fa-chevron-right"></i></button>
                  </div>
                </form>
                <!-- /.box-->
              </div>
            </div>
            <!-- /.col-lg-9-->
            <div class="col-lg-3">
              <div id="order-summary" class="card">
                <div class="card-header">
                  <h3 class="mt-4 mb-4">Order summary</h3>
                </div>
                <div class="card-body">
                  {{-- <p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p> --}}
                  <div class="table-responsive">
                  
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>Order subtotal</td>
                          <th >₹{{(round($subtotal,2))}} </th>
                        </tr>
                        <tr>
                          <td>Discount</td>
                          <th >- ₹{{round($discounttotal,2)}} </th>
                        </tr>
                        <tr>
                          <td>Shipping and handling</td>
                          <th> &nbsp;&nbsp;₹00.00</th>
                        </tr>
                        <tr id="coupontr">
                          <td >Coupon</td>
                          <th >- ₹{{Session::get('couponVal')}}</th>
                        </tr>
                        <tr class="total">
                          <td>Total</td>
                          <th >₹{{round($total,2)}} </th>                        
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col-lg-3-->
          </div>
        </div>
      </div>
    </div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
  <script src="{{asset('assets/js/user/address.js')}}"></script>
@endpush