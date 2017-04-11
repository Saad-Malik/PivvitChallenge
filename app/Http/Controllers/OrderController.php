<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $order = Order::all();

        return response()->json(
            [
                "msg"=>"List of all the orders",
                'list of order' => $order
            ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $customer_name = Input::get('customer_name');
        $quantity = Input::get('quantity');
        $product_id = Input::get('product_id');

        $order = new Order();
        $order->customer_name = $customer_name;
        $order->quantity = $quantity;
        $order->product_id = $product_id;


        $product = Product::where('id' , $product_id)->first();
        $total_price = $quantity * $product->price;
        $order->total_price = $total_price;

        if(!$order->save())
        {
            return response()->json(["msg"=>"Your order cannot be saved!"],422);
        }

        return response()->json(
            [
                "msg"=>"Your order is saved!",
                'order_detail' => $order
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
        $order = Order::find($id);

        if(!empty($order))
        {
            return response()->json(
                [
                    "msg"=>"Order found",
                    'order_detail' => $order
                ]);
        }
        return response()->json(["msg"=>"Your order do not exists"],422);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, $id)
    {
        //
        $customer_name = Input::get('customer_name');
        $quantity = Input::get('quantity');
        $product_id = Input::get('product_id');

        $product= Product::where('id' , $product_id)->count();
        if($product == 0 )
        {
            return response()->json(["msg"=>"Your product do not exists"],422);
        }
        else
        {
            $product = Product::where('id' , $product_id)->first();
            $total_price = $quantity * $product->price;
        }
        $order = Order::find($id);

        if(!empty($order))
        {
            Order::where('id', $id)->update(array(
                'product_id' => $product_id,
                'customer_name' => $customer_name,
                'quantity' => $quantity,
                'total_price' => $total_price,
            ));
            return response()->json(
                [
                    "msg"=>"Order Updated",
                    "updated_order" => $order
                ]);
        }
        return response()->json(["msg"=>"Your order do not exists"],422);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $order = Order::find($id);

        if(!empty($order))
        {
            Order::destroy($id);
            return response()->json(
                [
                    "msg"=>"Order destroyed",
                ]);
        }
        return response()->json(["msg"=>"Your order do not exists"],422);

    }
}
