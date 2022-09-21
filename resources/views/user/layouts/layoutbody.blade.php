@include('user.layouts.headercss')
@include('user.layouts.header')
    <div id="all">
      <div id="content">
        <div class="container">
          <div class="row">
            
             @yield('maincontent')
          </div>
        </div>
      </div>
    </div>

@include('user.layouts.footer')
@include('user.layouts.footerjs')
