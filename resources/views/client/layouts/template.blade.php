<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SHOP QUẦN ÁO</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Font Awaesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('client/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('client/css/style.css') }}" type="text/css">
    <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
    @yield('css')
</head>

<body>
    @include('sweetalert::alert')
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="{{ route('client.home') }}"><img src="{{ asset($setting->logo) }}" alt=""></a>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> {{ $setting->email }}</li>
                                <li>Miễn phí ship với hóa đơn từ 500.000 VND</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            @if (!Auth::check())
                                @if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role == 0)
                                    <div class="header__top__right__auth">
                                        <a href="{{ route('auth.show.login') }}"><i class="fa fa-user"></i> Đăng nhập</a>
                                    
                                    </div>
                                    <div class="header__top__right__auth">
                                        <a href="{{ route('auth.show.register') }}">| Đăng ký</a>
                                    </div>
                                @else
                                    <div class="header__top__right__auth">
                                        <a href="{{ route('product.list') }}"><i class="fa fa-dashboard"></i> Hệ thống</a>
                                    </div>
                                @endif
                            @else
                                <div class="header__top__right__auth">
                                    <a href="{{ route('my.order') }}">Xin chào, {{ Auth::user()->name }}</a>
                                </div>
                                <div class="header__top__right__auth">
                                    <a href="{{ route('auth.logout') }}">| Đăng xuất</a>
                                </div>
                            @endif
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="{{ route('client.home') }}"><img src="{{ asset($setting->logo) }}" width="150" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li><a href={{ route('client.home') }}>Trang chủ</a></li>
                            <li><a href={{ route('client.product') }}>Sản phẩm</a></li>
                            <li><a href={{ route('client.introduce') }}>Giới thiệu</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="{{ route('client.shopping.cart') }}"><i class="fa fa-shopping-bag"></i> <span id="qty_cart">{{ Session::has('cart') ? Session::get('cart')->totalQty : 0 }}</span></a></li>
                        </ul>
                        <div class="header__cart__price">Tổng: <span id="price_cart">{{ Session::has('cart') ? number_format(Session::get('cart')->totalPrice,-3,',',',') : 0 }} VND</span></div>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->

    @yield('main')

    <!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="{{ route('client.home') }}">
                                <img src="{{ asset($setting->logo) }}" alt="">
                            </a>
                        </div>
                        <ul>
                            <li style="font-size: 13px;">Địa chỉ: {{ $setting->address }}</li>
                            <li style="font-size: 13px;">Số điện thoại: {{ $setting->tel }}</li>
                            <li style="font-size: 13px;">Email: {{ $setting->email }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-6 offset-lg-1">
                    <div class="footer__widget">
                        <br>
                        <h6>Về cửa hàng</h6>
                        <hr color="bold">
                        <ul>
                            <li><a href="{{ route('client.introduce') }}">Giới thiệu</a></li>
                            <li><a href="https://timviec.com.vn/trang-vang-viet-nam-tuyen-dung-8146" target="_blank">Tuyển dụng</a></li>
                            <li><a href="https://work247.vn/quy-dinh-bao-mat.html" target="_blank">Chính sách bảo mật</a></li>
                            <li><a href="#">Chính sách hàng nhập khẩu</a></li>
                            <li><a href="#">Điều khoản sử dụng</a></li>
                            <li><a href="#">Điều kiện vận chuyển</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Hướng dẫn trả góp</a></li>
                            <li><a href="#">Chính sách đổi trả</a></li>
                            <li><a href="#">Phương thức vận chuyển</a></li>
                            <li><a href="#">Hướng dẫn đặt hàng</a></li>
                            <li><a href="#">Gửi yêu cầu hỗ trợ</a></li>
                        </ul>
                    </div>
                    
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="footer__widget">
                        <br>
                        <h6>Liên hệ</h6>
                        <hr color="bold">
                        <div class="footer__widget__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram" ></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1003450.3275757502!2d106.03564484250975!3d10.755445959833029!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529292e8d3dd1%3A0xf15f5aad773c112b!2sHo%20Chi%20Minh%20City%2C%20Vietnam!5e0!3m2!1sen!2s!4v1694408795163!5m2!1sen!2s" width="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="mt-3"></iframe>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text"><p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright ©<script>document.write(new Date().getFullYear());</script> | Bản quyền thuộc cửa hàng
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="{{ asset('client/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('client/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('client/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('client/js/mixitup.min.js') }}"></script>
    <script src="{{ asset('client/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('client/js/main.js') }}"></script>
    <script src="{{ asset('client/js/add-to-cart.js') }}"></script>
    <script src="{{ asset('client/js/filter.js') }}"></script>
    <script src="{{ asset('client/js/sort.js') }}"></script>
    <script src="{{ asset('client/js/cart.js') }}"></script>
</body>

</html>