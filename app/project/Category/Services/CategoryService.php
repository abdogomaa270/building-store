<?php

namespace App\project\Category\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\project\Category\Requests\CategoryRequest;
use App\project\Category\Requests\CategUpdateRequest;
use http\Client\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryService
{
    public function showall(){
        return Category::select('id', 'Category_name_'.app()->getLocale().' as Category_name','Category_image')->get();
    }
    /*------------------------------------------------------------------------------------------------*/

    public function store(CategoryRequest $request){
        $category=new Category();
        $category->Category_name_en = $request->get('name_en');
        $category->Category_name_ch = $request->get('name_ch');
        $category->Category_name_ru	= $request->get('name_ru');

        $img=$request->file('image');
        $imagename=Str::random(32).".".$img->getClientOriginalExtension();
        $category->Category_image ='categ/'.$imagename;

        Storage::disk('public')->put('categ/'.$imagename,file_get_contents($request->image));

        $category->save();
        return response()->json(['status'=>'done'],200);

    }
    /*------------------------------------------------------------------------------------------------*/

    public function show($id)
    {
        $category = Category::select('id','Category_name_'.app()->getLocale().' as Category_name','Category_image')->find($id);

        if($category===null){
            return response()->json(["status"=>'Category not exist'],400);
        }
        return response()->json(['status'=>'success','category'=>$category],200);
    }
/*------------------------------------------------------------------------------------------------*/
    public function update(CategUpdateRequest $request, $id)
    {
        $category = Category::find($id); // when i make custom reuest i will replace this i
        if($category===null) {
            return response()->json(['status'=>'Category not found'],400);
        }
        if($request->has('name_en')) {
            $category->Category_name_en = $request->get( 'name_en');
        }
        if($request->has('name_ch')) {
            $category->Category_name_ch = $request->get( 'name_ch');
        }
        if($request->has('name_ru')) {
            $category->Category_name_ru = $request->get( 'name_ru');
        }

        if ($request->hasFile('image')) {
            //delete photo'categ/'.$imagename
            Storage::disk('public')->delete('categ/'.$category->Category_image);
            //store new one
            $img=$request->file('image');
            $imagename=Str::random(32).".".$img->getClientOriginalExtension();
            Storage::disk('public')->put('categ/'.$imagename,file_get_contents($request->image));

            $category->Category_image = 'categ/'.$imagename;
        }

        $category->save();

        return response()->json(['status'=>'success','category'=>$category],200);
    }

    /*   $imagePath = $request->file('image')->store('public/images');
            $imageUrl = Storage::url($imagePath);
    */
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category===null){
            return response()->json(['not found'],400);
        }
        Storage::disk('public')->delete('categ/'.$category->Category_image);
        $category->delete();
         return response()->json(['status'=>'success'],200);
    }

    public function getrelated($categoryId){
        // Get the category with the given ID
        $category = Category::select('id','Category_name_'.app()->getLocale().' as Category_name','Category_image')->find($categoryId);

        // Get the related subcategories
        $lang=app()->getLocale();
        $subcategories = SubCategory::select('id','SubCateg_name_'.app()->getLocale().' as SubCateg_name')->where('category_id', $categoryId)->get();

        // Get the related subsubcategories
        $subsubcategories = SubSubCategory::select('id','SubSubCateg_name_'.$lang.' as SubSubCateg_name')->whereIn('subcategory_id', $subcategories->pluck('id'))->get();
        //i think wherein method is used to compare column with a key of that array
//        $products = Product::select('id','prod_name_'.$lang.' as prod_name','Desc_'.$lang.' as Desc')->whereIn('subsubcategory_id', $subsubcategories->pluck('id'))->get();
        $products = Product::with(['images' => function ($query) {
            $query->select('prod_id', 'image');
        }, 'colors' => function ($query) {
            $query->select('prod_id', 'color_'.app()->getLocale().' as color');
        }, 'units' => function ($query) {
            $query->select('prod_id','unit');
        }])->whereIn('subsubcategory_id', $subsubcategories->pluck('id'))
            ->get(['id', 'prod_name_'.$lang.' as prod_name', 'Desc_'.$lang.' as Desc','state']);

        // Return a JSON response containing both the subcategories and subsubcategories
        return response()->json([
            'category'=>$category,
            'subcategories' => $subcategories,
            'subsubcategories' => $subsubcategories,
            '$products'=>$products,


        ]);
    }


}
