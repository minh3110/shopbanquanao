<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::all();

        return view('admin.colors.list', compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.colors.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Color::create([
            'name' => $request->name,
            'hex' => $request->hex
        ]);

        return redirect()->route('color.list')->with("success","Lưu thành công");;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $color = Color::find($id);

        return view('admin.colors.edit', compact('color'));
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
        $color = Color::find($id);
        $color->name = $request->name;
        $color->hex = $request->hex;
        $color->save();

        return redirect()->route('color.list')->with("success","Sửa thành công");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $color = Color::find($id);
        $cart = session('cart');
        $products = Product::all();
        if ($cart && $cart->items) {
            foreach ($cart->items as $key => $row) {
                $keyColor = explode('_', $key)[1];
                if ($id == $keyColor) {
                    $price = $cart->items[$key]['price'];
                    $cart->totalPrice -= $price;
                    unset($cart->items[$key]);
                    Session::put('cart', $cart);
                }
            }
        }

        foreach ($products as $product) {
            $colors = array_map('intval', explode(', ', $product->colors));
            if (in_array($id, $colors)) {
                $newColors = array_diff($colors, [$id]);
                if (empty($newColors)) {
                    return redirect()->route('color.list')->with("invalid","Bạn không thể xóa màu sắc này vì 1 số sản phẩm tối thiểu phải có 1 màu sắc");
                }
                Product::where('id', $product->id)->update(['colors' => implode(', ', $newColors)]);
            }
        }
        $color->delete();

        return redirect()->route('color.list')->with("success","Xóa thành công");
    }
}