@extends('user.layouts.layout')
@php
    $breadcrumbs = [['title' => 'Checkout Address','route' =>null ]];
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
            <div id="checkout" class="col-lg-9" >
              <div class="box">
                <form method="post" id="checkoutaddressform" action="{{route('checkoutaddress')}}">
                @csrf
                  <h1>Checkout - Address</h1>
                  <div class="nav flex-column flex-md-row nav-pills text-center">
                  <a href="javascript:" class="nav-link flex-sm-fill text-sm-center active"> <i class="fa fa-map-marker"></i>Address</a>
                  <a href="javascript:" class="nav-link flex-sm-fill text-sm-center disabled"> <i class="fa fa-money"></i>Payment Method</a>
                  <a href="javascript:" class="nav-link flex-sm-fill text-sm-center disabled"> <i class="fa fa-eye"></i>Order Preview</a>
                  </div>
                  <div class="content py-3">
                    
                    <div class="row addressbox">
                    @php
                      $addressID = 0;
                      if(Session::get('addressID')){
                        $addressID=Session::get('addressID');
                      }
                    @endphp
                    @foreach($addressDet as $addressvalue)   
                        @php $selected='selected'; @endphp     
                       @if($addressID==$addressvalue['id'])@php $selected='checked'; @endphp    @endif              
                      <div class="col-md-6 address-col-{{$addressvalue['id']}}">                      
                        <div class="box row addressdiv">
                          <div class="addressbox-left text-left col-2">
                            <input type="radio" {{$selected}} class="checkout_address" name="checkout_address" value="{{$addressvalue['id']}}">                            
                          </div>
                          <div class="col-8 ml-3" id="divaddressdet_{{$addressvalue['id']}}">
                            <h5 style="display:inline-flex">
                              <b>{{$addressvalue['name']}}</b>&nbsp;<span class="badge badge-secondary adrresstype">@if($addressvalue['adress_type']==0) Home @else Work @endif</span>
                              
                            </h5><br>
                            <b>{{$addressvalue['phone_number']}}</b><br>
                            <span>{{$addressvalue['adrs_line_1']}},{{$addressvalue['adrs_line_2']}}<br>
                            {{$addressvalue['district']}},{{$addressvalue['state']}}<br>{{$addressvalue['country']}}</span><br>
                            <span>{{$addressvalue['pincode']}}</span>
                          </div>
                          <div class="addressbox-right col-2">
                            <a class="text-info mt-2 editaddress" data-id="{{$addressvalue['id']}}" data-toggle="modal" data-target="#address-modal"><i class="fa fa-pencil" aria-hidden="true"></i></a>                        
                          </div>
                        
                        </div>
                      </div>
                    @endforeach                   
                      
                    </div>
                    
                    <div class="row">
                      <div class="col-md-6">                      
                        <div class="box payment-method row ">
                          <b><a class="text-info addaddress"  data-toggle="modal" data-target="#address-modal"><i class="fa fa-plus" aria-hidden="true"></i> Add New Address</a></b>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 "> <center><b><p class="text-danger" id="adrressRequireErr">@if($errors->has('checkout_address')) {{$errors->first('checkout_address')}} @endif</p></b></center></div>
                    </div>
                    <!-- /.row-->
                   
                  </div>
                  <div class="box-footer d-flex justify-content-between">
                    <a href="{{route('cart')}}" class="btn btn-outline-secondary"><i class="fa fa-chevron-left"></i>Back to Basket</a>
                                        
                    <button type="submit" class="btn btn-primary checkoutbtn">Continue <i class="fa fa-chevron-right"></i></button>
                  </div>
                </form>
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
                          {{-- <th >- ₹{{$couponVal}}</th> --}}
                          <th >- ₹{{Session::get('couponVal')}}</th>
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
    <div id="address-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true" class="modal fade">
          <div class="modal-dialog ">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><b>Address Form</b></h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body">
                <form method="post" id="addressform" action="javascript:" data-addaddressurl="{{route('address.store')}}" data-editaddressurl="{{route('address.update')}}">
                @csrf
                 <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="firstname">Name</label>
                          <input id="name" name="name" type="text" class="form-control adrresstags" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="phone_number">Phone Number</label>
                          <input id="phone_number" name="phone_number" type="text" class="form-control adrresstags" required>
                        </div>
                      </div>
                    </div>
                    <!-- /.row-->
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="adrs_line_1">Address Line 1</label>
                          <input id="adrs_line_1" name="adrs_line_1" type="text" class="form-control adrresstags" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="adrs_line_2">Address Line 2</label>
                          <input id="adrs_line_2" name="adrs_line_2" type="text" class="form-control adrresstags" required>
                        </div>
                      </div>
                    </div>
                    <!-- /.row-->
                    <div class="row">
                      
                      <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                          <label for="company">Company</label>
                          <input id="company" name="company" type="text" class="form-control adrresstags">
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                          <label for="zip">ZIP</label>
                          <input id="zip" name="zip" type="text" class="form-control adrresstags" required>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                          <label for="district">District</label>
                          <input id="district" name="district" class="form-control adrresstags" required>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                          <label for="state">State</label>
                          <input id="state" name="state" class="form-control adrresstags" required>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                          <label for="country">Country</label>
                          <input id="country" name="country" class="form-control adrresstags" required>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-6 mt-2" >
                        <label>Address Type</label>
                        <div class=" d-flex ">
                          <div class="">
                            <input type="radio" name="addressType" value="0" required> 
                            <label for="">Home</label> 
                          </div>
                          <div class="ml-4">
                            <input type="radio" name="addressType" value="1" required>  
                            <label for="">Work</label>
                          </div>
                        </div>
                        <span class="mt-1" id="addressTypeErr" ></span>
                      </div>
                    </div>
                    <!-- /.row-->
                  <input type="hidden" name="adderssIdHid" id="adderssIdHid" value="0" >
                  <p class="text-center">
                    <button class="btn btn-primary"><i class="fa fa-sign-in"></i> Save</button>
                  </p>
                </form>
                
              </div>
            </div>
          </div>
        </div>
    @endsection
@push('js')
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
  <script src="{{asset('assets/js/user/address.js')}}"></script>
@endpush