@extends('client.layouts.template')

@section('main')

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('client/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Mã đơn hàng: {{ $id }}</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Section Begin -->
<section class="product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Sản phẩm</th>
                            <th>Màu sắc</th>
                            <th>Size</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $count }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ \App\Models\Color::find($order->color_id)->name }}</td>
                                <td>{{ \App\Models\Size::find($order->size_id)->name }}</td>
                                <td>{{ $order->qty }}</td>
                                <td>{{ number_format($order->price,-3,',',',') }} VND</td>
                            </tr>
                            @php
                                $count++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@stop