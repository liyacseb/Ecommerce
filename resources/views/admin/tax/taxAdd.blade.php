@extends('admin.layout.layoutbody')
@php
    $breadcrumbs = [['title' => 'Tax List','route' =>route('taxList') ],['title' => 'Tax Add','route' =>null ]];
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
    <form method="post" id="taxform">
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
                        <label for="inputName">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="inputName">Tax ( % ) <span id="taxerr" class="text-danger"></span> </label>
                        <input type="text" name="tax" id="tax" class="form-control">
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
          <input type="hidden" id="actionurl" data-href="{{route('taxstore')}}">
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
const listurl="{{route('taxList')}}";
</script>
<script src="{{asset('assets/js/admin/taxform.js')}}"></script>

@endpush