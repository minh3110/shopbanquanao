@extends('admin.layouts.index')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Thống kê
                        <small>Đơn hàng</small>
                    </h1>
                </div>
                <form action="{{ route('filter.order') }}" method="GET" enctype="multipart/form-data">

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="start_date">Ngày bắt đầu: <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $request->start_date }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="end_date">Ngày kết thúc: <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $request->end_date }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="status">Trạng thái:</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="-1" {{ $request->status == -1 ? 'selected' : '' }}>Tất cả</option>
                                        <option value="0"  {{ $request->status == 0 ? 'selected' : '' }}>Chờ xác nhận</option>
                                        <option value="1"  {{ $request->status == 1 ? 'selected' : '' }}>Xác nhận</option>
                                        <option value="2"  {{ $request->status == 2 ? 'selected' : '' }}>Hoàn thành</option>
                                        <option value="3"  {{ $request->status == 3 ? 'selected' : '' }}>Hủy</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </form>
                @if (isset($orders))
                    <div class="col-lg-12" style="margin-top:1rem;">
                        <a href="{{ route('order.export.excel') }}" class="btn btn-primary" style="margin-bottom:1rem;">Xuất file excel</a>
                        @include('admin.dashboard.includes.order', compact('orders'))
                    </div>
                @endif
            </div>
            <!-- /.row -->
        </div>
    </div>
@endsection