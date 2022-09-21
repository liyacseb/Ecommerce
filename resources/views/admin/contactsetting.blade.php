@extends('admin.layout.layoutbody')
@php
    $breadcrumbs = [['title' => 'Website Setting','route' =>null ]];
@endphp
   
@push('css')
<!------ crop image Start ------->
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> --}}
  <link rel="stylesheet" href="https://foliotek.github.io/Croppie/croppie.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!------ crop image End ------->
<style>
#upload-demo{
	width: 250px;
	height: 250px;
  padding-bottom:25px;
}
.fade:not(.show) {
    opacity: 1;
}
</style> 
@endpush

@section('maincontent')
@component('component.breadcrump',compact('breadcrumbs')) @endcomponent
<!-- Main content -->
<section class="content">
    <form action="{{route('submitwebsitesetting')}}" id="websiteform" method="post" enctype="multipart/form-data" >
    @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Website Setting</h3>

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
                        <label for="websitename">Website Name
                        @php $name=$contactDet[0]['website_name']; @endphp
                        @if($errors->has('websitename'))
                        <span class="text-danger">{{$errors->first('websitename')}}</span>
                        @php $name=old('websitename') @endphp
                        @endif
                        </label>
                        <input type="text" id="websitename" name="websitename" class="form-control" value="{{$name}}" required>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating mb-3">
                      <label>Cover Image *</label>
                      <input class="image"  id="logo" type="file" name="logo" accept="image/png, image/jpeg, image/jpg"   />
                      @if($errors->has('cover_image'))
                        <span class="text-danger">{{$errors->first('cover_image')}}</span>
                        @endif
                         @php $imgUrl = asset('assets/product/noimage.jpg') @endphp  
                      @if($contactDet[0]['website_logo'])  @php $imgUrl = asset('assets/dist/img/'.$contactDet[0]['website_logo']) @endphp  @endif                 
                      <img id="logo_upload" src="{{$imgUrl}}" alt="preview image" style="height: 60px; width:93px;">
                      <input type="hidden" name="logo_upload" class="logo_upload">
                      </div>
                    </div>  
                    
                      
                </div>
                <h5 class="mt-4">Address </h5>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="adrs_line_1">Address Line 1
                        @php $adrs_line_1=$contactDet[0]['adrs_line_1']; @endphp
                        @if($errors->has('adrs_line_1'))
                        <span class="text-danger">{{$errors->first('adrs_line_1')}}</span>
                        @php $adrs_line_1=old('adrs_line_1') @endphp
                        @endif
                        </label>
                        <input type="text" id="adrs_line_1" name="adrs_line_1" class="form-control" value="{{$adrs_line_1}}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="adrs_line_2">Address Line 2
                        @php $adrs_line_2=$contactDet[0]['adrs_line_2']; @endphp
                        @if($errors->has('adrs_line_2'))
                        <span class="text-danger">{{$errors->first('adrs_line_2')}}</span>
                        @php $adrs_line_2=old('adrs_line_2') @endphp
                        @endif
                        </label>
                        <input type="text" id="adrs_line_2" name="adrs_line_2" class="form-control" value="{{$adrs_line_2}}">
                    </div>
                    <div class="col-md-6">
                        <label for="pincode">Pincode
                        @php $pincode=$contactDet[0]['pincode']; @endphp
                        @if($errors->has('pincode'))
                        <span class="text-danger">{{$errors->first('pincode')}}</span>
                        @php $pincode=old('pincode') @endphp
                        @endif
                        </label>
                        <input type="text" id="pincode" name="pincode" class="form-control" value="{{$pincode}}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="district">District
                        @php $district=$contactDet[0]['district']; @endphp
                        @if($errors->has('district'))
                        <span class="text-danger">{{$errors->first('district')}}</span>
                        @php $district=old('district') @endphp
                        @endif
                        </label>
                        <input type="text" id="district" name="district" class="form-control" value="{{$district}}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="state">State
                        @php $state=$contactDet[0]['state']; @endphp
                        @if($errors->has('state'))
                        <span class="text-danger">{{$errors->first('state')}}</span>
                        @php $state=old('state') @endphp
                        @endif
                        </label>
                        <input type="text" id="state" name="state" class="form-control" value="{{$state}}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="country">Country
                        @php $country=$contactDet[0]['country']; @endphp
                        @if($errors->has('country'))
                        <span class="text-danger">{{$errors->first('country')}}</span>
                        @php $country=old('country') @endphp
                        @endif
                        </label>
                        <input type="text" id="country" name="country" class="form-control" value="{{$country}}" required>
                    </div>
                </div>
                <h5 class="mt-4">Social Media Links </h5>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="fb_link">Facebook Link
                        @php $fb_link=$contactDet[0]['fb_link']; @endphp
                        @if($errors->has('fb_link'))
                        <span class="text-danger">{{$errors->first('fb_link')}}</span>
                        @php $fb_link=old('fb_link') @endphp
                        @endif
                        </label>
                        <input type="text" id="fb_link" name="fb_link" class="form-control" value="{{$fb_link}}">
                    </div>
                    <div class="col-md-6">
                        <label for="twitter_link">Twitter Link
                        @php $twitter_link=$contactDet[0]['twitter_link']; @endphp
                        @if($errors->has('twitter_link'))
                        <span class="text-danger">{{$errors->first('twitter_link')}}</span>
                        @php $twitter_link=old('twitter_link') @endphp
                        @endif
                        </label>
                        <input type="text" id="twitter_link" name="twitter_link" class="form-control" value="{{$twitter_link}}">
                    </div>
                    <div class="col-md-6">
                        <label for="insta_link">Insta Link
                        @php $insta_link=$contactDet[0]['insta_link']; @endphp
                        @if($errors->has('insta_link'))
                        <span class="text-danger">{{$errors->first('insta_link')}}</span>
                        @php $insta_link=old('insta_link') @endphp
                        @endif
                        </label>
                        <input type="text" id="insta_link" name="insta_link" class="form-control" value="{{$insta_link}}">
                    </div>
                    <div class="col-md-6">
                        <label for="gmail_link">Gmail Link
                        @php $gmail_link=$contactDet[0]['gmail_link']; @endphp
                        @if($errors->has('gmail_link'))
                        <span class="text-danger">{{$errors->first('gmail_link')}}</span>
                        @php $gmail_link=old('gmail_link') @endphp
                        @endif
                        </label>
                        <input type="text" id="gmail_link" name="gmail_link" class="form-control" value="{{$gmail_link}}" required>
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
    <div class="modal fade " id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close modalClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">
              </div>
              <div class="modal-body">
                  <div id="upload-demo" class="center-block"></div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default modalClose" data-dismiss="modal">Close</button>
                  <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
              </div>
          </div>
      </div>
    </div>
</section>
<!-- /.content -->

@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
  <script src="https://foliotek.github.io/Croppie/croppie.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
var $uploadCrop,
tempFilename,
rawImg,
imageId;
$uploadCrop = $('#upload-demo').croppie({
    viewport: {
        width: 139,
        height: 60,
    },
    enforceBoundary: false,
    enableExif: true
});
function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.upload-demo').addClass('ready');
             $('#cropImagePop').modal('show');
             //$('#cropImagePop').removeClass('fade');
            // $('#cropImagePop').css('display','block');
            rawImg = e.target.result;
            $uploadCrop.croppie('bind', {
                url: rawImg
            }).then(function(){
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(input.files[0]);
    }
    else {
        alert("Sorry - you're browser doesn't support the FileReader API");
    }
}
$('.image').on('change', function () { 
    tempFilename = $(this).val();
    readFile(this); 
});
$('#cropImageBtn').on('click', function (ev) {
    $uploadCrop.croppie('result', {
        type: 'base64',
        format: 'jpeg',
        size: {width: 139, height: 60}
    }).then(function (resp) {
        $('#logo_upload').attr('src', resp);
        $('.logo_upload').val(resp);
        $('#cropImagePop').modal('hide');
    });
  $('#logo').val('');
});
$('.modalClose').click(function(){
  $('#logo').val('');
});
</script>
<script>
$(document).ready(function() {
    $("#websiteform").validate({
        rules :{
            websitename : { required :true, minlength:2} ,
            adrs_line_1 : {required : true, minlength:6},
            district : {
                required : true,
                minlength:2 },
            state : {
                required : true,
                minlength:2 },
            country : {
                required : true,
                minlength:2 },
        },
        messages: {
            websitename: {
                required: "Please enter website name",
            }, 
            adrs_line_1: {
                required: "Please enter new password",
                minlength : "Address must be atleast 2 characters"
            }, 
            district: {
                required: "Please enter district",
                minlength : "District must be atleast 2 characters"
            },
            state: {
                required: "Please enter state",
                minlength : "State must be atleast 2 characters"
            },
            country: {
                required: "Please enter country",
                minlength : "Country must be atleast 2 characters"
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