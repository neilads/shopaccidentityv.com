<div class="header">

    <div class="header-left active" style="display: flex; justify-content: center;">
        <a href="{{ route('admin.index') }}" class="logo">
            <img src="{{ config_get('site_logo') }}" alt="Logo">
        </a>
        <a href="{{ route('admin.index') }}" class="logo-small">
            <img src="{{ config_get('site_logo_footer') ?: config_get('site_logo') }}" alt="Logo">
        </a>
        
    </div>

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>
</div>
