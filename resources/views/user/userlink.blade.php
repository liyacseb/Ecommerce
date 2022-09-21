
  @if(strpos(Request::url(),'order-detail/')>0)
    @php $orderDetailActive=1;  @endphp
  @endif
 <a href="{{route('customeraccount')}}" class="nav-link  {{ Request::is('customer-account') ? 'active' : '' }}"><i class="fa fa-user"></i> My account</a>
                    <a href="{{route('user.changepassword')}}" class="nav-link  {{ Request::is('user-change-password') ? 'active' : '' }}" ><i class="fa fa-key"></i>Change Password</a>
                    <a href="{{route('orders')}}" class="nav-link {{ Request::is('orders') || isset($orderDetailActive) ? 'active' : '' }}"><i class="fa fa-list"></i> My orders</a>
                    {{-- <a href="customer-wishlist.html" class="nav-link {{ Request::is('customer-account') ? 'active' : '' }}"><i class="fa fa-heart"></i> My wishlist</a> --}}
                    <a href="{{route('userLogout')}}" class="nav-link "><i class="fa fa-sign-out"></i> Logout</a>