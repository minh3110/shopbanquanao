<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Size::all();

        return view('admin.sizes.list', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sizes.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Size::create([
            'name' => $request->name,
        ]);

        return redirect()->route('size.list')->with("success","Lưu thành công");;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $size = Size::find($id);

        return view('admin.colors.edit', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $size = Size::find($id);
        $size->name = $request->name;
        $size->save();

        return redirect()->route('size.list')->with("success","Sửa thành công");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $size = Size::find($id);
        $cart = session('cart');
        $products = Product::all();
        if ($cart && $cart->items) {
            foreach ($cart->items as $key => $row) {
                $keySize = explode('_', $key)[2];
                if ($id == $keySize) {
                    $price = $cart->items[$key]['price'];
                    $cart->totalPrice -= $price;
                    unset($cart->items[$key]);
                    Session::put('cart', $cart);
                }
            }
        }
        foreach ($products as $product) {
            $sizes = array_map('intval', explode(', ', $product->sizes));

            if (in_array($id, $sizes)) {
                $newSizes = array_diff($sizes, [$id]);
                if (empty($newSizes)) {
                    return redirect()->route('size.list')->with("invalid","Bạn không thể xóa kích thước này vì 1 số sản phẩm tối thiểu phải có 1 kích thước");
                }
                Product::where('id', $product->id)->update(['sizes' => implode(', ', $newSizes)]);
            }
        }
        $size->delete();

        return redirect()->route('size.list')->with("success","Xóa thành công");
    }
}