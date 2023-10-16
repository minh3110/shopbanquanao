@extends('admin.layouts.index')


@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Đơn hàng
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
                        <tr align="center">
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đặt hàng</th>
                            <th>Trạng thái</th>
                            <th>Phương thức thanh toán</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ number_format($row->total,-3,',',',') }} VND</td>
                                <td>{{ date('d/m/Y H:i:s',strtotime($row->created_at)) }}</td>
                                <td>
                                    @if ($row->status === 0)
                                        {{ 'Chờ xác nhận' }}
                                    @elseif ($row->status === 1)
                                        {{ 'Xác nhận' }}
                                    @elseif ($row->status === 2)
                                        {{ 'Hoàn thành' }}
                                    @elseif ($row->status === 3)
                                        {{ 'Hủy' }}
                                    @endif
                                </td>
                                <td>{{ $row->payment_method == 0 ? 'Thanh toán cod' : 'Thanh toán online' }}</td>
                                <td>
                                    <a href="{{ route('order.show', ['id' => $row->id]) }}" style="margin-right:1rem;"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href="{{ route('order.print', ['id' => $row->id]) }}" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection