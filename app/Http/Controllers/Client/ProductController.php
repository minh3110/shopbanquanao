<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function product() {
        $products = Product::where('qty','>',0)->where('status',1)->paginate(12);
        $product_slide_1 = Product::where('qty','>',0)->where('status',1)->orderBy('id', 'DESC')->limit(3)->get();
        $product_slide_2 = Product::where('qty','>',0)->where('status',1)->orderBy('id', 'DESC')->skip(3)->limit(3)->get();
        return view('client.product-grid', compact('products', 'product_slide_1', 'product_slide_2'));
    }

    public function product_detail($id) {
        $product = Product::where('products.id', $id)->where('products.status',1)->join('categories','products.category_id','=','categories.id')
        ->join('suppliers','products.supplier_id','=','suppliers.id')
        ->select(['products.*','categories.name AS cate_title','suppliers.name AS supplier_title'])->first();
        $products = Product::where('category_id',$product->category_id)->where('qty','>',0)->where('products.id','<>',$id)->where('products.status',1)->limit(4)->get();
        return view('client.product-detail', compact('product', 'products'));
    }

    public function search(Request $request)
    {
        $q = $request->input('q');
        if (!is_null($q)) {
            $products = Product::where([['qty','>',0],['name','like','%'.$q.'%']])->where('status',1)->paginate(12);
        } else {
            $products = Product::where('qty','>',0)->where('status',1)->paginate(12);
        }
        $product_slide_1 = Product::where('qty','>',0)->orderBy('id', 'DESC')->where('status',1)->limit(3)->get();
        $product_slide_2 = Product::where('qty','>',0)->orderBy('id', 'DESC')->where('status',1)->skip(3)->limit(3)->get();
        return view('client.search',compact('products', 'product_slide_1', 'product_slide_2', 'q'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product,$product->id,$request->color,$request->size);
        $request->session()->put('cart',$cart);
        return response()->json([
            'status' => 200,
            'qty'    => Session::get('cart')->totalQty,
            'price'  => Session::get('cart')->totalPrice
        ]);
    }

    public function deleteItem($id, $color, $size)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->deleteItem($id, $color, $size);
        if(count($cart->items) > 0){
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }
        return redirect()->back();
    }

    public function filter(Request $request)
    {
        if ($request->id != 0) {
            $products = Product::where('category_id',$request->id)->where('qty','>',0)->where('status',1)->paginate(12);
        } else {
            $products = Product::where('qty','>',0)->where('status',1)->paginate(12);
        }
        return response()->json([
            'status' => 200,
            'data'   => view('client.includes.product-grid', compact('products'))->render()
        ]);
    }

    public function sort(Request $request)
    {
        if ($request->sort == 0) {
            $products = Product::where('qty','>',0)->where('status',1)->paginate(12);
        } elseif ($request->sort == 1) {
            $products = Product::where('qty','>',0)->where('status',1)->orderBy('price','DESC')->paginate(12);
        } else {
            $products = Product::where('qty','>',0)->where('status',1)->orderBy('price','ASC')->paginate(12);
        }
        return response()->json([
            'status' => 200,
            'data'   => view('client.includes.product-grid', compact('products'))->render()
        ]);
    }

    public function category($category)
    {
        $products = Product::where('qty','>',0)->where('category_id',$category)->where('status',1)->paginate(12);
        return view('client.product-category',compact('products', 'category'));
    }

    public function changeQty(Request $request)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->changeQty($request);
        Session::put('cart', $cart);
        return response()->json([
            'status' => 200,
            'price'  => number_format($cart->items[$request->id . '_' . $request->color . '_' . $request->size]['price'],-3,',',',') . ' VND',
            'totalQty' => $cart->totalQty,
            'totalPrice' => number_format($cart->totalPrice,-3,',',',') . ' VND',
            'productId' => $request->id . '_' . $request->color . '_' . $request->size
        ]);
    }
}
