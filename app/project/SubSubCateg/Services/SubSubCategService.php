<?php

namespace App\project\SubSubCateg\Services;

use App\Models\Product;
use App\Models\SubSubCategory;
use App\project\SubCateg\Requests\SubUpdate;
use App\project\SubSubCateg\Requests\SubSubRequest;

class SubSubCategService
{
    public function showall(){
        return SubSubCategory::select('id', 'SubSubCateg_name_'.app()->getLocale().' as SubSubCateg_name')->get();
    }
    /*---------------------------------------------------------------------------------------*/
    public function show($id)
    {
        $SubSubcategory = SubSubCategory::select('id', 'SubSubCateg_name_'.app()->getLocale().' as SubSubCateg_name')->find($id);
        if($SubSubcategory===null){
            return response()->json(["status"=>'not exist'],400);
        }

         return response()->json(['status'=>'success','SubSubcategory'=>$SubSubcategory],200);
    }
    /*---------------------------------------------------------------------------------------*/

    public function store(SubSubRequest $request){
        //to store multible name
//        $names = explode(',',$request->get('name') );
//        $len=count($names);
//
//        for($i=0;$i<$len;$i+=3) {
//            $SubSubcategory = new SubSubCategory();
//            $SubSubcategory->category_id = $request->get('category_id');
//
//            $SubSubcategory->SubSubCateg_name_en = $names[$i];
//            $SubSubcategory->SubSubCateg_name_ch = $names[$i+1];
//            $SubSubcategory->SubSubCateg_name_ru = $names[$i+2];
//            $SubSubcategory->save();
//        }
//         to store one categ
         $SubSubcategory = new SubSubCategory();

        $SubSubcategory->subcategory_id=$request->get('subcategory_id');

        $SubSubcategory->SubSubCateg_name_en = $request->get('name_en');
         $SubSubcategory->SubSubCateg_name_ch  = $request->get('name_ch');
         $SubSubcategory->SubSubCateg_name_ru = $request->get('name_ru');

        $SubSubcategory->save();
        return response()->json(['status'=>'stored successfully'],200);

    }
    /*---------------------------------------------------------------------------------------*/
    public function update(SubUpdate $request,$id){
        $SubSubCateg= SubSubCategory::find($id);
        //check existance
        if($SubSubCateg === null) {
            return response()->json(["status"=>"not found"],400);
        }
        if($request->has('name_en')) {
            $SubSubCateg->SubSubCateg_name_en=$request->get('name_en');
         }
        if($request->has('name_ch')) {
            $SubSubCateg->SubSubCateg_name_ch=$request->get('name_ch');
        }
        if($request->has('name_ru')) {
            $SubSubCateg->SubSubCateg_name_ru = $request->get('name_ru');
        }

        $SubSubCateg->save();
        return response()->json(["status"=>"success"],200);

    }

    /*---------------------------------------------------------------------------------------*/
    public function getrelated($SubSubId){
//        $products= Product::where('subsubcategory_id', $SubSubId)->get();
        $lang=app()->getLocale();
        $products = Product::with(['images' => function ($query) {
            $query->select('prod_id', 'image');
        }, 'colors' => function ($query) {
            $query->select('prod_id', 'color_'.app()->getLocale().' as color');
        }, 'units' => function ($query) {
            $query->select('prod_id','unit_'.app()->getLocale().' as unit');
        }])->where('subsubcategory_id',$SubSubId)
            ->get(['id', 'prod_name_'.$lang.' as prod_name', 'Desc_'.$lang.' as Desc','state']);
        foreach ($products as &$product) {
            $product['quantity'] = '';
            $product['color'] = '';
            $product['unit'] = '';
        }
        unset($product);
        return $products;
    }

    /*---------------------------------------------------------------------------------------*/
    public function destroy($id)
    {
        $SubSubcategory = SubSubCategory::find($id);
        if($SubSubcategory===null){
            return response()->json(['not found'],400);
        }
        $SubSubcategory->delete();
        return response()->json(['status'=>'success'],200);
    }
}

