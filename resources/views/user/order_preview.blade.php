@extends('user.layouts.layout')
@php
    $breadcrumbs = [['title' => 'Order Preview','route' =>null ]];
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
                
                  <h1>Checkout - Order review</h1>
                  <div class="nav flex-column flex-sm-row nav-pills">
                  <a href="{{route('checkoutAddress')}}" class="nav-link flex-sm-fill text-sm-center"> <i class="fa fa-map-marker"></i>Address</a>
                  <a href="{{route('paymentform')}}" class="nav-link flex-sm-fill text-sm-center"> <i class="fa fa-money"></i>Payment Method</a>
                  <a href="javascript" class="nav-link flex-sm-fill text-sm-center active"> <i class="fa fa-eye"></i>Order Preview</a>
                  </div>
                  <div class="content">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th colspan="2" >Product</th>
                            <th>Unit price</th>
                            <th>Quantity</th>
                            {{-- <th>Discount</th> --}}
                            <th >Total</th>
                          </tr>
                        </thead>
                        <tbody>
                           @php
                                $total = 0;
                                $discounttotal = 0;
                            @endphp
                            @foreach($cartdet as $val)
                                @php $offer = 0 @endphp
                               
                                <tr>
                                    <td><a href="{{route('detail',$val->getProduct['id'])}}"><img src="{{asset('assets/product/'.$val->getProduct['cover_image'])}}" alt="{{$val->getProduct['product_name']}}"></a></td>
                                    <td><a href="{{route('detail',$val->getProduct['id'])}}">{{$val->getProduct['product_name']}}</a>
                                    <br><span ><i>Color:{{$val->getProdColor['color']}}</i></span>
                                     @if($val['size_id']) <br><span><i>Size: {{$val->getProdSize['size']}} </i></span> @endif
                                    </td>
                                    @if($val->getProduct['offer_price'])
                                        @php 
                                            $price= $val->getProduct['offer_price'];
                                            $offer = $val->getProduct['actual_price'] - $val->getProduct['offer_price'] ;
                                        @endphp    
                                        <td>₹{{$val->getProduct['offer_price']}} <small><strike>₹{{$val->getProduct['actual_price']}}</strike> </small></td>                  
                                    @else
                                        @php $price= $val->getProduct['actual_price']; @endphp
                                        <td>₹{{$val->getProduct['actual_price']}}</td>
                                    @endif
                                    @php 
                                        $total=$total+($price*$val['prod_count']);
                                        $discounttotal = $discounttotal+($offer*$val['prod_count']);
                                    @endphp
                                    <td>{{$val['prod_count']}}</td>
                                    <td>₹{{$price*$val['prod_count']}}</td>
                                </tr>
                            @endforeach
                            @php 
                                $subtotal = $total+$discounttotal;
                                $total = $total-Session::get('couponVal');
                            @endphp
                        </tbody>
                        
                      </table>
                    </div>
                    <!-- /.table-responsive-->
                  </div>
                  <!-- /.content-->
                  <div class="box-footer d-flex justify-content-between">
                    <a href="{{route('paymentform')}}" class="btn btn-outline-secondary"><i class="fa fa-chevron-left"></i>Back to payment method</a>
                    @php
                      $paymentMethod=Session::get('paymentMethod');
                    @endphp
                          @php $grandtotal=Session::get('grandtotal'); @endphp
                          <input type="hidden" id="grandtotal" value="{{$grandtotal}}" >
                    @if($paymentMethod==1)
                        @php $payMethod = 'Razorpay';  @endphp
                     <form data-razorpayurl="{{ route('razorpay.payment.store') }}" id="razorpayform" method="POST" >
                        @csrf
                        {{-- <script src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="{{ env('RAZORPAY_KEY') }}"
                                data-amount="1000"
                                data-buttontext="Pay 10 INR"
                                data-name="webandcrafts.com"
                                data-description="Rozerpay"
                                data-image="https://www.itsolutionstuff.com/frontTheme/images/logo.png"
                                data-prefill.name="name"
                                data-prefill.email="email"
                                data-theme.color="#ff7529">
                        </script> --}}
                          {{-- @php $grandtotal=Session::get('grandtotal'); @endphp --}}
                          <input type="hidden" id="rzpKey" value="{{$razorpayKey}}" >
                          <input type="hidden" id="razorpayOrder" value="{{Session::get('razorpayOrder')}}" >
                          {{-- <input type="hidden" id="grandtotal" value="{{$grandtotal}}" > --}}
                          <input type="hidden" id="username" value="{{Auth::guard('user')->user()->name}}" >
                          <input type="hidden" id="useremail" value="{{Auth::guard('user')->user()->email}}" >
                          <button type="submit" id="rzp-button1" class="btn btn-primary">Place an order<i class="fa fa-chevron-right"></i></button>
                    </form>
                      @elseif($paymentMethod==2)
                        @php $payMethod = 'Stripe';  @endphp
                          <input type="hidden" id="stripeKey" value="{{$stripeKey}}" >
                        <button class="btn btn-primary " id="stripe-button1" data-stripeurl="{{ route('stripe.payment.process') }}">Place an order </button>
                      @elseif($paymentMethod==3)
                        @php $payMethod = 'Wallet';  @endphp
                         <form data-walleturl="{{ route('wallet.payment.process') }}" id="walletform" method="POST" >
                          @csrf
                          <button class="btn btn-primary " id="wallet-button1" >Place an order </button>
                        </form>
                      @elseif($paymentMethod==4)
                        @php $payMethod = 'Cash On Delivery';  @endphp
                      <form data-codurl="{{ route('cod.order.store') }}" id="codform" method="POST" >
                        @csrf
                        {{-- <script src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="{{ env('RAZORPAY_KEY') }}"
                                data-amount="1000"
                                data-buttontext="Pay 10 INR"
                                data-name="webandcrafts.com"
                                data-description="Rozerpay"
                                data-image="https://www.itsolutionstuff.com/frontTheme/images/logo.png"
                                data-prefill.name="name"
                                data-prefill.email="email"
                                data-theme.color="#ff7529">
                        </script> --}}
                          <button type="submit" id="cod-button" class="btn btn-primary">Place an order<i class="fa fa-chevron-right"></i></button>
                    </form>
                      @endif

                  </div>
                
              </div>
              <!-- /.box-->
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
                          <th >₹{{(number_format($subtotal,2))}} </th>
                        </tr>
                        <tr>
                          <td>Discount</td>
                          <th >- ₹{{number_format($discounttotal,2)}} </th>
                        </tr>
                        <tr>
                          <td>Shipping and handling</td>
                          <th> &nbsp;&nbsp;₹00.00</th>
                        </tr>
                        <tr id="coupontr">
                          <td >Coupon</td>
                          <th >- ₹{{Session::get('couponVal')}}</th>
                        </tr>
                        <tr id="coupontr">
                          <td >Payment Method</td>
                          <th > {{$payMethod}} </th>
                        </tr>
                        <tr class="total">
                          <td>Total</td>
                          <th >₹{{number_format($total,2)}} </th>                        
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
    <!-- Modal -->
    
<input type="hidden" id="orderurl" data-orderurl="{{route('orders')}}">
 <div id="orderModal" tabindex="-1" role="dialog"  aria-hidden="true" class="modal">
    <div class="modal-dialog ">
      <div class="modal-content">
        {{-- <div class="modal-header">
          <h5 class="modal-title"><b>Address Form</b></h5>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div> --}}
        <div class="modal-body" id="orderModalBody">
        
      </div>
    </div>
  </div>
    

    
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="{{asset('assets/js/user/payment.js')}}"></script>
@if($paymentMethod==1)
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@elseif($paymentMethod==2)
  <script src = "https://checkout.stripe.com/checkout.js" > </script> 
@endif
@endpush
