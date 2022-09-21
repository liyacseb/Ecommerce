@extends('user.layouts.layoutbody')

@php
    $breadcrumbs = [['title' => 'Reset Password','route' =>null ]];
@endphp
   
@push('css')
@endpush
  
@section('maincontent')
  
   
           @component('user.layouts.breadcrump',compact('breadcrumbs')) @endcomponent  
            
            <div class="col-lg-12">
              <div class="box">
                <h1>Reset Password</h1>
                
                {{-- <p class="lead">Already our customer?</p>
                <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p> --}}
                <hr>
                <center><p class="text-danger">@if(session()->has('error')) {{session()->get('error')}} @endif</p></center>
                <form action="{{ route('user.reset.password.post') }}" method="post">
                  @csrf
                  <input type="hidden" name="token" value="{{ $token }}">
                  <div class="form-group">
                    <label for="email">Email <span class="text-danger">@if($errors->has('email')) {{$errors->first('email')}} @endif</span></label>
                    <input id="email" name="email" type="email" class="form-control" value="{{old('email')}}" required>
                  </div>
                  <div class="form-group">
                    <label for="password">Password <span class="text-danger">@if($errors->has('password')) {{$errors->first('password')}} @endif</span></label>
                    <input id="password" name="password" type="password" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="password">Password <span class="text-danger">@if($errors->has('confirmPassword')) {{$errors->first('confirmPassword')}} @endif</span></label>
                    <input id="confirmPassword" name="confirmPassword" type="password" class="form-control" required>
                  </div>
                   <div class="row">
                    <div class="col-6 text-left">
                      <a href="{{route('userlogin')}}">Back to login</a>
                    </div>
                    <div class="col-6 text-right">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Reset Password</button>
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
    <script>var baseurl = "{{url('/')}}";</script>
@endpush