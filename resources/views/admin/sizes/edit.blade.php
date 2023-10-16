@extends('admin.layouts.index')


@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Size
                    <small>Sửa</small>
                </h1>
                <form action="{{ route('size.edit',['id' => $size['id']]) }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">
                        <label for="name">Size: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Nhập size" id="name" name="name" value="{{ $size->name }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Sửa</button>
                  </form>
            </div>
        </div>
    </div>   
</div>
@endsection