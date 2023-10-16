<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.dashboard.index', compact('request'));
    }

    public function fillterOrder(Request $request)
    {
       $startDate = $request->start_date;
       $endDate = $request->end_date;
       $status = $request->status;
       if ($status == -1) {
            $orders = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
       } else {
            $orders = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', $status)
            ->get();
       }
       return view('admin.dashboard.index', compact('orders', 'request'));
    }

    public function exportExcel()
    {
        $url = url()->previous();
        $url_components = parse_url($url);
        parse_str($url_components['query'], $params);
        return Excel::download(new OrderExport($params), 'orders.xlsx');
    }
}
