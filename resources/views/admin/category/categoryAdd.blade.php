@extends('admin.layout.layoutbody')
@php
    $breadcrumbs = [['title' => 'Category List','route' =>route('categoryList') ],['title' => 'Category Add','route' =>null ]];
@endphp
   
@push('css')
<style>
  .custom-control{
    display: inline-block !important;
  }
</style>
@endpush

@section('maincontent')
@component('component.breadcrump',compact('breadcrumbs')) @endcomponent
<!-- Main content -->
<section class="content">
    <form method="post" id="categoryaddform">
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
                    <div class="col-md-12">
                        <label for="inputName">Name</label>
                        <input type="text" name="category_name" id="category_name" class="form-control">
                    </div>
                </div>
                
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="inputName">Description </label>
                        <textarea  name="description" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="icon">Icon </label>
                        <input type="text" name="icon" class="form-control" placeholder="fas fa-address-book">
                        {{-- <select name="category_status" class="form-control custom-select">
                            <option selected disabled>Select one</option>
                          @foreach($array['fontoptions'] as $key => $ans )
                            <option value="{{$key}}" >{{$ans}}</option>                           
                          @endforeach
                        </select> --}}
                    </div>
                   
                </div>
                @php $array=(config('options')) @endphp
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="category_status">Status </label>
                        <select name="category_status" class="form-control custom-select">
                            <option selected disabled>Select one</option>
                          @foreach($array['status'] as $key => $ans )
                            <option value="{{$key}}" ><i class="fas {{$ans}}"></i>{{$ans}}</option>                           
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
          <input type="hidden" id="actionurl" data-href="{{route('categorystore')}}">`
          <input type="submit" value="Create" class="btn btn-success float-right">
        </div>
      </div>
    </form>
</section>
<!-- /.content -->

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
const listurl="{{route('categoryList')}}";
</script>
<script src="{{asset('assets/js/admin/categoryform.js')}}"></script>

@endpush