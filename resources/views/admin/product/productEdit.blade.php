@extends('admin.layout.layoutbody')
@php
    $breadcrumbs = [['title' => 'Product List','route' =>route('productList') ],['title' => 'Product Update','route' =>null ]];
@endphp
   
@push('css')
 <!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<!------ crop image Start ------->
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> --}}
  <link rel="stylesheet" href="https://foliotek.github.io/Croppie/croppie.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!------ crop image End ------->
<style>
  .custom-control{
    display: inline-block !important;
  }
  .select2-container{
  width:100% !important;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #007bff !important;
    border-color: #006fe6 !important;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: rgba(255,255,255,.7) !important;
  } 

  

  label.cabinet{
	display: block;
	cursor: pointer;
}

label.cabinet input.file{
	position: relative;
	height: 100%;
	width: auto;
	opacity: 0;
	-moz-opacity: 0;
  filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
  margin-top:-30px;
}

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
    <form method="post" id="productupdateform">
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
                    <div class="col-md-6">
                        <label for="inputName">Product Name *</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" required value="{{$curntdata->product_name}}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputName">Product Code</label>
                        <input type="text" name="product_code" id="product_code" class="form-control" value="{{$curntdata->product_code}}" >
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="cat_id">Category </label>
                        <select name="cat_id" class="form-control custom-select" >
                            <option selected disabled >Select one</option>
                            @foreach($category as $key => $value )
                              @php $selected = ''; @endphp
                              @if($value['id']==$curntdata->cat_id) @php $selected = 'selected'; @endphp @endif
                              <option value="{{$value['id']}}" {{$selected}} >{{$value['category_name']}}</option>                           
                            @endforeach
                        </select>                        
                    </div>
                    <div class="col-md-6">
                        <label for="tax_id">Tax *</label>
                        <select name="tax_id" class="form-control custom-select" required >
                            <option selected disabled value="">Select one</option>
                            @foreach($tax as $key => $value )
                              @php $selected = ''; @endphp
                              @if($value['id']==$curntdata->tax_id) @php $selected = 'selected'; @endphp @endif
                              <option value="{{$value['id']}}" {{$selected}} >{{$value['name']}} - {{$value['tax']}} %</option>                           
                            @endforeach
                        </select>
                        
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="inputName">Actual Price *</label>
                        <input type="text" name="actual_price" id="actual_price" class="form-control" required value="{{$curntdata->actual_price}}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputName">Offer Price </label>
                        <input type="text" name="offer_price" id="offer_price" class="form-control" value="{{$curntdata->offer_price}}">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="color_id">Color </label>
                        @php
                          $selectedcolors = explode(',',$curntdata->color_id);
                        @endphp
                        <select name="color_id[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Color"  multiple>
                            <option disabled >Select one</option>
                            @foreach($color as $key => $value )
                              @php
                                $sel = '';
                                if (in_array($value['id'], $selectedcolors)) {
                                    $sel = 'selected';
                                }
                              @endphp
                              <option value="{{$value['id']}}" {{$sel}} >{{$value['color']}}</option>                           
                            @endforeach
                        </select>                        
                    </div>
                    <div class="col-md-6">
                        <label for="size_id">Size </label>
                         @php
                          $selectedsizes = explode(',',$curntdata->size_id);
                        @endphp
                        <select name="size_id[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Color"  multiple>
                            <option disabled>Select one</option>
                            @foreach($size as $key => $value )
                              @php
                                $sel = '';
                                if (in_array($value['id'], $selectedsizes)) {
                                    $sel = 'selected';
                                }
                              @endphp
                              <option value="{{$value['id']}}" {{$sel}} >{{$value['size']}}</option>                           
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-3 mt-4">
                      <div class="form-floating mb-3">
                      <label>Cover Image * </label>
                      <input class="image" data-id="0"  id="image_0" type="file" name="cover_image" accept="image/png, image/jpeg, image/jpg"   />
                      @if($errors->has('cover_image'))
                        <span class="text-danger">{{$errors->first('cover_image')}}</span>
                        @endif
                      </div>
                    </div>               
                    <div class="col-3 mt-4">
                      <div class="form-floating mb-3">
                      <label>Preview Image 1 *</label>
                      <input  class="image" data-id="1" id="image_1" type="file" name="image_1" accept="image/png, image/jpeg, image/jpg"   />
                      @if($errors->has('image_1'))
                        <span class="text-danger">{{$errors->first('image_1')}}</span>
                        @endif
                      </div>
                    </div>               
                    <div class="col-3 mt-4">
                      <div class="form-floating mb-3">
                      <label>Preview Image 2</label>
                      <input  class="image" data-id="2"  id="image_2" type="file" name="image_2" accept="image/png, image/jpeg, image/jpg"   />
                      @if($errors->has('image_2'))
                        <span class="text-danger">{{$errors->first('image_2')}}</span>
                        @endif
                      </div>
                    </div>               
                    <div class="col-3 mt-4">
                      <div class="form-floating mb-3">
                      <label>Preview Image 3</label>
                      <input  class="image" data-id="3" id="image_3" type="file" name="image_3" accept="image/png, image/jpeg, image/jpg"   />
                      @if($errors->has('image_3'))
                        <span class="text-danger">{{$errors->first('image_3')}}</span>
                        @endif
                      </div>
                    </div>               
                </div>
                <div class="row mt-2">
                      @php $imgUrl = asset('assets/product/noimage.jpg') @endphp   
                      @if($curntdata->cover_image)  @php $imgUrl = asset('assets/product/'.$curntdata->cover_image) @endphp  @endif
                    <div class="col-md-3 " >                   
                      <img  id="image_0_upload" src="{{$imgUrl}}" alt="preview image" style="max-height: 150px; max-width:150px;">
                      <input type="hidden" name="image_0_upload" class="image_0_upload">
                    </div>  
                      @php $imgUrl = asset('assets/product/noimage.jpg') @endphp  
                      @if($curntdata->image_1)  @php $imgUrl = asset('assets/product/'.$curntdata->image_1) @endphp  @endif
                    <div class="col-md-3 " >                
                      <img id="image_1_upload" src="{{$imgUrl}}" alt="preview image" style="max-height: 150px; max-width:150px;">
                      <input type="hidden" name="image_1_upload" class="image_1_upload">
                    </div>
                      @php $imgUrl = asset('assets/product/noimage.jpg') @endphp    
                      @if($curntdata->image_2)  @php $imgUrl = asset('assets/product/'.$curntdata->image_2) @endphp  @endif
                    <div class="col-md-3 " >                     
                      <img id="image_2_upload" src="{{$imgUrl}}" alt="preview image" style="max-height: 150px; max-width:150px;">
                      <input type="hidden" name="image_2_upload" class="image_2_upload">
                    </div>  
                      @php $imgUrl = asset('assets/product/noimage.jpg') @endphp  
                      @if($curntdata->image_3)  @php $imgUrl = asset('assets/product/'.$curntdata->image_3) @endphp  @endif
                    <div class="col-md-3 " >                      
                      <img id="image_3_upload" src="{{$imgUrl}}" alt="preview image" style="max-height: 150px; max-width:150px;">
                      <input type="hidden" name="image_3_upload" class="image_3_upload">
                    </div>  
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="descripton">Description</label>
                        <textarea name="description" id="description" class="form-control"> {{$curntdata->description}} </textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="status">Status *</label>
                        <select name="status" class="form-control custom-select" required >
                            <option selected >Select one</option>
                            @php $array=(config('options')) @endphp
                            @foreach($array['status'] as $key => $value )
                              @php $selected = ''; @endphp
                              @if($key==$curntdata->status) @php $selected = 'selected'; @endphp @endif
                              <option value="{{$key}}" {{$selected}} >{{$value}}</option>                           
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
          <input type="hidden" id="actionurl" data-href="{{route('productupdate',$curntdata->id)}}">
          <input type="submit" value="Update" class="btn btn-success float-right">
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
<script>
const listurl="{{route('productList')}}";
</script>
<script src="{{asset('assets/js/admin/productform.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
});
</script>
<script type="text/javascript">
      
/*$(document).ready(function (e) {
   
  $('#cover_image').change(function(){            
    let reader = new FileReader(); 
    reader.onload = (e) => {  
      $('#cover_image_upload').attr('src', e.target.result); 
    } 
    reader.readAsDataURL(this.files[0]);    
  }); 
    
  $('#image_1').change(function(){            
    let reader = new FileReader(); 
    reader.onload = (e) => {  
      $('#image_1_upload').attr('src', e.target.result); 
    } 
    reader.readAsDataURL(this.files[0]);    
  }); 
  $('#image_2').change(function(){            
    let reader = new FileReader(); 
    reader.onload = (e) => {  
      $('#image_2_upload').attr('src', e.target.result); 
    } 
    reader.readAsDataURL(this.files[0]);    
  }); 
  $('#image_3').change(function(){            
    let reader = new FileReader(); 
    reader.onload = (e) => {  
      $('#image_3_upload').attr('src', e.target.result); 
    } 
    reader.readAsDataURL(this.files[0]);    
  }); 

});*/
 
</script>
<!------ crop image Start ------->
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}
  <script src="https://foliotek.github.io/Croppie/croppie.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!------ crop image End ------->
<script>
// Start upload preview image
$(".gambar").attr("src", "https://user.gadjian.com/static/images/personnel_boy.png");
var $uploadCrop,
tempFilename,
rawImg,
imageId;
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
$uploadCrop = $('#upload-demo').croppie({
    viewport: {
        width: 200,
        height: 200,
    },
    enforceBoundary: false,
    enableExif: true
});
$('#cropImagePop').on('shown.bs.modal', function(){
    // alert('Shown pop');
    $uploadCrop.croppie('bind', {
        url: rawImg
    }).then(function(){
        console.log('jQuery bind complete');
    });
});
$('.image').on('change', function () { 
    imageId = $(this).attr('data-id'); 
    tempFilename = $(this).val();
    $('#cancelCropBtn').data('id', imageId); 
    readFile(this); 
});
$('#cropImageBtn').on('click', function (ev) {
    $uploadCrop.croppie('result', {
        type: 'base64',
        format: 'jpeg',
        size: {width: 450, height: 600}
    }).then(function (resp) {
        $('#image_'+imageId+'_upload').attr('src', resp);
        $('.image_'+imageId+'_upload').val(resp);
        $('#cropImagePop').modal('hide');
    });
  $('#image_'+imageId).val('');
});
$('.modalClose').click(function(){
  $('#image_'+imageId).val('');
});
// End upload preview image
</script>
@endpush