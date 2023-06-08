<?php

namespace App\project\SubCateg\Services;

use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\project\SubCateg\Requests\SubCategRequest;
use App\project\SubCateg\Requests\SubUpdate;


class SubCategService
{
    public function showall(){
        return SubCategory::select('id', 'SubCateg_name_'.app()->getLocale().' as SubCateg_name')->get();
    }

    public function store(SubCategRequest $request){

//        $names=explode(',',$request->get('name') );
//        $len=count($names);

//        for($i=0;$i<$len;$i+=3) {
//            $Subcategory = new SubCategory();
//            $Subcategory->category_id = $request->get('category_id');
//
//            $Subcategory->SubCateg_name_en = $names[$i];
//            $Subcategory->SubCateg_name_ch = $names[$i+1];
//            $Subcategory->SubCateg_name_ru = $names[$i+2];
//            $Subcategory->save();
//        }
//
        $subcategory=new SubCategory();

         $subcategory->category_id=$request->get('category_id');

         $subcategory->SubCateg_name_en = $request->get('name_en');
         $subcategory->SubCateg_name_ch = $request->get('name_ch');
         $subcategory->SubCateg_name_ru = $request->get('name_ru');


        $subcategory->save();
        return response()->json(['status'=>'stored successfully'],200);

    }

    public function show($id)
    {
        $subcategory = SubCategory::select('id','SubCateg_name_'.app()->getLocale().' as SubCateg_name')->find($id);
        if($subcategory===null){
            return response()->json(["status"=>'Not Exist'],400);
        }
        return response()->json(['status'=>'success','category'=>$subcategory],200);
    }

    public function update(SubUpdate $request, $id)
    {
        $subcategory = SubCategory::find($id); // when i make custom reuest i will replace this i
        if($subcategory===null) {
            return response()->json(['status'=>'not_found'],200);
        }

        if($request->has('name_en')) {
            $subcategory->SubCateg_name_en = $request->get('name_en');
        }
        if($request->has('name_ch')) {
            $subcategory->SubCateg_name_ch = $request->get('name_ch');
        }
        if($request->has('name_ru')) {
            $subcategory->SubCateg_name_ru = $request->get('name_ru');
        }
        $subcategory->save();

        return response()->json(['status'=>'Updated Success','category'=>$subcategory],200);
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        if($subcategory===null){
            return response()->json(['not found'],400);
        }
        $subcategory->delete();
        return response()->json(['status'=>'success'],200);
    }

    public function getrelated($subcategId){

        // Get the related subsubcategories
        $lang =app()->getLocale();

        $subsubcategories = SubSubCategory::select('id','SubSubCateg_name_'.$lang.' as SubSubCateg_name')->where('subcategory_id', $subcategId)->get();

        //i think wherein method is used to compare column with a key of that array
//        $products = Product::whereIn('subsubcategory_id', $subsubcategories->pluck('id'))->get();
        $products = Product::with(['images' => function ($query) {
            $query->select('prod_id', 'image');
        }, 'colors' => function ($query) {
            $query->select('prod_id', 'color_'.app()->getLocale().' as color');
        }, 'units' ])->whereIn('subsubcategory_id', $subsubcategories->pluck('id'))
            ->get(['id', 'prod_name_'.$lang.' as prod_name', 'Desc_'.$lang.' as Desc','state']);

        foreach ($products as &$product) {
            $product['quantity'] = '';
            $product['color'] = '';
            $product['unit'] = '';
        }
        unset($product);

        // Return a JSON response containing both the subcategories and subsubcategories
        return response()->json([
            'subsubcategories' => $subsubcategories,
            '$products'=>$products

        ]);
    }


}
