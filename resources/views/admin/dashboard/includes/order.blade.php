<h4 class="text-danger">Tổng doanh thu: 
    @php 
        $total = 0;
        foreach ($orders as $row) {
            $total += $row->total;
        }
        echo number_format($total,-3,',',',') . ' VND';
    @endphp
</h4>
<table class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
        <tr align="center">
            <th>Mã đơn hàng</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Ngày đặt hàng</th>
            <th>Trạng thái</th>
            <th>Phương thức thanh toán</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $row)
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ \App\Models\User::find($row->user_id)->name }}</td>
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
            </tr>
        @endforeach
    </tbody>
</table>