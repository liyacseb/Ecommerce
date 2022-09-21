@extends('user.layouts.layoutbody')

@php
    $breadcrumbs = [['title' => 'Change Password','route' =>null ]];
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
                <p class="lead">Change your password here.</p>
                {{-- <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p> --}}
                <h3>Change password</h3>
                <div class="alert alert-success divSuccess" style="display:none;" role="alert">Successfully updated the password</div>
                <div class="alert alert-danger divError" style="display:none;" role="alert">Current password is not same</div>
                <form method="post" id="changepswdform">
                @csrf
                    <input type="hidden" id="actionurl" data-href="{{route('user.submitChangePassword')}}">
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_old">Old password</label>
                            <input id="password_old" type="password" name="oldPassword" class="form-control">
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">New password</label>
                            <input id="password" type="password" name="password" class="form-control">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_2">Retype new password</label>
                            <input id="password_2" type="password" name="confirmPassword" class="form-control">
                        </div>
                        </div>
                    </div>
                    <!-- /.row-->
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save new password</button>
                    </div>
                </form>
                
              </div>
            </div>
          @endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="{{asset('assets/js/user/changepassword.js')}}"></script>
@endpush