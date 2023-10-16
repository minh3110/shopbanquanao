<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Order;
use App\Models\User;

class OrderExport implements FromCollection,WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

   /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $startDate = $this->data['start_date'];
        $endDate = $this->data['end_date'];
        $status = $this->data['status'];
        if ($status == -1) {
            $orders = Order::whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
        } else {
            $orders = Order::whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', $status)
            ->get();
        }
        foreach ($orders as $order) {
            $order->order_id = $order['id'];
            $order->total_order = number_format($order['total'],-3,',',',') . ' VND';
            $order->address_order = $order['address'];
            $order->user = User::find($order['user_id'])->name;
            $order->start_date = date('d/m/Y H:i:s',strtotime($order['created_at']));
            if ($order->status === 0) {
                $status = 'Chờ xác nhận';
            } elseif ($order->status === 1) {
                $status = 'Xác nhận';
            } elseif ($order->status === 2) {
                $status = 'Hoàn thành';
            } else {
                $status = 'Hủy';
            }

            $order->status_order = $status;
            $order->method = $order->payment_method == 0 ? 'Thanh toán cod' : 'Thanh toán online';
            unset($order['id'], $order['total'], $order['address'], $order['user_id'], $order['created_at'], $order['updated_at'], $order['status'], $order['payment_method']);
        }
        return $orders;
    }

    public function headings():array
    {
        return [
            'Mã đơn hàng',
            'Tổng tiền',
            'Địa chỉ',
            'Khách hàng',
            'Ngày đặt hàng',
            'Trạng thái',
            'Phương thức thanh toán'
        ];
    }
}