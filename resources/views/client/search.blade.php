@extends('client.layouts.template')

@section('main')

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('client/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Tìm từ khóa với {{ $q }}</h2>
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
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{  asset($product->image) }}">
                                    <ul class="product__item__pic__hover">
                                        <li><a href="javascript:void(0)" onclick="addToCart({{ $product->id }});"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="{{ route('client.product.detail', ['id' => $product->id]) }}">{{ $product->name }}</a></h6>
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div>Màu sắc</div>
                                                    <select class="form-control" id="color-{{ $product->id }}">
                                                        @foreach (explode(',', $product->colors) as $item)
                                                            @php
                                                                $color = \App\Models\Color::find($item);
                                                            @endphp
                                                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <div>Size</div>
                                                    <select class="form-control" id="size-{{ $product->id }}">
                                                        @foreach (explode(',', $product->sizes) as $item)
                                                            @php
                                                                $size = \App\Models\Size::find($item);
                                                            @endphp
                                                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <h5 class="text-danger">{{ number_format($product->price,-3,',',',') }} VND</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@stop