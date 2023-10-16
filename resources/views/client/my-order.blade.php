@extends('client.layouts.template')

@section('main')

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('client/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Hóa đơn của tôi</h2>
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
                            <th>ID</th>
                            <th>Tổng tiền</th>
                            <th>Địa chỉ</th>
                            <th>Trạng thái</th>
                            <th>Phương thức thanh toán</th>
                            <th>Thời gian đặt hàng</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ number_format($order->total,-3,',',',') }} VND</td>
                                <td>{{ $order->address }}</td>
                                <td>
                                    @php
                                        if ($order->status == 0) {
                                            echo 'Chờ xác nhận';
                                        } elseif ($order->status == 1) {
                                            echo 'Xác nhận';
                                        } elseif ($order->status == 2) {
                                            echo 'Hoàn thành';
                                        } else {
                                            echo 'Hủy';
                                        }
                                    @endphp
                                </td>
                                <td>{{ $order->payment_method == 0 ? 'Thanh toán cod' : 'Thanh toán online' }}</td>
                                <td>{{ date('d/m/Y H:i:s', strtotime($order->created_at)) }}</td>
                                <td>
                                    <a href="{{ route('my.order.show', ['id' => $order->id]) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@stop