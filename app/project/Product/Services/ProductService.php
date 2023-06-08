<?php

namespace App\project\Product\Services;

use App\Models\Prod_color;
use App\Models\Prod_Img;
use App\Models\Prod_unit;
use App\Models\Product;
use App\project\Product\Requests\ProductRequest;
use http\Client\Request;
use http\Env\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function showall(){
//        $products = Product::with('images')->with('colors')->with('units')->get();
        $products = Product::with(['images' => function ($query) {
            $query->select('prod_id', 'image');
        }, 'colors' => function ($query) {
            $query->select('prod_id', 'color_'.app()->getLocale().' as color');
        }, 'units' => function ($query) {
            $query->select('prod_id','unit');
        }])
            ->get(['id', 'prod_name_'.app()->getLocale().' as prod_name', 'Desc_'.app()->getLocale().' as Desc','state']);
        foreach ($products as &$product) {
            $product['quantity'] = '';
            $product['color'] = '';
            $product['unit'] = '';
        }
        unset($product);

        return $products;
    }

    public function show($id){
        $product = Product::with(['images' => function ($query) {
            $query->select('prod_id', 'image');
        }, 'colors' => function ($query) {
            $query->select('prod_id', 'color_'.app()->getLocale().' as color');
        }, 'units' => function ($query) {
            $query->select('prod_id','unit');
        }])->select('id','prod_name_'.app()->getLocale().' as prod_name','Desc_'.app()->getLocale().' as Desc')->find($id);

        if($product===null){
            return response()->json(["status"=>"not found"],400);
        }

        return response()->json(["status"=>"success", 'product'=>$product],200);
    }
    /*-----------------------------------------------------------------------------------------------------------*/
    public function store(ProductRequest $request){
        //take subsubcategory_id   prod_name  prod_image --- colors as string , units as string
        $product=new Product();

        $product->subsubcategory_id=$request->get('subsubcategory_id');
        $product->factory_id = $request->get('factory_id');
        /**                 names                     */
        $product->prod_name_en = $request->get('name_en');
        $product->prod_name_ch = $request->get('name_ch');
        $product->prod_name_ru = $request->get('name_ru');
        /**                 Desc                     */
        $product->Desc_en = $request->get('Desc_en');
        $product->Desc_ch = $request->get('Desc_ch');
        $product->Desc_ru = $request->get('Desc_ru');

        $product->save();
        /**                 photoes                     */
        $imagename=Str::random(32).".".$request->file('image1')->getClientOriginalExtension();
        Storage::disk('public')->put('products/'.$imagename,file_get_contents($request->image1));
        $prod_img=new Prod_Img();
        $prod_img->prod_id=$product->id;
        $prod_img->image = $imagename;
        $prod_img->save();

        if($request->has('image2')) {
            $imagename=Str::random(32).".".$request->file('image2')->getClientOriginalExtension();
            Storage::disk('public')->put('products/'.$imagename,file_get_contents($request->image2));
            $prod_img=new Prod_Img();
            $prod_img->prod_id=$product->id;
            $prod_img->image =$imagename;
            $prod_img->save();

        }if($request->has('image3')) {
            $imagename=Str::random(32).".".$request->file('image3')->getClientOriginalExtension();
            Storage::disk('public')->put('products/'.$imagename,file_get_contents($request->image3));
            $prod_img=new Prod_Img();
            $prod_img->prod_id=$product->id;
            $prod_img->image =$imagename;
            $prod_img->save();

        }
        if($request->has('image4')) {
            $imagename=Str::random(32).".".$request->file('image4')->getClientOriginalExtension();
            Storage::disk('public')->put('products/'.$imagename,file_get_contents($request->image4));
            $prod_img=new Prod_Img();
            $prod_img->prod_id=$product->id;
            $prod_img->image =$imagename;
            $prod_img->save();

        }


        /**                 colors and units                     */
        // store attributes

       // Store Colors
        $res=$this->storecolor($request,$product->id);
        if(!$res){
            return response()->json(['status'=>'something wrong happened with colors'],400);
        }
        $res=$this->storeunits($request,$product->id);
        if(!$res){
            return response()->json(['status'=>'something wrong happened with units'],400);
        }
        return response()->json(['status'=>'stored successfully'],200);

   }

/*--------------------------------------------------------------------------------------------------------*/
    public function storecolor($request,$prod_id)
    {
    $colors_en = explode(',', $request->colors_en);
    $colors_ch = explode(',', $request->colors_ch);
    $colors_ru = explode(',', $request->colors_ru);
        $len=count($colors_en);
        for($i=0 ; $i<$len ; $i++) {
        $product_color = new Prod_color();
        $product_color->prod_id = $prod_id;
        $product_color->color_en = $colors_en[$i];
        $product_color->color_ch = $colors_ch[$i];
        $product_color->color_ru = $colors_ru[$i];
        $product_color->save();
    }
    return true;
    }
    /*-----------------------------------------------------------------------------------------------------*/

    public function storeunits($request,$prod_id)
    {
        $unitsArray = explode(',', $request->units); // Convert input string to an array

        foreach ($unitsArray as $unit)  {
            $product_unit = new Prod_unit();
            $product_unit->prod_id = $prod_id;

            $product_unit->unit=$unit;
            $product_unit->save();
        }
        return true;
    }
    /*-----------------------------------------------------------------------------------------------------*/
    public function update($request,$id){
        $product = Product::find($id); // when i make custom reuest i will replace this i
        if($product===null) {
            return response()->json(['status'=>'not_found'],400);
        }
        /**                 names                     **/
        if($request->has('name_en')) {
            $product->prod_name_en = $request->get('name_en');
        }
        if($request->has('name_ch')) {
            $product->prod_name_ch = $request->get('name_ch');
        }
        if($request->has('name_ru')) {
            $product->prod_name_ru = $request->get('name_ru');
        }

        /**                 Desc                     */
        if($request->has('Desc_en')) {
            $product->Desc_en = $request->get('Desc_en');
        }
        if($request->has('Desc_ch')) {
            $product->Desc_ch = $request->get('Desc_ch');
        }
        if($request->has('Desc_ru')) {
            $product->Desc_ru = $request->get('Desc_ru');
        }
        if($request->has('state')) {
            $product->state = $request->get('state');
        }

//        if ($request->hasFile('image')) {
//            //delete photo
//            Storage::disk('public')->delete($product->prod_image);
//            // Storage::delete($category->image);
//            //store new one
//            $img=$request->file('image');
//            $imagename=Str::random(32).".".$img->getClientOriginalExtension();
//            Storage::disk('public')->put($imagename,file_get_contents($request->image));
//
//            $product->prod_image = $imagename;
//        }
        $product->save();

        return response()->json(['status'=>'success','product'=>$product],200);

    }

    /*-----------------------------------------------------------------------------------------------------*/

    public function destroy($id) //id
    {
        //find the product
        $product=Product::find($id);
        if($product===null){
            return response()->json(['status'=>'Not Found'],400);
        }
        // Delete photoes from storage
        $imgs=Prod_Img::where('prod_id',$id)->get();

        foreach($imgs as $img){
          Storage::disk('public')->delete('products/'.$img);
        }

        //delete attributes
        $product = Product::find($id);
        $product->colors()->delete();
        $product->units()->delete();
        $product->images()->delete();



     // Delete the product from the database
        $product->delete();

    return response()->json(['status'=>'deleted successfully'],200);
    }
    /*-----------------------------------------------------------------------------------------------------*/

}
/*    $i = 1;
        while ($request->has('prod_image'.$i)) {
            // process and store the image as needed
            $prod_img=new Prod_Img();
            $prod_img->prod_id = $product->id;
            //store photo
            $imagename=Str::random(32).".".$request->file('prod_image'.$i)->getClientOriginalExtension();
            $prod_img->image = $imagename;
            Storage::disk('public')->put($imagename,file_get_contents($request->prod_image.$i));
            $prod_img->save();
            $i++;
        }
*/
