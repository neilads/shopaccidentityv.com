<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                


                <li class="submenu {{ request()->routeIs('admin.accounts.*') ? 'active' : '' }}">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                            alt="img"><span>Tài khoản</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.accounts.index') }}">Danh sách tài
                                khoản</a></li>
                        <li><a href="{{ route('admin.accounts.create') }}">Thêm tài
                                khoản mới</a></li>
                    </ul>
                </li>

                <li class="submenu {{ request()->routeIs('admin.dich-vu.*') ? 'active' : '' }}">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                            alt="img"><span>Dịch Vụ</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.dich-vu.cay-thue') }}">Cày Thuê</a></li>
                        <li><a href="{{ route('admin.dich-vu.cho-thue') }}">Cho Thuê</a></li>
                        <li><a href="{{ route('admin.dich-vu.nap-identity') }}">Nạp Echoes</a></li>
                    </ul>
                </li>


                <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}"><img src="{{ asset('assets/img/icons/users1.svg') }}"
                            alt="img"><span>Người dùng</span></a>
                </li>

                <li class="submenu {{ request()->routeIs('admin.bank-accounts.*') ? 'active' : '' }}">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/dollar-square.svg') }}"
                            alt="img"><span>Ngân hàng</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.bank-accounts.index') }}">Danh sách
                                tài khoản</a></li>
                        <li><a href="{{ route('admin.bank-accounts.create') }}">Thêm tài
                                khoản mới</a></li>
                    </ul>
                </li>

                

                

                

                <li class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.general') }}"><i data-feather="settings"></i><span>Cài đặt hệ thống</span></a>
                </li>

                

            </ul>
        </div>
    </div>
</div>
