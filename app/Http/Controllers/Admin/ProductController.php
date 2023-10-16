<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Color;
use App\Models\Size;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::select(
        'select p.*,c.name cate_title, s.name supplier_title from products p,categories c,suppliers s
         where p.category_id = c.id and p.supplier_id = s.id'
        );
        return view('admin.products.list',['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.products.add',['categories'=>$categories, 'suppliers' => $suppliers, 'colors' => $colors, 'sizes' => $sizes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            //  Let's do everything here
            if ($request->file('image')->isValid()) {
                //
                $validated = $request->validate([
                    'title' => 'required',
                    'price' => 'required',
                    'category_id' => 'required',
                    'supplier_id' => 'required',
                    'quantity' => 'required'
                ]);
                $request->image->storeAs('/public/images/products', $request->image->getClientOriginalName());
                Product::create([
                   'name' => $validated['title'],
                   'price' => $validated['price'],
                   'category_id' => $validated['category_id'],
                   'image' => '/storage/images/products/' . $request->image->getClientOriginalName(),
                   'description' => $request->input('content'),
                   'view' => $request->input('view'),
                   'supplier_id' => $validated['supplier_id'],
                   'qty' => $validated['quantity'],
                   'colors' => implode(', ', $request->colors),
                   'sizes' => implode(', ', $request->sizes)
                ]);
                return redirect()->route('product.list')->with("success","Lưu thành công");
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::find($id);
        $suppliers = Supplier::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.products.edit',['product' => $product,'categories'=>$categories, 'suppliers' => $suppliers, 'colors' => $colors, 'sizes' => $sizes]);
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
        
        $product = Product::find($id);
        if ($request->hasFile('image')) {
            //  Let's do everything here
            if ($request->file('image')->isValid()) {
                $request->image->storeAs('/public/images/products', $request->image->getClientOriginalName());
                $product->image = '/storage/images/products/' .  $request->image->getClientOriginalName();
            }
        }
        $product->name = $request->input('title');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->description = !empty($request->input('content')) ? $request->input('content'):'';
        $product->supplier_id = $request->input('supplier_id');
        $product->qty = $request->input('quantity');
        $product->colors = implode(', ', $request->colors);
        $product->sizes = implode(', ', $request->sizes);
        $product->save();
        return redirect()->route('product.list')->with("success","Sửa thành công");
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('product.list')->with("success","Xóa thành công");
    }

    public function updateStatus($id, $status)
    {
        $product = Product::find($id);
        $product->status = $status;
        $product->save();
        return redirect()->route('product.list')->with("success","Cập nhật trạng thái thành công");
    }

    public function show($id)
    {
        $product = Product::find($id); 
        return view('admin.products.show', compact('product'));
    }
}
