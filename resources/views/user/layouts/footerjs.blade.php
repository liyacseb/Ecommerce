   <!-- JavaScript files-->
    <script src="{{asset('assets/user/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/user/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/user/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
    <script src="{{asset('assets/user/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/user/vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.js')}}"></script>
    <script src="{{asset('assets/user/js/front.js')}}"></script>

    <!-------  custom js files start  --------->
    <script>var baseurl = "{{url('/')}}";</script>
    @stack('js')
    <!-------  custom js files end  --------->
  </body>
</html>