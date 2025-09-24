{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer__content">
            <div class="footer__column">
                <a href="/" class="footer__logo">
                    <img src="{{ config_get('site_logo_footer') }}" alt="{{ config_get('site_name') }}" height="40"
                        width="200">
                </a>
                <p class="footer__desc">
                    {{ config_get('site_description') }}
                </p>
                <div class="footer__social">
                    <a href="{{ config_get('facebook', '#') }}" class="social__link" target="_blank"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
            <div class="footer__column">
                <h3 class="footer__title">Thông Tin Liên Hệ</h3>
                <ul class="footer__contact" style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px 24px;align-items:start">
                    <li class="contact__item">
                        <i class="fas fa-phone-alt"></i>
                        <span>Hotline:
                            {{ preg_replace('/(\d{4})(\d{3})(\d{3})/', '$1.$2.$3', config_get('phone')) }}</span>
                    </li>
                    <li class="contact__item">
                        <i class="fas fa-comment-dots"></i>
                        <span>Zalo: <a href="https://zalo.me/{{ config_get('phone') }}" target="_blank">{{ preg_replace('/(\d{4})(\d{3})(\d{3})/', '$1.$2.$3', config_get('phone')) }}</a></span>
                    </li>
                    <li class="contact__item">
                        <i class="fas fa-envelope"></i>
                        <span>Email: {{ config_get('email') }}</span>
                    </li>
                    <li class="contact__item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Địa chỉ: {{ config_get('address') }}</span>
                    </li>
                    
                </ul>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="footer__copyright">
                &copy; {{ date('Y') }} - Bản quyền thuộc về <a href="/"
                    target="_blank">{{ strtoupper(request()->getHost()) }}</a>
            </div>
        </div>
        <style>
            @media (max-width: 768px) {
                .footer__contact { grid-template-columns: 1fr !important; }
            }
        </style>
    </div>
</footer>
