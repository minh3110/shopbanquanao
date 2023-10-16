@extends('admin.layouts.index')


@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Sản phẩm
                <small>Chi tiết</small>
            </h1>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th>Ảnh sản phẩm</th>
                <td><img src="{{ asset($product->image) }}" width="200"></td>
            </tr>
            <tr>
                <th>Tên sản phẩm</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th>Giá tiền</th>
                <td>{{ number_format($product->price,-3,',',',') }} VND</td>
            </tr>
            <tr>
                <th>Danh mục sản phẩm</th>
                <td>{{ $product->category->name }}</td>
            </tr>
            <tr>
                <th>Nhà cung cấp</th>
                <td>{{ $product->supplier->name }}</td>
            </tr>
            <tr>
                <th>Giá tiền</th>
                <td>{{ number_format($product->price,-3,',',',') }} VND</td>
            </tr>
            <tr>
                <th>Số lượng</th>
                <td>{{ $product->qty }}</td>
            </tr>
            <tr>
                <th>Số lượng bán</th>
                <td>{{ $product->qty_buy }}</td>
            </tr>
            <tr>
                <th>Trạng thái</th>
                <td>{{ $product->status == 1 ? 'Hiện' : 'Ẩn' }}</td>
            </tr>
            <tr>
                <th>Mô tả sản phẩm</th>
                <td>{!! $product->description ?? 'N/A' !!}</td>
            </tr>
            <tr>
                <th>Màu sắc</th>
                <td>
                    @php
                        $colors = [];
                        foreach (explode(',', $product->colors) as $item) {
                            $colors[] = \App\Models\Color::find($item)->name;
                        }

                        echo implode(', ', $colors);
                    @endphp
                </td>
            </tr>
            <tr>
                <th>Kích thước</th>
                <td>
                    @php
                        $sizes = [];
                        foreach (explode(',', $product->sizes) as $item) {
                            $sizes[] = \App\Models\Size::find($item)->name;
                        }

                        echo implode(', ', $sizes);
                    @endphp
                </td>
            </tr>
        </table>
    </div>
    </div>
</div>
@endsection
