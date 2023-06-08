<?php

namespace App\project\orders\controllers;

use App\Models\order;
use App\Models\orderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController
{
    public function GetOrders(){
        $orders = Order::with(['orderItems.product' => function ($query) {
            $query->select('id','prod_name_'.app()->getLocale().' as prod_name','Desc_'.app()->getLocale().' as Desc');
        }])->get();
        return response()->json([$orders],200);
    }
    //how to construct relation many to many



    public function SubmitOrder(Request $request){
        DB::beginTransaction();

        try {
            $order=new order();
            $order->name  = $request->name ;
            $order->email = $request->email ;
            $order->phone = $request->phone ;
            $order->message = $request->message ;
            $order->save();
            $items = $request->items;

            foreach ($items as $item){
                $order_item=new orderItems();
                $order_item->order_id = $order->id;
                $order_item->prod_id = $item['id'];
                $order_item->unit=$item['unit'];
                $order_item->quantity = $item['quantity'];
                $order_item->color = $item['color'];
                $order_item->save();
            }

            DB::commit();
            return response()->json(['status'=>'Submitted successfully'],200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'Error submitting order: ' . $e->getMessage()], 500);
        }
    }

    public function DeleteOrder($id){
        $order=order::find($id);
        $order->orderItems()->delete();
        $order->delete();
        return response()->json(['status'=>'Deleted Successfully'],200);

    }
}
//        $requestData = json_decode($request->getContent(), true); // assuming the request is sent as JSON
