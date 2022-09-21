@extends('user.layouts.layout')
@php
    $breadcrumbs = [['title' => 'Product Detail','route' =>null ]];
@endphp
@push('css')
<style>
.prevImg{
    width:450px !important;
    height:600px !important;
}

  .radioCls:after {
        width: 30px !important;
        height: 30px !important;
        border-radius: 30px !important;
        top: -3px !important;
        left: -4px !important;
        position: relative !important;
        background-color: inherit !important;
        content: '' !important;
        display: inline-block !important;
        visibility: visible !important;
        border: 1px solid black !important;
    }

.radioCls:checked:after { 
    box-shadow: 0px 0px 0px 3px black;
    width: 30px !important;
    height: 30px !important;
    border-radius: 30px !important;
    top: -3px !important;
    left: -4px !important;
    position: relative !important;
    background-color: inherit!important;
    content: '' !important;
    display: inline-block !important;
    visibility: visible !important;
    border: 2px solid white !important;
}

  /*.colorDiv{
     animation:  shake 2s  ;
   }*/
   
   @keyframes shake{
     0%{
       transform: translateX(0)
     }
     25%{
       transform: translateX(12px);
     }
       
     50%{
       transform: translateX(-12px);
     }
     100%{
       transform: translateX(0px);
     }
   }
</style>
@endpush
@section('maincontent')
    <div id="all">
      <div id="content">
        <div class="container">
          <div class="row">
            @component('user.layouts.breadcrump',compact('breadcrumbs')) @endcomponent
            <div class="col-lg-12 order-1 order-lg-2">
              <div id="productMain" class="row">
                <div class="col-md-6">
                  <div data-slider-id="1" class="owl-carousel shop-detail-carousel">
                    <div class="item"> <img src="{{asset('assets/product/'.$curntdata['cover_image'])}}" alt="" class="img-fluid prevImg"></div>
                    <div class="item"> <img src="{{asset('assets/product/'.$curntdata['image_1'])}}" alt="" class="img-fluid prevImg"></div>
                    @if($curntdata['image_2'])
                    <div class="item"> <img src="{{asset('assets/product/'.$curntdata['image_2'])}}" alt="" class="img-fluid prevImg"></div>
                    @endif
                    @if($curntdata['image_3'])
                    <div class="item"> <img src="{{asset('assets/product/'.$curntdata['image_3'])}}" alt="" class="img-fluid prevImg"></div>
                    @endif
                    @if($curntdata['image_4'])
                    <div class="item"> <img src="{{asset('assets/product/'.$curntdata['image_4'])}}" alt="" class="img-fluid prevImg"></div>
                    @endif
                  </div>
                  {{-- <div class="ribbon sale">
                    <div class="theribbon">SALE</div>
                    <div class="ribbon-background"></div>
                  </div> --}}
                  <!-- /.ribbon-->
                  {{-- <div class="ribbon new">
                    <div class="theribbon">NEW</div>
                    <div class="ribbon-background"></div>
                  </div> --}}
                  <!-- /.ribbon-->
                  <div data-slider-id="1" class="owl-thumbs mt-4">
                    <button class="owl-thumb-item"><img src="{{asset('assets/product/'.$curntdata['cover_image'])}}" alt="" class="img-fluid"></button>
                    <button class="owl-thumb-item"><img src="{{asset('assets/product/'.$curntdata['image_1'])}}" alt="" class="img-fluid"></button>
                    @if($curntdata['image_2'])
                     <button class="owl-thumb-item"><img src="{{asset('assets/product/'.$curntdata['image_2'])}}" alt="" class="img-fluid"></button>
                    @endif
                    @if($curntdata['image_3'])
                     <button class="owl-thumb-item"><img src="{{asset('assets/product/'.$curntdata['image_3'])}}" alt="" class="img-fluid"></button>
                    @endif
                    @if($curntdata['image_4'])
                     <button class="owl-thumb-item"><img src="{{asset('assets/product/'.$curntdata['image_4'])}}" alt="" class="img-fluid"></button>
                    @endif
                   
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box" style="min-height:600px">
                    <h1 class="text-center">{{$curntdata['product_name']}}</h1>
                     @if($curntdata['offer_price'])
                       <p class="price"> <del><span style="font-size: 1rem;">₹{{$curntdata['actual_price']}}</span></del>₹{{$curntdata['offer_price']}}</p>
                    @else
                        <p class="price">₹{{$curntdata['actual_price']}}</p>
                    @endif
                    <p></p>
                    <h4>Product details</h4>
                    <p>Category :<a href=""> {{$curntdata->getCategory['category_name']}} </a></p>
                    <p>Tax &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$curntdata->getTax['name']}} {{$curntdata->getTax['tax']}}% </p>
                    <h4>Colors</h4>
                    <div class="colorDiv">
                    <h5 id="colorErr" style="display:none;" class="text-danger">Please select a Color</h5>
                    @php $colorID = explode(',',$curntdata->color_id) @endphp
                    @foreach($colors as $key => $value)
                       @if(in_array($value['id'],$colorID))
                            <input type='radio' class="radioCls mr-4" data-color="{{$value['color']}}" title="{{$value['color']}}" name="color" value="{{$value['id']}}" style="background-color:{{$value['color']}}" />
                       @endif
                    @endforeach
                    </div>
                    @isset($curntdata->size_id)
                    @php $sizeID = explode(',',$curntdata->size_id) @endphp
                    <div class="sizeDiv mt-3">
                      <h5 id="sizeErr" style="display:none;" class="text-danger">Please select a Size</h5>
                        <h4 >Size</h4>
                         @php $sizeID = explode(',',$curntdata->size_id) @endphp
                         <select id="size">
                          <option disabled selected>Chose</option>
                          @foreach($size as $key => $value)
                          @if(in_array($value['id'],$sizeID))
                              <option value="{{$value['id']}}" >{{$value['size']}}</option>
                          @endif
                          @endforeach
                        </select>
                      </div>
                    @endif
                   <div class="stkoutDiv mt-3">
                    <h5 id="stkoutErr" style="display:none;" class="text-danger"><b>Out Of Stock</b></h5>
                    </div>
                    <blockquote>
                        <p class="mt-2"><em>{{$curntdata['description']}}</em></p>
                    </blockquote>
                    <hr>
                    {{-- <div class="social">
                        <h4>Show it to your friends</h4>
                        <p><a href="#" class="external facebook"><i class="fa fa-facebook"></i></a><a href="#" class="external gplus"><i class="fa fa-google-plus"></i></a><a href="#" class="external twitter"><i class="fa fa-twitter"></i></a><a href="#" class="email"><i class="fa fa-envelope"></i></a></p>
                    </div> --}}
                    <p class="text-center buttons">
                      @if($curntdata['status']==1)
                        <a href="javascript:" class="btn btn-primary update-cart" data-prodid="{{$curntdata->id}}"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                      @else
                        <a href="javascript:" class="btn btn-info " disabled >  Not Available</a>
                      @endif
                        {{-- <a href="basket.html" class="btn btn-outline-primary"><i class="fa fa-heart"></i> Add to wishlist</a> --}}
                    </p>
                  </div>
                  
                </div>
              </div>
            @if(count($catproducts)>0)
              <div class="row same-height-row">
                <div class="col-md-3 col-sm-6">
                  <div class="box same-height">
                    <h3>You may also like these products</h3>
                  </div>
                </div>
                @foreach($catproducts as $val)
                <div class="col-md-3 col-sm-6">
                  <div class="product same-height">
                    <div class="flip-container">
                      <div class="flipper">
                        <div class="front"><a href="{{route('detail',$val['id'])}}"><img src="{{asset('assets/product/'.$val['cover_image'])}}" alt="" class="img-fluid"></a></div>
                        <div class="back"><a href="{{route('detail',$val['id'])}}"><img src="{{asset('assets/product/'.$val['image_1'])}}" alt="" class="img-fluid"></a></div>
                      </div>
                    </div><a href="{{route('detail',$val['id'])}}" class="invisible"><img src="{{asset('assets/product/'.$val['cover_image'])}}" alt="" class="img-fluid"></a>
                    <div class="text">
                      <h3><a href="{{route('detail',$val['id'])}}"> {{$val['product_name']}} </a> </h3>
                       @if($val['offer_price'])
                        <p class="price"><del><span style="font-size: 1rem;" >₹{{$val['actual_price']}}</span></del>₹{{$val['offer_price']}}</p>
                        @else
                        <p class="price"> <del></del>₹{{$val['actual_price']}}</p>
                        @endif
                    </div>
                  </div>
                </div>
                  <!-- /.product-->
                    @endforeach
                </div>
                
              </div>
            @endif
              {{-- <div class="row same-height-row">
                <div class="col-md-3 col-sm-6">
                  <div class="box same-height">
                    <h3>Products viewed recently</h3>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="product same-height">
                    <div class="flip-container">
                      <div class="flipper">
                        <div class="front"><a href="detail.html"><img src="{{asset('assets/user/img/product2.jpg')}}" alt="" class="img-fluid"></a></div>
                        <div class="back"><a href="detail.html"><img src="{{asset('assets/user/img/product2_2.jpg')}}" alt="" class="img-fluid"></a></div>
                      </div>
                    </div><a href="detail.html" class="invisible"><img src="{{asset('assets/user/img/product2.jpg')}}" alt="" class="img-fluid"></a>
                    <div class="text">
                      <h3>Fur coat</h3>
                      <p class="price">$143</p>
                    </div>
                  </div>
                  <!-- /.product-->
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="product same-height">
                    <div class="flip-container">
                      <div class="flipper">
                        <div class="front"><a href="detail.html"><img src="{{asset('assets/user/img/product1.jpg')}}" alt="" class="img-fluid"></a></div>
                        <div class="back"><a href="detail.html"><img src="{{asset('assets/user/img/product1_2.jpg')}}" alt="" class="img-fluid"></a></div>
                      </div>
                    </div><a href="detail.html" class="invisible"><img src="{{asset('assets/user/img/product1.jpg')}}" alt="" class="img-fluid"></a>
                    <div class="text">
                      <h3>Fur coat</h3>
                      <p class="price">$143</p>
                    </div>
                  </div>
                  <!-- /.product-->
                </div>
                <div class="col-md-3 col-sm-6">
                  <div class="product same-height">
                    <div class="flip-container">
                      <div class="flipper">
                        <div class="front"><a href="detail.html"><img src="{{('assets/user/img/product3.jpg')}}" alt="" class="img-fluid"></a></div>
                        <div class="back"><a href="detail.html"><img src="{{('assets/user/img/product3_2.jpg')}}" alt="" class="img-fluid"></a></div>
                      </div>
                    </div><a href="detail.html" class="invisible"><img src="{{('assets/user/img/product3.jpg')}}" alt="" class="img-fluid"></a>
                    <div class="text">
                      <h3>Fur coat</h3>
                      <p class="price">$143</p>
                    </div>
                  </div>
                  <!-- /.product-->
                </div>
              </div> --}}
            </div>
            <!-- /.col-md-9-->
          </div>
        </div>
      </div>
    </div>
<!-- The actual snackbar -->
<div id="snackbar">Some text some message..</div>
          <input type="hidden" id="carthref" value="{{route('update.cart')}}" >
          @if(isset($curntdata->size_id)) @php $sizeExist=1 @endphp @else @php $sizeExist=0 @endphp @endif
          <input type="hidden" id="sizeExist" value="{{$sizeExist}}" >
@endsection
@push('js')
  <script src="{{asset('assets/js/user/detail.js')}}"></script>
@endpush