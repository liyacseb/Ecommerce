 <div class="col-lg-12">
              <!-- breadcrumb-->
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    @foreach ($breadcrumbs as $breadcrumb)
                        @isset($breadcrumb['route'])
                            <li class="breadcrumb-item"><a href="{{ $breadcrumb['route'] }}" >{{ $breadcrumb['title'] }}
                            </a></li>
                           
                        @endisset
                        @if($breadcrumb['route']==null)
                            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">{{ $breadcrumb['title'] }}</li>                           
                        @endisset
                    @endforeach
                </ol>
              </nav>
            </div>