@extends('user.layouts.layout')
@php
    $breadcrumbs = [['title' => 'Products','route' =>route('productlist') ],['title' => $products[0]['getCategory']['category_name'],'route' =>null ]];
@endphp
@push('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  
<style>
#notfoundimg{
  width:100%; 
  height:100%
}
#notfoundimg img {
  margin-left: auto;
  margin-right: auto;
  display: block;
}
</style>
@endpush
@section('maincontent')
    <div id="all">
      <div id="content">
        <div class="container">
          <div class="row">
          
            @component('user.layouts.breadcrump',compact('breadcrumbs')) @endcomponent
            <div class="col-lg-12">
              <div class="box">
                <h1>{{$products[0]['getCategory']['category_name']}}</h1>
                <p>{{$products[0]['getCategory']['description']}}</p>
              </div>
              <div class="box info-bar">
                <div class="row">
                  <div class="col-md-12 col-lg-4 products-showing">
                  Showing 
                  {{-- <strong>12</strong> of  --}}
                  <strong>{{count($products)}}</strong> products
                  </div>
                  <div class="col-md-12 col-lg-7 products-number-sort">
                    <form class="form-inline d-block d-lg-flex justify-content-between flex-column flex-md-row">
                      {{-- <div class="products-number"><strong>Show</strong><a href="#" class="btn btn-sm btn-primary">12</a><a href="#" class="btn btn-outline-secondary btn-sm">24</a><a href="#" class="btn btn-outline-secondary btn-sm">All</a><span>products</span></div> --}}
                      <div class="products-sort-by mt-2 mt-lg-0"><strong>Sort by</strong>
                        <input type="hidden" id="sortbyurl" value="{{route('sortbyurl')}}">
                        <input type="hidden" id="catid" value="{{$products[0]['cat_id']}}">

                        <select name="sort-by" id="sort-by" class="form-control">
                          <option value="0">Newest</option>
                          <option value="1">Price : Low to High</option>
                          <option value="2">Price : High to Low</option>
                          {{-- <option value="2">Name</option> --}}
                          {{-- <option>Sales first</option> --}}
                        </select>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="row products">
                @if(count($products)>0)
                  @foreach($products as $proVal)
                      
                  <div class="col-lg-4 col-md-6">
                    <div class="product">
                      <div class="flip-container">
                        <div class="flipper">
                          <div class="front"><a href="{{route('detail',$proVal['id'])}}"><img src="{{asset('assets/product/'.$proVal['cover_image'])}}" alt="" class="img-fluid"></a></div>
                          <div class="back"><a href="{{route('detail',$proVal['id'])}}"><img src="{{asset('assets/product/'.$proVal['image_1'])}}" alt="" class="img-fluid"></a></div>
                        </div>
                      </div><a href="{{route('detail',$proVal['id'])}}" class="invisible"><img src="{{asset('assets/product/'.$proVal['cover_image'])}}" alt="" class="img-fluid"></a>
                      <div class="text">
                        <h3><a href="{{route('detail',$proVal['id'])}}">{{$proVal['product_name']}}</a></h3>
                        <p class="price"> 
                          @if($proVal['offer_price'])
                          <del>₹{{$proVal['actual_price']}}</del>₹{{$proVal['offer_price']}}
                          @else
                          <del></del>₹{{$proVal['actual_price']}}
                          @endif
                        </p>
                        <p class="buttons"><a href="{{route('detail',$proVal['id'])}}" class="btn btn-outline-secondary">View detail</a>
                        {{-- <a href="basket.html" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>Add to cart</a> --}}
                        </p>
                      </div>
                      <!-- /.text-->
                      {{-- <div class="ribbon sale">
                        <div class="theribbon">SALE</div>
                        <div class="ribbon-background"></div>
                      </div>
                      <!-- /.ribbon-->
                      <div class="ribbon new">
                        <div class="theribbon">NEW</div>
                        <div class="ribbon-background"></div>
                      </div>
                      <!-- /.ribbon-->
                      <div class="ribbon gift">
                        <div class="theribbon">GIFT</div>
                        <div class="ribbon-background"></div>
                      </div> --}}
                      <!-- /.ribbon-->
                    </div>
                    <!-- /.product            -->
                  </div>
                  @endforeach
                  @else
                  <div id="notfoundimg" class="mb-3" ><img src="{{asset('assets/dist/img/notfound.jpg')}}" ></div>
                @endif
                <!-- /.products-->
              </div> 
              {{-- <div class="pages">
                <p class="loadMore"><a href="#" class="btn btn-primary btn-lg"><i class="fa fa-chevron-down"></i> Load more</a></p>
                <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                  <ul class="pagination">
                    <li class="page-item"><a href="#" aria-label="Previous" class="page-link"><span aria-hidden="true">«</span><span class="sr-only">Previous</span></a></li>
                    <li class="page-item active"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">4</a></li>
                    <li class="page-item"><a href="#" class="page-link">5</a></li>
                    <li class="page-item"><a href="#" aria-label="Next" class="page-link"><span aria-hidden="true">»</span><span class="sr-only">Next</span></a></li>
                  </ul>
                </nav>
              </div> --}}
            </div>
            <!-- /.col-lg-9-->
          </div>
        </div>
      </div>
    </div>

@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="{{asset('assets/js/user/productlist.js')}}"></script>

@endpush