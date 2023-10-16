<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\ExpressCheckout;

class OrderController extends Controller
{
    public function shopping_cart() {
        return view('client.shopping-cart');
    }

    public function checkout() {
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        foreach ($cart->items as $row) {
            $product = Product::find($row['item']['id']);
            if ($product->qty < $row['qty']) {
                return redirect()->back()->with('invalid', 'Sản phẩm '. $product->name . ' chỉ còn ' . $product->qty . ' cái, không đủ để mua');
            }
        }
        return view('client.checkout');
    }

    public function checkoutPaypal() {
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        foreach ($cart->items as $row) {
            $product = Product::find($row['item']['id']);
            if ($product->qty < $row['qty']) {
                return redirect()->back()->with('invalid', 'Sản phẩm '. $product->name . ' chỉ còn ' . $product->qty . ' cái, không đủ để mua');
            }
        }
        return view('client.checkout-paypal');
    }

    /**
     * Pay
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request){
        if(!Session::has('cart')){
            return view('cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        try {
            $order = Order::create([
                'id'      => 'order_' . rand(100000,999999),
                'user_id' => Auth::user()->id,
                'total'   => Session::get('cart')->totalPrice,
                'address' => $request->address
            ]);
            foreach($cart->items as $key => $row){
                $keyColor = explode('_', $key)[1];
                $keySize = explode('_', $key)[2];
                OrderDetail::create([
                    'product_id' => $row['item']['id'],
                    'price' => $row['price'],
                    'qty' => $row['qty'],
                    'order_id' => $order->id,
                    'color_id' => $keyColor,
                    'size_id' => $keySize
                ]);
                $product = Product::find($row['item']['id']);
                Product::where('id',$row['item']['id'])->update(['qty' => $product['qty'] - $row['qty']]);
                Product::where('id',$row['item']['id'])->update(['qty_buy' => $product['qty_buy'] + $row['qty']]);
                if ($product->qty <= 0) {
                    Product::where('id',$row['item']['id'])->update(['status' => 0]);
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('client.checkout')->with('invalid', $e->getMessage());
        }
        Session::forget('cart');
        return redirect()->route('thank');
    }

    public function thank()
    {
        return view('client.thank');
    }

    public function myOrder()
    {
        $orders = Order::where('user_id',Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        return view('client.my-order',compact('orders'));
    }

    public function showMyOrder($id)
    {
        $orders = OrderDetail::where('order_id',$id)
        ->join('products','products.id','=','orders_detail.product_id')
        ->get(['orders_detail.*','products.name','products.price']);
        return view('client.show-my-order',compact('orders','id'));
    }

    public function cancelPaymentPaypal()
    {
        return redirect()->route('client.checkout.paypal')->with('invalid', 'Bạn đã hủy đơn hàng !');
    }
  
    public function donePaymentPaypal(Request $request)
    {
        $paypalModule = new ExpressCheckout;
        $response = $paypalModule->getExpressCheckoutDetails($request->token);
  
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            Session::forget('cart');
            return redirect()->route('thank');
        }
    }

    public function handlePaypal(Request $request) {
        if(!Session::has('cart')){
            return view('cart');
        }
        $products = [];
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        try {
            $order = Order::create([
                'id'      => 'order_' . rand(100000,999999),
                'user_id' => Auth::user()->id,
                'total'   => Session::get('cart')->totalPrice,
                'address' => $request->address,
                'payment_method' => 1
            ]);
            foreach($cart->items as $key => $row){
                $keyColor = explode('_', $key)[1];
                $keySize = explode('_', $key)[2];
                OrderDetail::create([
                    'product_id' => $row['item']['id'],
                    'price' => $row['price'],
                    'qty' => $row['qty'],
                    'order_id' => $order->id,
                    'color_id' => $keyColor,
                    'size_id' => $keySize
                ]);
                $product = Product::find($row['item']['id']);
                Product::where('id',$row['item']['id'])->update(['qty' => $product['qty'] - $row['qty']]);
                Product::where('id',$row['item']['id'])->update(['qty_buy' => $product['qty_buy'] + $row['qty']]);
                if ($product->qty <= 0) {
                    Product::where('id',$row['item']['id'])->update(['status' => 0]);
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('client.checkout.paypal')->with('invalid', $e->getMessage());
        }

        foreach($cart->items as $row){
            $productDetail = Product::find($row['item']['id']); 
            $products['items'][] = [
                'name' => $productDetail->name,
                'price' => $row['item']['price'],
                'qty' => $row['qty']
            ];
        }
  
        $products['invoice_id'] = $order->id;
        $products['invoice_description'] = "Pay successful, you get the new Order#{$order->id}";
        $products['return_url'] = route('done.payment.paypal');
        $products['cancel_url'] = route('cancel.payment.paypal');
        $products['total'] = Session::get('cart')->totalPrice;
  
        $paypalModule = new ExpressCheckout;
  
        $res = $paypalModule->setExpressCheckout($products);
        $res = $paypalModule->setExpressCheckout($products, true);
  
        return redirect($res['paypal_link']);
    }
}
