@extends('admin.layout.layoutbody')
@php
    $breadcrumbs = [['title' => 'Product List','route' =>route('productList') ],['title' => 'Product View','route' =>null ]];
@endphp
   
@push('css')
<style>
.product-image{
    width:300px !important;
    height:350px !important;
}
.img-fluid{
    height:100px !important;
}
</style>

@endpush
@section('maincontent')
@component('component.breadcrump',compact('breadcrumbs')) @endcomponent
<!-- Main content -->
<section class="content">
 <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <h3 class="d-inline-block d-sm-none"> </h3>
              <div class="col-12">
                @php
                    if($data['cover_image']){
                        $url =  asset('assets/product/'.$data['cover_image']);                 
                      }else{
                        $url =  asset('assets/product/noprofile.jpg');        
                      }
                @endphp
                <img src="{{$url}}" class="product-image" alt="Product Image">
              </div>
              <div class="col-12 product-image-thumbs">
                @php
                    if($data['image_1']){
                        $thumburl =  asset('assets/product/'.$data['image_1']);                 
                    }else{
                        $thumburl =  asset('assets/product/noprofile.jpg');        
                    }
                @endphp
                <div class="product-image-thumb active"><img src="{{$thumburl}}" alt="Product Image"></div>
                @php
                    if($data['image_2']){
                        $thumburl2 =  asset('assets/product/'.$data['image_2']);  
                        echo '<div class="product-image-thumb" ><img src="'.$thumburl2.'" alt="Product Image"></div>';               
                    }
                    if($data['image_3']){
                        $thumburl3 =  asset('assets/product/'.$data['image_3']);  
                        echo '<div class="product-image-thumb" ><img src="'.$thumburl3.'" alt="Product Image"></div>';               
                    }
                    if($data['image_4']){
                        $thumburl2 =  asset('assets/product/'.$data['image_4']);  
                        echo '<div class="product-image-thumb" ><img src="'.$thumburl4.'" alt="Product Image"></div>';               
                    }
                @endphp
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <h3 class="my-3">{{$data['product_name']}}</h3>
              <p>{{$data['product_code']}}</p>

              <hr>
              <h4>Available Colors</h4>
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
              @php
                  $colorAry =  explode(',',$data['color_id']);
              @endphp
                @foreach($color as $key => $value)
                @if((in_array($value['id'], $colorAry)))
                <label class="btn btn-default text-center active">
                  <input type="radio" name="color_option" id="color_option_a1" autocomplete="off" checked>
                  {{$value['color']}}
                  <br>
                  <i class="fas fa-circle fa-2x text-{{strtolower($value['color'])}}"></i>
                </label>
                @endif
                @endforeach
                
              </div>
                @if(isset($data['size_id']))
                @php
                  $sizeAry =  explode(',',$data['size_id']);
                @endphp
                <h4 class="mt-3">Available Size</h4>
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
              @foreach($size as $key => $value)
                @if((in_array($value['id'], $sizeAry)))
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_b1" autocomplete="off">
                  <span class="text-xl">{{$value['size']}}</span>
                </label>
                @endif
                @endforeach
               
              </div>
                @endif
              
              <div class="mt-4">
                <p>Category : {{$data->getallCategory['category_name']}} </p>
              </div>
              <div class="bg-gray py-2 px-3 mt-4">
                @if($data['offer_price'])
                <div class="d-flex">
                    <h2>₹{{$data['offer_price']}}</h2>
                    <h6 class="ml-2 mb-0">
                        <s> ₹{{$data['actual_price']}}  </s>  
                    </h6>                
                </div>
                @else
                <h2 class="mb-0">
                    ₹{{$data['actual_price']}}    
                </h2>
                @endif
                <h4 class="mt-0">
                  <small>Inclusive of all Tax </small>
                </h4>
                <h5 class="mt-0">
                  <small>{{$data->getTax['name']}} {{$data->getTax['tax']}}% </small>
                </h5>
              </div>

            </div>
          </div>
          <div class="row mt-4">
            <nav class="w-100">
              <div class="nav nav-tabs" id="product-tab" role="tablist">
                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                {{-- <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">Comments</a>
                <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating" role="tab" aria-controls="product-rating" aria-selected="false">Rating</a> --}}
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
              <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab"> {{$data['description']}} </div>
              {{-- <div class="tab-pane fade" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab"> Vivamus rhoncus nisl sed venenatis luctus. Sed condimentum risus ut tortor feugiat laoreet. Suspendisse potenti. Donec et finibus sem, ut commodo lectus. Cras eget neque dignissim, placerat orci interdum, venenatis odio. Nulla turpis elit, consequat eu eros ac, consectetur fringilla urna. Duis gravida ex pulvinar mauris ornare, eget porttitor enim vulputate. Mauris hendrerit, massa nec aliquam cursus, ex elit euismod lorem, vehicula rhoncus nisl dui sit amet eros. Nulla turpis lorem, dignissim a sapien eget, ultrices venenatis dolor. Curabitur vel turpis at magna elementum hendrerit vel id dui. Curabitur a ex ullamcorper, ornare velit vel, tincidunt ipsum. </div>
              <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab"> Cras ut ipsum ornare, aliquam ipsum non, posuere elit. In hac habitasse platea dictumst. Aenean elementum leo augue, id fermentum risus efficitur vel. Nulla iaculis malesuada scelerisque. Praesent vel ipsum felis. Ut molestie, purus aliquam placerat sollicitudin, mi ligula euismod neque, non bibendum nibh neque et erat. Etiam dignissim aliquam ligula, aliquet feugiat nibh rhoncus ut. Aliquam efficitur lacinia lacinia. Morbi ac molestie lectus, vitae hendrerit nisl. Nullam metus odio, malesuada in vehicula at, consectetur nec justo. Quisque suscipit odio velit, at accumsan urna vestibulum a. Proin dictum, urna ut varius consectetur, sapien justo porta lectus, at mollis nisi orci et nulla. Donec pellentesque tortor vel nisl commodo ullamcorper. Donec varius massa at semper posuere. Integer finibus orci vitae vehicula placerat. </div> --}}
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

</section>
<!-- /.content -->

@endsection

@push('js')
@endpush