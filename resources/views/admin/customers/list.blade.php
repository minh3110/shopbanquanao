@extends('admin.layouts.index')


@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Người dùng
                    <small>Danh sách</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>#</th>
                        <th>Tài khoản người dùng</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Giới tính</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @php $count = 1; @endphp
                    @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer['id'] }}</td>
                                <td>{{ $customer['name'] }}</td>
                                <td>{{ $customer['email'] }}</td>
                                <td>{{ $customer['phone'] }}</td>
                                <td>{{ $customer['sex'] == 0 ? 'Nam' : 'Nữ' }}</td>
                                <td><a href="{{ route('customer.delete',['id'=>$customer['id']]) }}"  onclick="return confirm('Bạn có muốn xóa tài khoản này, nếu xóa thì mọi đơn hàng liên quan cũng sẽ bị xóa ?')"><i class="fa fa-times" aria-hidden="true"></i></a>
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