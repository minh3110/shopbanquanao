@extends('admin.layouts.index')


@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Trang web
                    <small>Thiết lập</small>
                </h1>
                @if(Session::has('invalid'))
                    <div class="alert alert-danger alert-dismissible">
                        <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{Session::get('invalid')}}
                    </div>
                @endif
               @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible">
                         <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                         {{Session::get('success')}}
                    </div>
               @endif
                <form action="{{ route('setting.edit', ['id' => $setting['id']]) }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">
                        <label for="email">Email: <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" placeholder="Nhập email" id="email" name="email" value="{{ $setting['email'] }}">
                    </div>
                    <div class="form-group">
                        <label for="tel">Số điện thoại: <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" placeholder="Nhập số điện thoại" id="tel" name="tel" value="{{ $setting['tel'] }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Nhập địa chỉ" id="address" name="address" value="{{ $setting['address'] }}">
                    </div>
                    <div class="form-group">
                        <label for="image">Chọn hình ảnh:</label>
                        <div class="custom-file">
                            <input type="file" id="image" name="image" accept=".png,.gif,.jpg,.jpeg" />
                        </div>
                    </div>
                    <div class="image-preview mb-4" id="imagePreview">
                        <img src="{{ asset($setting['logo']) }}" alt="Image Preview" class="image-preview__image" style="display:block;" />
                        <span class="image-preview__default-text" style="display:none;">Hình ảnh</span>
                    </div>
                    <br />
                    <div class="form-group">
                        <button type="submit"
                                class="btn btn-primary">
                            Cập nhật
                        </button>
                    </div>
                  </form>
            </div>
        </div>
    </div>    
</div>
@endsection