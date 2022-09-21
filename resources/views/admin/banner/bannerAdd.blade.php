@extends('admin.layout.layoutbody')
@php
    $breadcrumbs = [['title' => 'Banner List','route' =>route('bannerList') ],['title' => 'Banner Add','route' =>null ]];
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
    <form method="post" id="bannerform" enctype="multipart/form-data">
        @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                  <label>Banner Image *
                    <span class="text-danger" id="bannerErr"></span></label><br>
                  <input class="image"  id="banner_img" type="file" name="banner_img" accept="image/png, image/jpeg, image/jpg"   />                    
                  <input type="hidden" name="banner_upload" class="banner_upload hiddenclass">
                  </div>
                </div>  
                @php $array=(config('options')) @endphp
                
                <div class="col-md-6">
                  <label for="status">Status </label>
                  <select name="status" class="form-control custom-select">
                      <option selected disabled>Select one</option>
                    @foreach($array['status'] as $key => $ans )
                      <option value="{{$key}}" ><i class="fas {{$ans}}"></i>{{$ans}}</option>                           
                    @endforeach
                  </select>
                    
                </div>
                <div class="col-md-6">
                  @php $imgUrl = asset('storage/banner/no-image.jpg') @endphp                
                  <img id="banner_upload" src="{{$imgUrl}}" alt="preview image" style="height: 60px; width:93px;">
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
          <input type="submit" value="Create" class="btn btn-success float-right">
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
        width: 277,
        height: 130,
    },
    enforceBoundary: false,
    enableExif: true,
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
        size: {width: 277, height: 130}
    }).then(function (resp) {
        $('#banner_upload').attr('src', resp);
        $('.banner_upload').val(resp);
        $('#cropImagePop').modal('hide');
    });
  $('#banner_img').val('');
});
$('.modalClose').click(function(){
  $('#banner_img').val('');
});
</script>
<script>
const listurl="{{route('bannerList')}}";
const storeurl="{{route('bannerstore')}}";
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="{{asset('assets/js/admin/bannerform.js')}}"></script>

@endpush