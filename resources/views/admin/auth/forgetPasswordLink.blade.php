<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Exam Portal | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="javascript:"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        @if(session()->has('message'))
        <div class="alert alert-success" role="alert">{{session()->get('message')}}</div>
        @endif
        @if(session()->has('error'))
        <div class="alert alert-danger" role="alert">{{session()->get('error')}}</div>
        @endif
        <form action="{{ route('reset.password.post') }}" method="POST">
                          @csrf
                          <input type="hidden" name="token" value="{{ $token }}">
            <div class="input-group">
                <label>Email</label>
                @if($errors->has('email'))
                    <span class="text-danger"> {{$errors->first('email')}}</span>
                @endif
            </div>
            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" required value="{{old('email')}}" placeholder="Email">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group">
                <label>Password</label>
                @if($errors->has('password'))
                    <span class="text-danger">{{$errors->first('password')}}</span>
                @endif
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" required value="{{old('password')}}" placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="input-group">
                <label>Confirm Password</label>
                @if($errors->has('password_confirmation'))
                    <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
                @endif
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password_confirmation" class="form-control" required value="{{old('password_confirmation')}}" placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-6 ">
              <a href="{{route('admin.login')}}">Back to login</a>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary">
                    Reset Password
                </button>
            </div>
            </div>
        </form>
      
     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
</body>
</html>
