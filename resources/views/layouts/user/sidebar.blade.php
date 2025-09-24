{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

<div class="profile-sidebar">
    <div class="sidebar-header">
        <h2 class="sidebar-title">MENU TÀI KHOẢN</h2>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
            <a href="{{ route('profile.index') }}" class="sidebar-link">
                <i class="fa-solid fa-user"></i> Thông tin tài khoản
            </a>
        </li>
        
        
        
    </ul>

    
</div>
