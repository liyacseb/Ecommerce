  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">
              @php $lstindex = count($breadcrumbs) @endphp
              @if($lstindex==0)
                Dashboard
              @else
                {{$breadcrumbs[$lstindex-1]['title']}}
              @endif
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              @if(count($breadcrumbs)==0)
              <li class="breadcrumb-item active"><span class="bullet  w-5px h-2px"></span></li>Home
              @else
              <li class="breadcrumb-item "><a class="text-muted text-hover-primary" href="{{route('dashboard')}}">Home</a></li>
              @endif
              @foreach ($breadcrumbs as $breadcrumb)
        <li class="breadcrumb-item">
            <span class="bullet  w-5px h-2px"></span>
        </li>
            
                @isset($breadcrumb['route'])
                    <a href="{{ $breadcrumb['route'] }}" class="text-muted text-hover-primary">
                    
                @endisset
                
                    {{ $breadcrumb['title'] }}

                @isset($breadcrumb['route'])
                    </a>
                    <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                        <span class="bullet  w-5px h-2px"></span>
                    </li>
                @endisset
            </li>

        </li>
        
        @endforeach
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
