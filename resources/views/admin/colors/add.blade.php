@extends('admin.layouts.index')


@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Màu sắc
                    <small>Thêm</small>
                </h1>
                <form action="{{ route('color.add') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="form-group">
                        <label for="name">Tên màu mắc: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Nhập tên màu sắc" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="hex">Mã màu: <span class="text-danger">*</span></label>
                        <input type="color" class="form-control" placeholder="Nhập mã màu" id="hex" name="hex" style="width: 10%;" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                  </form>
            </div>
        </div>
    </div>    
</div>
@endsection