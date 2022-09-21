@extends('user.layouts.layoutbody')

@php
    $breadcrumbs = [['title' => 'My Account','route' =>null ]];
@endphp
   
@push('css')
@endpush
  
@section('maincontent')
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
            <div class="col-lg-9">
              <div class="box">
                <h1>My account</h1>
                <p class="lead">Change your personal details here.</p>
                {{-- <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p> --}}
                <div class="alert alert-success divSuccess" style="display:none;" role="alert">Succesfully Updated</div>
                <div class="alert alert-danger divDanger" style="display:none;" role="alert">Can't Updated</div>
                <h3 class="mt-5">Personal details</h3>
                <form id="profileForm" method="post">
                   @csrf
                    <input type="hidden" id="actionurl" data-href="{{route('profileUpdate')}}">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="firstname">Name</label>
                        <input id="firstname" type="text" name="name" id="name" class="form-control" value="{{Auth::guard('user')->user()->name}}">
                      </div>
                    </div>
                     <div class="col-md-6">
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="text" readonly name="email" id="email" class="form-control" value="{{Auth::guard('user')->user()->email}}">
                      </div>
                    </div>
                  </div>
                  <!-- /.row-->
                  <div class="row">
                     <div class="col-md-6">
                      <div class="form-group">
                        <label for="phone">Mobile Number</label>
                        <input id="phone" type="text" class="form-control" name="mob" value="{{Auth::guard('user')->user()->phone_number}}">
                      </div>
                    </div>
                    <div class="col-md-6 mt-4">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                    </div>
                  </div>
                    
                  </div>
                </form>
                <div class="box">
                  <h1>Manage Wallet Amount</h1>
                  <p class="lead"><strong>₹{{$wallet[0]['wallet_amount']}}</strong> is your wallet balance</p>
                  <form method="get" id="addwalletform" data-orderaction="{{route('walletrazorpayordercreation')}}" data-paymentaction="{{route('addwallet')}}" data-paymentfailedaction="{{route('walletaddfailed')}}">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="wallet">Wallet Amount <span class="text-danger" id="walletErr"></span></label>
                          <input id="wallet" type="text" name="wallet" class="form-control" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                          <input type="hidden" id="rzpKey" value="{{config('paymentcredentials.razor.key')}}" >
                        <button type="submit" id="addwalletbtn" class="btn btn-primary mt-4"><i class="fa fa-plus"></i> Add money</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              
            </div>
           
<!-- The actual snackbar -->
<div id="snackbar">Some text some message..</div>
          @endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="{{asset('assets/js/user/profileForm.js')}}"></script>
@endpush