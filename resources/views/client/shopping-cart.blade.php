@extends('client.layouts.template')

@section('main')

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('client/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Giỏ hàng</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('client.home') }}">Trang chủ</a>
                        <span>Giỏ hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if(Session::has('invalid'))
                    <div class="alert alert-danger alert-dismissible mt-2">
                         <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                         {{Session::get('invalid')}}
                    </div>
                @endif
                @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible mt-2">
                            <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{Session::get('success')}}
                        </div>
                @endif
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Sản phẩm</th>
                                <th>Màu sắc</th>
                                <th>Size</th>
                                <th width="200">Đơn giá</th>
                                <th>Số lượng</th>
                                <th width="350">Tổng tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                use App\Models\Cart;
                                $oldCart = Session::get('cart');
                                $cart = new Cart($oldCart);
                            @endphp
                            @if (!empty($cart->items))
                                @foreach ($cart->items as $key => $row)
                                    @php
                                        $keyColor = explode('_', $key)[1];
                                        $keySize = explode('_', $key)[2];
                                    @endphp
                                    <tr>
                                        <td class="shoping__cart__item">
                                            <img src="{{  asset($row['item']['image']) }}" alt="{{ $row['item']['name'] }}" width="100">
                                            <h5 class="mt-3">{{ $row['item']['name'] }}</h5>
                                        </td>
                                        <td class="shoping__cart__quantity" style="font-weight: normal;">
                                            @php
                                                $color = \App\Models\Color::find($keyColor);
                                            @endphp
                                            <div style="background-color: {{ $color->hex }};width: 50px;height:50px;border-radius: 100%;border: 1px solid black;margin:0 auto;"></div> {{ $color->name }}
                                        </td>
                                        <td class="shoping__cart__quantity" style="font-weight: normal;">
                                            @php
                                                $size = \App\Models\Size::find($keySize);
                                            @endphp
                                            {{ $size->name }}
                                        </td>
                                        <td class="shoping__cart__price">
                                            {{ number_format($row['item']['price'],-3,',',',') }} VND
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="text" value="{{ $row['qty'] }}" onkeyup="changeQty(this.value, {{ $row['item']['id'] }}, {{ $keyColor }}, {{ $keySize }})">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="shoping__cart__total" id="cart-item-total-{{ $row['item']['id'] . '_' . $keyColor . '_' . $keySize }}">
                                            {{ number_format($row['price'],-3,',',',') }} VND
                                        </td>
                                        <td class="shoping__cart__item__close">
                                            <a href="{{ route('delete.item', ['id' => $row['item']['id'], 'color' => $keyColor, 'size' => $keySize]) }}" onclick="return confirm('Bạn có muốn xóa sản phẩm này khỏi giỏ hàng ?')"><span class="icon_close"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" align="center">Chưa có sản phẩm</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="{{ route('client.product') }}" class="primary-btn cart-btn">TIẾP TỤC MUA HÀNG</a>
                </div>
            </div>
            @if (!empty($cart->items))
                <div class="col-lg-6">
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Giỏ hàng</h5>
                        <ul>
                            <li id="cart-total">Tổng tiền <span>{{ number_format(Session::get('cart')->totalPrice,-3,',',',') }} VND</span></li>
                        </ul>
                        @if (Auth::check())
                            <a href="{{ route('client.checkout') }}" class="primary-btn">THANH TOÁN COD</a>
                            <br>
                            <a href="{{ route('client.checkout.paypal') }}" class="paypal-button">
                                <span class="paypal-button-title">
                                    THANH TOÁN BẰNG&nbsp;
                                </span>
                                <span class="paypal-logo">
                                    <i>Pay</i><i>Pal</i>
                                </span>
                            </a>
                        @else
                            <a href="{{ route('auth.show.login') }}" class="primary-btn">VUI LÒNG ĐĂNG NHẬP</a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- Shoping Cart Section End -->
@stop