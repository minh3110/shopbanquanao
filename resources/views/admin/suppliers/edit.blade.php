@extends('admin.layouts.index')


@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Nhà cung cấp
                    <small>Sửa</small>
                </h1>
                <form action="{{ route('supplier.edit', ['id' => $supplier->id]) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="form-group">
                        <label for="name">Tên nhà cung cấp: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Nhập tên nhà cung cấp" id="name" name="name" value="{{ $supplier->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" placeholder="Nhập email" id="email" name="email" value="{{ $supplier->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại: <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" placeholder="Nhập số điện thoại" id="phone" name="phone" pattern="[0-9]{10}" value="{{ $supplier->phone }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Sửa</button>
                  </form>
            </div>
        </div>
    </div>    
</div>
@endsection