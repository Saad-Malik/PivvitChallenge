<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();

        return response()->json(
            [
                "msg"=>"List of all the products",
                'list of products' => $product
            ]);
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $name = Input::get('name');
        $price = Input::get('price');
        $in_stock = Input::get('in_stock');

        $product = new Product();
        $product->name = $name;
        $product->price = $price;
        $product->in_stock = $in_stock;

        if(!$product->save())
        {
            return response()->json(["msg"=>"Your product cannot be stored!"]);
        }
        return response()->json(
            [
                "msg"=>"Your product is stored!",
                'product' => $product
            ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $product = Product::find($id);

        if(!empty($product))
        {
            return response()->json(
                [
                    "msg"=>"Product found",
                    'Product_details' => $product
                ]);
        }
        return response()->json(["msg"=>"Your product do not exists"],422);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        //
        $name = Input::get('name');
        $price = Input::get('price');
        $in_stock = Input::get('in_stock');

        $product= Product::where('id' , $id)->count();
        if($product == 0 )
        {
            return response()->json(["msg"=>"Your product do not exists"],422);
        }
        else
        {
            Product::where('id', $id)->update(array(
                'name' => $name,
                'price' => $price,
                'in_stock' => $in_stock,
            ));
            return response()->json(
                [
                    "msg"=>"Product Updated",
                ]);
        }
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

        if(!empty($product))
        {
            Product::destroy($id);
            return response()->json(
                [
                    "msg"=>"Product destroyed",
                ]);
        }
        return response()->json(["msg"=>"Your product do not exists"],422);
        //
    }
}
