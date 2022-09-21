@extends('admin.layout.layoutbody')
@php
    $breadcrumbs = [['title' => 'Change Password','route' =>null ]];
@endphp
   

@section('maincontent')
@component('component.breadcrump',compact('breadcrumbs')) @endcomponent
<!-- Main content -->
<section class="content">
    
    <form action="{{route('submitChangePassword')}}" id="chngpswdform" method="post">
    @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Change Password</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @if(session()->has('error'))
                        <span class="text-danger">{{session()->get('error')}}</span>
                    @endif
                    @if(session()->has('success'))
                        <span class="text-success">{{session()->get('success')}}</span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="oldpswd">Current Password
                        @if($errors->has('oldpswd'))
                        <span class="text-danger">{{$errors->first('oldpswd')}}</span>
                        @endif
                        </label>
                        <input type="password" id="oldpswd" name="oldpswd" class="form-control" value="{{old('oldpswd')}}">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="newpswd">New Password
                        @if($errors->has('newpswd'))
                        <span class="text-danger">{{$errors->first('newpswd')}}</span>
                        @endif
                        </label>
                        <input type="password" id="newpswd" name="newpswd" class="form-control" value="{{old('newpswd')}}">
                    </div>
                    <div class="col-md-6">
                        <label for="re-newpswd">Confirm New Password
                        @if($errors->has('re-newpswd'))
                        <span class="text-danger">{{$errors->first('re-newpswd')}}</span>
                        @endif
                        </label>
                        <input type="password" id="renewpswd" name="renewpswd" class="form-control" value="{{old('re-newpswd')}}">
                    </div>
                </div>
           
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
          <input type="submit" value="submit" class="btn btn-success float-right">
        </div>
      </div>
    </form>
</section>
<!-- /.content -->

@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
    $("#chngpswdform").validate({
        rules :{
            oldpswd : { required :true,} ,
            newpswd : {required : true, minlength:6},
            renewpswd : {required : true,equalTo:'#newpswd', minlength:6 },
        },
        messages: {
            oldpswd: {
                required: "Please enter current password",
            }, 
            newpswd: {
                required: "Please enter new password",
                minlength : "Password must be atleast six characters"
            }, 
            renewpswd: {
                required: "Please enter confirm password",
                minlength : "Password must be atleast six characters",
                equalTo : "Confirm Password must be same as new password"

            },
        },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form) {
                form.submit();
            }
        });
       
});
</script>
@endpush