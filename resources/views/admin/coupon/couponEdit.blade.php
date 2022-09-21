@extends('admin.layout.layoutbody')
@php
    $breadcrumbs = [['title' => 'Coupon List','route' =>route('couponList') ],['title' => 'Coupon Update','route' =>null ]];
@endphp
   

@section('maincontent')
@component('component.breadcrump',compact('breadcrumbs')) @endcomponent
<!-- Main content -->
<section class="content">
    <form method="post" id="couponform">
        @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Update</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="inputName">Coupon Code</label>
                        @php $disabled ='readonly'; @endphp
                        @if($curntdata->user_id==0)
                        @php $disabled =''; @endphp
                        @endif
                        <input type="text" name="coupon_code" id="coupon_code" class="form-control" value="{{$curntdata->coupon_code}}" {{$disabled}} >
                    </div>
                    <div class="col-md-4">
                        <label for="inputName">Coupon Amount <span id="coupontyperr" class="text-danger"></span></label>
                        <input type="text" name="coupon_amount" id="coupon_amount" class="form-control" value="{{$curntdata->coupon_amount}}">
                    </div>
                    <div class="col-md-4">
                        <label for="coupon_type">Coupon Type </label>
                        @php $array=(config('options')) @endphp
                        <select name="coupon_type" id="coupon_type" class="form-control custom-select">
                            <option selected disabled>Select one</option>
                            @foreach($array['coupon_type'] as $key => $ans )
                              @php $selected='' @endphp 
                              @if($curntdata->coupon_type==$key) @php $selected='selected' @endphp @endif
                              <option value="{{$key}}" {{$selected}} ><i class="fas {{$ans}}"></i>{{$ans}}</option>                           
                            @endforeach
                        </select>                        
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
          <input type="hidden" id="actionurl" data-href="{{route('couponupdate',$curntdata->id)}}">
          <input type="submit" value="Update" class="btn btn-success float-right">
        </div>
      </div>
    </form>
</section>
<!-- /.content -->

@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
const listurl="{{route('couponList')}}";
</script>
<script src="{{asset('assets/js/admin/couponform.js')}}"></script>

@endpush