@extends('user.layouts.layoutbody')

@php
    $breadcrumbs = [['title' => 'New Account','route' =>null ]];
@endphp
   
@push('css')
@endpush
  
@section('maincontent')
  
   
           @component('user.layouts.breadcrump',compact('breadcrumbs')) @endcomponent  
            <div class="col-lg-12">
              <div class="box">
                <h1>New account</h1>
                <p class="lead">Not our registered customer yet?</p>
                <p>With registration with us new world of fashion, fantastic discounts and much more opens to you! The whole process will not take you more than a minute!</p>
                {{-- <p class="text-muted">If you have any questions, please feel free to <a href="contact.html">contact us</a>, our customer service center is working for you 24/7.</p> --}}
                <hr>
                <form id="register" method="post">
                @csrf
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input id="name" name="name" type="text" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input id="email" name="email" type="email" class="form-control" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input id="password" name="password" type="password" class="form-control" required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="confpassword">Confirm Password</label>
                      <input id="confpassword" name="confirmPassword" type="password" class="form-control" required>
                    </div>
                  </div>
                </div>
                  <div class="row">
                    <div class="col-6 text-left">
                      <a href="{{route('userlogin')}}">Existing User ? Log in</a>
                    </div>
                    <div class="col-6 text-right">
                      <input type="hidden" name="actionurl" id="actionurl" data-href="{{route('registration')}}" >
                      <button type="submit" class="btn btn-primary"><i class="fa fa-user-md"></i> Register</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            
          
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="{{asset('assets/js/user/register.js')}}"></script>
@endpush