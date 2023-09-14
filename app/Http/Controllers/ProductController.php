<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product.index')->with('products', $products);
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'price' => 'required',
            'stock' => 'required',

        ],[
            'name.required' => 'Name is required',
            'desc.required' => 'Description is required',
            'price.required' => 'Price is required',
            'stock.required' => 'Stock is required',
        ]);

        try {
            $newproduct = new Product;
            $newproduct->name = $validate['name'];
            $newproduct->desc = $validate['desc'];
            $newproduct->price = $validate['price'];
            $newproduct->stock = $validate['stock'];
            $newproduct->save();
            //Product::create($validate);

            return redirect(route('product.index'))->withSuccess('Product has been saved!');
        } catch(\Throwable $th) {
            return back()->withErrors('Something went wrong!');
        }
    }
}
