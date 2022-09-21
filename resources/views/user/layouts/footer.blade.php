    <!--
    *** FOOTER ***
    _________________________________________________________
    -->
    <div id="footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6">
            {{-- <h4 class="mb-3">Pages</h4>
            <ul class="list-unstyled">
              <li><a href="text.html">About us</a></li>
              <li><a href="text.html">Terms and conditions</a></li>
              <li><a href="faq.html">FAQ</a></li>
              <li><a href="contact.html">Contact us</a></li>
            </ul>
            <hr> --}}
            <h4 class="mb-3">User section</h4>
            <ul class="list-unstyled">
              @if(Auth::guard('user')->check())
                <li><a href="{{route('customeraccount')}}" >Account</a></li>
              @else
                <li><a href="{{route('userlogin')}}" >Login</a></li>
                <li><a href="{{route('register')}}">Regsiter</a></li>
              @endif
            </ul>
          </div>
          <!-- /.col-lg-3-->
          <div class="col-lg-3 col-md-6">
            <h4 class="mb-3">Top categories</h4>
            <ul class="list-unstyled">
            @foreach($categories as $catVal)
              @if($catVal['getCategory'])
              <li><a href="{{route('category',$catVal->getCategory['id'])}}">{{$catVal->getCategory['category_name']}}</a></li>
              @endif
            @endforeach
            </ul>
            
          </div>
          <!-- /.col-lg-3-->
          <div class="col-lg-3 col-md-6">
            <h4 class="mb-3">Where to find us</h4>
            <p><strong>{{$websitecontact['website_name']}}</strong><br>{{$websitecontact['adrs_line_1']}}<br>{{$websitecontact['adrs_line_2']}}<br>{{$websitecontact['pincode']}}<br>{{$websitecontact['district']}}, {{$websitecontact['state']}}<br><strong>{{$websitecontact['country']}}</strong></p>
            {{-- <a href="contact.html">Go to contact page</a> --}}
            <hr class="d-block d-md-none">
          </div>
          <!-- /.col-lg-3-->
          <div class="col-lg-3 col-md-6">
            {{-- <h4 class="mb-3">Get the news</h4>
            <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
            <form>
              <div class="input-group">
                <input type="text" class="form-control"><span class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary">Subscribe!</button></span>
              </div>
            </form> --}}
            <hr>
            <h4 class="mb-3">Stay in touch</h4>
            <p class="social">
            @if($websitecontact['fb_link'])
              <a href="{{$websitecontact['fb_link']}}" target="_blank" class="facebook external"><i class="fa fa-facebook"></i></a>
            @endif
            @if($websitecontact['twitter_link'])
              <a href="{{$websitecontact['twitter_link']}}" target="_blank" class="twitter external"><i class="fa fa-twitter"></i></a>
            @endif
            @if($websitecontact['insta_link'])
              <a href="{{$websitecontact['insta_link']}}" target="_blank" class="instagram external"><i class="fa fa-instagram"></i></a>
            @endif
            @if($websitecontact['gmail_link'])
              <a href="{{$websitecontact['gmail_link']}}" target="_blank" class="email external"><i class="fa fa-envelope"></i></a>
            @endif
            </p>
          </div>
          <!-- /.col-lg-3-->
        </div>
        <!-- /.row-->
      </div>
      <!-- /.container-->
    </div>
    <!-- /#footer-->
    <!-- *** FOOTER END ***-->
    
    
    <!--
    *** COPYRIGHT ***
    _________________________________________________________
    -->
    <div id="copyright">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 mb-2 mb-lg-0">
            <p class="text-center text-lg-left">©{{date('Y')}} {{$websitecontact['website_name']}}.</p>
          </div>
          <div class="col-lg-6">
            {{-- <p class="text-center text-lg-right">Template design by <a href="https://bootstrapious.com/">Bootstrapious</a> --}}
              <!-- If you want to remove this backlink, pls purchase an Attribution-free License @ https://bootstrapious.com/p/obaju-e-commerce-template. Big thanks!-->
            </p>
          </div>
        </div>
      </div>
    </div>
    <!-- *** COPYRIGHT END ***-->