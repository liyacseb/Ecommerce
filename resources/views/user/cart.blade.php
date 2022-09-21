@extends('user.layouts.layout')
@php
    $breadcrumbs = [['title' => 'Shopping Cart','route' =>null ]];
@endphp
@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  
<style>
.prodCount{
  width:71px !important;
}
</style>
@endpush
@section('maincontent')
    <div id="all">
      <div id="content">
        <div class="container">
          <div class="row">
            @component('user.layouts.breadcrump',compact('breadcrumbs')) @endcomponent
            <div id="basket" class="col-lg-8">
              <div class="box">
                <form method="post" action="{{route('checkout')}}">
                @csrf
                  <h1>Shopping cart</h1>
                  <p class="text-muted">You currently have {{count($data)}} item(s) in your cart.</p>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th colspan="2">Product</th>
                          <th>Unit price</th>
                          <th>Quantity</th>
                          {{-- <th>Discount</th> --}}
                          <th colspan="2">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                      @php $grandtotal =0; $discounttotal =0; $actualprice =0; @endphp
                      @php $cartary=[]; @endphp
                      @foreach($data as $val)
                      @if($val->getProduct!=null)
                        <tr>
                          <td><a href="{{route('detail',$val->getProduct['id'])}}"><img src="{{asset('assets/product/'.$val->getProduct['cover_image'])}}" alt="{{$val->getProduct['product_name']}}"></a></td>
                          <td><a href="{{route('detail',$val->getProduct['id'])}}">{{$val->getProduct['product_name']}}</a>
                          
                          <br><span ><i>Color:{{$val->getProdColor['color']}}</i></span>
                          @if($val['size_id']) <br><span><i>Size: {{$val->getProdSize['size']}} </i></span> @endif
                          </td>
                          <td>
                          @if($val->getProduct['offer_price'])
                            @php $price= $val->getProduct['offer_price'] @endphp
                             ₹{{$val->getProduct['offer_price']}} <small><strike>₹{{$val->getProduct['actual_price']}}</strike> </small>
                            
                          @else
                            @php $price= $val->getProduct['actual_price'] @endphp
                              ₹{{$val->getProduct['actual_price']}}
                            
                          @endif
                          </td>
                          <td>
                            @php $disabled=''; $stock=0; @endphp
                            @if($val->getStock==null || $val->getStock['stock']==0 || $val->getProduct['status']==0)
                              @php $disabled='disabled'; $stock=0; @endphp
                            @else
                              @php $stock=$val->getStock['stock']; @endphp
                            @endif
                            @php $offer = 0 @endphp
                            @if($val->getProduct['offer_price']) 
                              @php $offer = $val->getProduct['actual_price'] - $val->getProduct['offer_price'] @endphp 
                            @endif
                            <input type="number" id="number_{{$val['id']}}" value="{{$val['prod_count']}}" {{$disabled}} min="1" class="form-control prodCount" data-stock="{{$stock}}" 
                            data-cartID="{{$val['id']}}" data-perPrice="{{$price}}" data-offerPrice="{{$offer}}">
                            @if($val->getProduct['status']==0) 
                              <span class="badge badge-danger">Not Available</span>
                            @else
                              @if($stock==0)
                                <span class="text-danger"><b>Out of stock</b></span>
                              @elseif( $val['prod_count']>$stock)
                                <span class="text-danger"><b>Only {{$stock}} left</b></span>
                              @endif
                            @endif
                          </td>
                           
                          {{-- <td>₹{{number_format($offer,2)}}</td> --}}
                          @php 
                            $total = $price*$val['prod_count'];
                          @endphp
                          @if($stock!=0 && $val['prod_count']<=$stock)
                            @php 
                            $grandtotal = $grandtotal+$total;
                            $discounttotal = $discounttotal+($offer*$val['prod_count']);
                            $actualprice = $actualprice+($val->getProduct['actual_price']*$val['prod_count']); 
                            $cartary[] = $val['id'];
                            @endphp
                          @endif
                          
                          
                          <td id="total_{{$val['id']}}">₹{{number_format($total,2)}}</td>
                          <td><a href="javascript:" class="removeCart" data-href="{{route('deletecart',$val['id'])}}"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
                      @endif
                      @endforeach  
                      @if(count($data)==0)
                        <tr>
                        <td colspan="6"><center class="text-danger"><strong>Empty cart</strong></center></td>
                        </tr>
                      @endif
                      </tbody>
                      {{-- <tfoot>
                        <tr>
                          <th colspan="4">Total</th>
                          <th colspan="2" >₹{{number_format($grandtotal,2)}}</th>
                        </tr>
                      </tfoot> --}}
                    </table>
                  </div>
                  <!-- /.table-responsive-->
                  <div class="box-footer d-flex justify-content-between flex-column flex-lg-row">
                    <div class="left"><a href="{{route('productlist')}}" class="btn btn-outline-secondary"><i class="fa fa-chevron-left"></i> Continue shopping</a></div>
                    <div class="right">
                      <input type="hidden" id="couponHid" name="couponHid" value="0">
                      <input type="hidden" id="couponIdHid" name="couponIdHid" value="0">
                      <input type="hidden" id="couponAmount" name="couponAmount" value="0">
                      <input type="hidden" id="couponType" name="couponType" value="%">
                      <input type="hidden" id="hidCartId" name="hidCartId" value="{{implode(',',$cartary)}}">
                      <a href="{{route('cart')}}" class="btn btn-outline-secondary" ><i class="fa fa-refresh"></i> Update cart</a>
                      @if(count($data)>0 && $grandtotal!='0.00') <button type="submit" name="checkout" class="btn btn-primary">Proceed to checkout <i class="fa fa-chevron-right"></i></button>@endif
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.box-->
              {{-- <div class="row same-height-row">
                <div class="col-lg-3 col-md-6">
                  <div class="box same-height">
                    <h3>You may also like these products</h3>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="product same-height">
                    <div class="flip-container">
                      <div class="flipper">
                        <div class="front"><a href="detail.html"><img src="img/product2.jpg" alt="" class="img-fluid"></a></div>
                        <div class="back"><a href="detail.html"><img src="img/product2_2.jpg" alt="" class="img-fluid"></a></div>
                      </div>
                    </div><a href="detail.html" class="invisible"><img src="img/product2.jpg" alt="" class="img-fluid"></a>
                    <div class="text">
                      <h3>Fur coat</h3>
                      <p class="price">₹143</p>
                    </div>
                  </div>
                  <!-- /.product-->
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="product same-height">
                    <div class="flip-container">
                      <div class="flipper">
                        <div class="front"><a href="detail.html"><img src="img/product1.jpg" alt="" class="img-fluid"></a></div>
                        <div class="back"><a href="detail.html"><img src="img/product1_2.jpg" alt="" class="img-fluid"></a></div>
                      </div>
                    </div><a href="detail.html" class="invisible"><img src="img/product1.jpg" alt="" class="img-fluid"></a>
                    <div class="text">
                      <h3>Fur coat</h3>
                      <p class="price">₹143</p>
                    </div>
                  </div>
                  <!-- /.product-->
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="product same-height">
                    <div class="flip-container">
                      <div class="flipper">
                        <div class="front"><a href="detail.html"><img src="img/product3.jpg" alt="" class="img-fluid"></a></div>
                        <div class="back"><a href="detail.html"><img src="img/product3_2.jpg" alt="" class="img-fluid"></a></div>
                      </div>
                    </div><a href="detail.html" class="invisible"><img src="img/product3.jpg" alt="" class="img-fluid"></a>
                    <div class="text">
                      <h3>Fur coat</h3>
                      <p class="price">₹4143</p>
                    </div>
                  </div>
                  <!-- /.product-->
                </div>
              </div> --}}
            </div>
            <!-- /.col-lg-8-->
            <div class="col-lg-4">
              <div id="order-summary" class="box">
                <div class="box-header">
                  <h3 class="mb-0">Order summary</h3>
                </div>
                {{-- <p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p> --}}
                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>Order subtotal</td>
                        <th id="subtotal"> &nbsp;&nbsp;₹{{number_format($actualprice,2)}}</th>
                      </tr>
                      <tr>
                        <td>Discount</td>
                        <th id="discount_total">- ₹{{number_format($discounttotal,2)}}</th>
                      </tr>
                      <tr>
                        <td>Shipping and handling</td>
                        <th> &nbsp;&nbsp;₹00.00</th>
                      </tr>
                      <tr id="coupontr">
                        <td >Coupon
                        <p id="couponapplied"></p>
                        </td>
                        <th id="coupon_th">- ₹0.00</th>
                      </tr>
                      <tr class="total">
                        <td>Total</td>
                        <th id="grandtotal_th">₹{{number_format($grandtotal,2)}}                        
                        </th>
                        
                      </tr>
                    </tbody>
                  </table>
                  <input type="hidden" id="grandtotalHid" value="{{$grandtotal}}">
                  
                </div>
              </div>
              <div class="box">
                <div class="box-header">
                  <h4 class="mb-0">Coupon code</h4>
                </div>
                <p class="text-muted">If you have a coupon code, please enter it in the box below.</p>
                <form id="couponForm" method="POST" data-href="{{route('couponapply')}}">
                  <span id="couponErr"></span>
                  <div class="input-group">
                    <input type="text" name="coupon" id="coupon" class="form-control"><span class="input-group-append">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-gift"></i></button></span>
                  </div>
                  <!-- /input-group-->
                </form>
              </div>
            </div>
            <!-- /.col-md-4-->
          </div>
        </div>
      </div>
    </div>
<!-- The actual snackbar -->
<div id="snackbar">Some text some message..</div>
   @endsection
@push('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
  <script src="{{asset('assets/js/user/cart.js')}}"></script>
@endpush