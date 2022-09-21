@extends('user.layouts.layoutbody')

@php
    $breadcrumbs = [['title' => 'Sign In','route' =>null ]];
@endphp
   
@push('css')
@endpush
  
@section('maincontent')
  
   
           @component('user.layouts.breadcrump',compact('breadcrumbs')) @endcomponent  
            
            <div class="col-lg-12">
              <div class="box">
                <h1>Login</h1>
                {{-- <p class="lead">Already our customer?</p>
                <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p> --}}
                <hr>
                {{-- <center><p class="text-danger">@if(session()->has('message')) {{session()->get('message')}} @endif</p></center> --}}
                @if(session()->has('message'))<div class="alert alert-success" role="alert">{{session()->get('message')}}</div>@endif
                @if(session()->has('error'))<div class="alert alert-danger" role="alert">{{session()->get('error')}}</div>@endif
                <form action="{{route('loginSubmit')}}" method="post">
                  @csrf
                  <div class="form-group">
                    <label for="email">Email <span class="text-danger">@if($errors->has('email')) {{$errors->first('email')}} @endif</span></label>
                    <input id="email" name="email" type="email" class="form-control" value="{{old('email')}}" required>
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" class="form-control" required>
                  </div>
                  <div class="row">
                    <div class="col-6 text-left " style="display:inline-grid">
                      <a href="{{route('user.forget.password.get')}}">Forgot Password</a>
                      <a href="{{route('register')}}">Not yet Registered ?</a>
                    </div>
                    <div class="col-6 text-right">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Log in</button>
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