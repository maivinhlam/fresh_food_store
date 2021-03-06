<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\Brand;
use App\Models\Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\New_;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perpage = 20;
        if($request->perPage)
        {
            $perpage = $request->perPage;
        }
        $producttypes = ProductType::all();
        $brands = Brand::all();
        $products = Product::paginate($perpage);
        foreach ($products as $product) {
            $product->brand_name = $product->brand->name;
            $product->type_name = $product->type->name;
            $product->creator_name = $product->creator->name;
            $product->articles = $product->articles;
        }
        $title = 'Products';
        return view('admin.product.home',
        [
            'products'      => $products,
            'title'         => $title,
            'producttypes'  => $producttypes,
            'brands'        => $brands
        ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->type_id = $request->type_id;
        $product->brand_id = $request->brand_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->supplier_id = 1;
        $product->sell_percen = $request->sell_percen;
        $product->amount = $request->amount;
        $product->description = $request->description;
        $product->image_path = $request->image_link;
        $product->view_count = 0;
        $product->creator_id = Auth::guard('admin')->user()->id;

        if ($request->hasFile('image_path')) {
            $this->validate($request, [
                'file' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            $file = $request->file('image_path');
            $name = time().'.'.$file->getClientOriginalExtension();
            $path = $file->move('images/products', $name);
            $product->image_path = '/'.$path;
        }

        $status = $product->save();

        $producttype = ProductType::find($request->type_id);
        $producttype->increment('product_count');
        $brand = Brand::find($request->brand_id);
        $brand->increment('product_count');

        if($status) {
            $articles = new Articles;
            $articles->product_id = $product->id;
            $articles->save();
        }

        if($status) {
            return response()->json(['success'=>"Added new product $product->name success."]);
        } else {
            return response()->json(['error'=>"Error when add new product $product->name"]);
        }
        //return redirect()->back()->with('success', "Create $product->name success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->type_id = $request->type;
        $product->brand_id = $request->brand;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->sell_percen = $request->sell_percen;
        $product->amount = $request->amount;
        $product->description = $request->description;
        $product->image_path = $request->image_link;
        $product->creator_id = Auth::guard('admin')->user()->id;

        if ($request->hasFile('image_path')) {
            echo "hasFile";
            $this->validate($request, [
                'file' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);
            $file = $request->file('image_path');
            $name = time().'.'.$file->getClientOriginalExtension();
            $path = $file->move('images/products', $name);

            File::delete($product->image_path);
            $product->image_path = '/'.$path;
        }

        $status = $product->save();
        return redirect()->back()->with('success', "Update $product->name success");
        // return Redirect::back()->withErrors(['msg', 'The Message']);
        // @if($errors->any())
        // <h4>{{$errors->first()}}</h4>
        // @endif
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        File::delete($product->image_path);
        $product->delete();
        return redirect()->back()->with('success', "Delete $product->name success");
    }
}
