@extends('admin.layout.layoutbody')
@php
    $breadcrumbs = [['title' => 'Product List','route' =>route('productList') ],['title' => 'Product Add','route' =>null ]];
@endphp
   
@push('css')
 <!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
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
</style>
@endpush

@section('maincontent')
@component('component.breadcrump',compact('breadcrumbs')) @endcomponent
<!-- Main content -->
<section class="content">
    <form method="post" id="productform">
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
                        <label for="inputName">Product Name *</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputName">Product Code</label>
                        <input type="text" name="product_code" id="product_code" class="form-control" >
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="cat_id">Category </label>
                        <select name="cat_id" class="form-control custom-select" >
                            <option selected disabled >Select one</option>
                            @foreach($category as $key => $value )
                              <option value="{{$value['id']}}" >{{$value['category_name']}}</option>                           
                            @endforeach
                        </select>                        
                    </div>
                    <div class="col-md-6">
                        <label for="tax_id">Tax *</label>
                        <select name="tax_id" class="form-control custom-select" required >
                            <option selected disabled value="">Select one</option>
                            @foreach($tax as $key => $value )
                              <option value="{{$value['id']}}" >{{$value['name']}} - {{$value['tax']}} %</option>                           
                            @endforeach
                        </select>
                        
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="inputName">Actual Price *</label>
                        <input type="text" name="actual_price" id="actual_price" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputName">Offer Price </label>
                        <input type="text" name="offer_price" id="offer_price" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="color_id">Color </label>
                        <select name="color_id[]"  class="form-control select2" multiple="multiple" data-placeholder="Select a Color"  multiple>
                            {{-- <option selected disabled >Select one</option> --}}
                            @foreach($color as $key => $value )
                              <option value="{{$value['id']}}" >{{$value['color']}}</option>                           
                            @endforeach
                        </select>                        
                      </div>
                    </div>
                    <div class="col-md-6">
                        <label for="size_id">Size </label>
                        <select name="size_id[]" class="select2" multiple="multiple" data-placeholder="Select a Size" multiple>
                            {{-- <option selected disabled >Select one</option> --}}
                            @foreach($size as $key => $value )
                              <option value="{{$value['id']}}" >{{$value['size']}}</option>                           
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-3 mt-4">
                      <div class="form-floating mb-3">
                      <label>Cover Image *</label>
                      <input class="" id="cover_image" type="file" name="cover_image" accept="image/png, image/jpeg, image/jpg" required  />
                      @if($errors->has('cover_image'))
                        <span class="text-danger">{{$errors->first('cover_image')}}</span>
                        @endif
                      </div>
                    </div>               
                    <div class="col-3 mt-4">
                      <div class="form-floating mb-3">
                      <label>Preview Image 1 *</label>
                      <input class="" id="image_1" type="file" name="image_1" accept="image/png, image/jpeg, image/jpg" required  />
                      @if($errors->has('image_1'))
                        <span class="text-danger">{{$errors->first('image_1')}}</span>
                        @endif
                      </div>
                    </div>               
                    <div class="col-3 mt-4">
                      <div class="form-floating mb-3">
                      <label>Preview Image 2</label>
                      <input class="" id="image_2" type="file" name="image_2" accept="image/png, image/jpeg, image/jpg"   />
                      @if($errors->has('image_2'))
                        <span class="text-danger">{{$errors->first('image_2')}}</span>
                        @endif
                      </div>
                    </div>               
                    <div class="col-3 mt-4">
                      <div class="form-floating mb-3">
                      <label>Preview Image 3</label>
                      <input class="" id="image_3" type="file" name="image_3" accept="image/png, image/jpeg, image/jpg"   />
                      @if($errors->has('image_3'))
                        <span class="text-danger">{{$errors->first('image_3')}}</span>
                        @endif
                      </div>
                    </div>               
                </div>
                <div class="row mt-2">
                      @php $imgUrl = asset('assets/product/noimage.jpg') @endphp     
                    <div class="col-md-3 " >                   
                      <img id="cover_image_upload" src="{{$imgUrl}}" alt="preview image" style="max-height: 150px; max-width:150px;">
                    </div>  
                    <div class="col-md-3 " >                
                      <img id="image_1_upload" src="{{$imgUrl}}" alt="preview image" style="max-height: 150px; max-width:150px;">
                    </div>  
                    <div class="col-md-3 " >                     
                      <img id="image_2_upload" src="{{$imgUrl}}" alt="preview image" style="max-height: 150px; max-width:150px;">
                    </div>  
                    <div class="col-md-3 " >                      
                      <img id="image_3_upload" src="{{$imgUrl}}" alt="preview image" style="max-height: 150px; max-width:150px;">
                    </div>  
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="descripton">Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="status">Status *</label>
                        <select name="status" class="form-control custom-select" required >
                            <option value="" selected >Select one</option>
                            @php $array=(config('options')) @endphp
                            @foreach($array['status'] as $key => $value )
                              <option value="{{$key}}" >{{$value}}</option>                           
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
          <input type="hidden" id="actionurl" data-href="{{route('productstore')}}">
          <input type="submit" value="Create" class="btn btn-success float-right">
        </div>
      </div>
    </form>
</section>
<!-- /.content -->

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
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
$(document).ready(function (e) {
   
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

});
 
</script>
@endpush