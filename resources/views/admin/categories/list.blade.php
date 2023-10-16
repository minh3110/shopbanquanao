@extends('admin.layouts.index')


@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Danh mục sản phẩm
                    <small>Danh sách</small>
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
            </div>
            <!-- /.col-lg-12 -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ảnh danh mục</th>
                        <th>Tên danh mục</th>
                        <th>Trạng thái</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @php $count = 1; @endphp
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $count }}</td>
                            <td><img src="{{ asset($category['image']) }}" width=60px ></td>
                            <td>{{ $category['name'] }}</td>
                            <td>{{ $category->status == 1 ? 'Hiện' : 'Ẩn' }}</td>
                            <td>
                                <a href="{{ route('category.delete',['id'=>$category['id']]) }}" onclick="return confirm('Bạn muốn xóa item này ?')"><i class="fa fa-times" aria-hidden="true"></i></a>
                                <a href="{{ route('category.edit.form',['id'=>$category['id']]) }}" style="margin:0 1rem;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                @if ($category->status == 1)
                                    <a href="{{ route('category.update.status',['id' => $category->id, 'status' => 0]) }}" onclick="return confirm('Bạn muốn ẩn danh mục sản phẩm này ?')">
                                        <i class="fa fa-ban" aria-hidden="true"></i>
                                    </a>
                                @else
                                    <a href="{{ route('category.update.status',['id' => $category->id, 'status' => 1]) }}">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @php $count++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection