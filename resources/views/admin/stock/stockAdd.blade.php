@extends('admin.layout.layoutbody')
@php
    $breadcrumbs = [['title' => 'Stock List','route' =>route('stockList') ],['title' => 'Stock Add','route' =>null ]];
@endphp
   

@section('maincontent')
@component('component.breadcrump',compact('breadcrumbs')) @endcomponent
<!-- Main content -->
<section class="content">
    <form method="post" id="stockform">
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
                        <label for="product">Product</label>
                        <span class="text-danger" id="prodErr"></span>
                        <select id="product" name="product" class="form-control custom-select">
                            <option selected disabled>Select one</option>
                            @foreach($products as $key => $value)
                              <option value="{{$value->id}}">{{ $value->product_name}}</option>
                            @endforeach
                            {{-- @foreach($products as $key => $value)
                              <option value="{{$value['id']}}">{{ $value['product_name']}}</option>
                            @endforeach --}}
                            
                        </select>
                    </div>
                </div>
              <!-- Table row -->
              <div class="row mt-4">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Color</th>
                      <th>Size</th>
                      <th>Stock</th>
                    </tr>
                    </thead>
                    <tbody id="stkBody">
                    
                   
                    </tbody>
                  </table>
                  <input type="hidden" name="stkNames" id="stkNames" value="">
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
       
      </div>
      <div class="row">
        <div class="col-12">
          <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
          <input type="hidden" id="actionurl" data-href="{{route('stockstore')}}">
          <input type="submit" value="Create" class="btn btn-success float-right">
        </div>
      </div>
    </form>
</section>
<!-- /.content -->

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="{{asset('assets/js/admin/stockform.js')}}"></script>

@endpush