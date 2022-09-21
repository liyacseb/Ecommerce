@extends('user.layouts.layoutbody')

@php
    $breadcrumbs = [['title' => 'Sign In','route' =>route('userlogin') ],['title' => 'Forget Password','route' =>null ]];
@endphp
   
@push('css')
@endpush
  
@section('maincontent')
  
   
           @component('user.layouts.breadcrump',compact('breadcrumbs')) @endcomponent  
            
            <div class="col-lg-12">
              <div class="box">
                <h1>Forgot Password</h1>
                @if(session()->has('message'))
                    <div class="alert alert-success" role="alert">{{session()->get('message')}}</div>
                @endif
                {{-- <p class="lead">Already our customer?</p>
                <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p> --}}
                <hr>
                
                <form action="{{ route('user.forget.password.post') }}" method="post">
                  @csrf
                  <div class="form-group">
                    <label for="email">Email 
                    @if($errors->has('email'))
                        <span class="text-danger"> {{$errors->first('email')}}</span>
                    @endif
                    </label>
                    <input id="email" name="email" type="email" class="form-control" value="{{old('email')}}" required>
                  </div>
                  <div class="row">
                    <div class="col-6 text-left">
                      <a href="{{route('userlogin')}}">Back to login</a>
                    </div>
                    <div class="col-6 text-right">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Send Email Reset Link</button>
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