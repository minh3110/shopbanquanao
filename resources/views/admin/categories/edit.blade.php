@extends('admin.layouts.index')


@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Danh mục sản phẩm
                    <small>Sửa</small>
                </h1>
                <form action="{{ route('category.edit',['id' => $category['id']]) }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">
                        <label for="category-name">Tên danh mục: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Nhập tên danh mục" id="category-name" name="category-name" value="{{ $category['name'] }}" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Chọn hình ảnh:</label>
                        <div class="custom-file">
                            <input type="file" id="image" name="image" accept=".png,.gif,.jpg,.jpeg" />
                        </div>
                    </div>
                    <div class="image-preview mb-4" id="imagePreview">
                        <img src="{{ asset($category['image']) }}" alt="Image Preview" class="image-preview__image" style="display:block;" />
                        <span class="image-preview__default-text" style="display:none;">Hình ảnh</span>
                    </div>
                    <br />
                    <button type="submit" class="btn btn-primary">Sửa</button>
                  </form>
            </div>
        </div>
    </div>   
</div>
@endsection