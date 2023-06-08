<?php

namespace App\project\Factories\Services;

use App\Models\factory;
use App\project\Factories\Requests\FactoryRequest;
use http\Client\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FactoryService
{
    public function showall(){
        $facts=factory::select('id','name_'.app()->getLocale().' as name','status','image')->get();
        return response()->json(['data'=>$facts],200);
    }
    /*--------------------------------------------------------------*/

    public function showallRelated(){

        $facts=factory::with([
          'products' => function($query){
            $query->select('id','factory_id','prod_name_'.app()->getLocale().' as prod_name','Desc_'.app()->getLocale().' as Desc','state');
        },'products.colors' => function($query){
            $query->select('prod_id','color_'.app()->getLocale().' as color');
        },'products.units' => function($query) {
            $query->select('prod_id', 'unit');
        },'products.images'])->select('id','name_'.app()->getLocale().' as name','status','image')->get();

        return response()->json(['status'=>'done','data'=>  $facts],200);
    }
    /*--------------------------------------------------------------*/

    public function show($id){
        $fac = factory::select('id','name_'.app()->getLocale().' as name','status','image')->find($id);
        return response()->json(['data'=>$fac],200);
    }
    /*--------------------------------------------------------------*/
    public function showRelated($id){
        $fac = factory::with([
          'products' => function($query){
            $query->select('id','factory_id','prod_name_'.app()->getLocale().' as prod_name','Desc_'.app()->getLocale().' as Desc','state');
        },'products.colors' => function($query){
            $query->select('prod_id','color_'.app()->getLocale().' as color');
        },'products.units' => function($query) {
            $query->select('prod_id', 'unit');
        },'products.images'])->select('id','name_'.app()->getLocale().' as name','status','image')->find($id);
        return response()->json(['status'=>'success','data'=>$fac],200);

    }
    /*--------------------------------------------------------------*/

    public function store(FactoryRequest $request){

        $factory=new factory();
        $factory->name_en = $request->get('name_en');
        $factory->name_ch = $request->get('name_ch');
        $factory->name_ru	= $request->get('name_ru');
        $factory->status= $request->get('status');

        $img=$request->file('image');
        $imagename=Str::random(32).".".$img->getClientOriginalExtension();
        $factory->image ='storage/fac/'.$imagename;

        Storage::disk('public')->put('fac/'.$imagename,file_get_contents($request->image));

        $factory->save();
        return response()->json(['status'=>'done'],200);
    }
    /*--------------------------------------------------------------*/

    public function destroy($id)
    {
        $factory = factory::find($id);
        if($factory===null){
            return response()->json(['not found'],400);
        }
        Storage::disk('public')->delete($factory->Category_image);
        $factory->delete();
        return response()->json(['status'=>'success'],200);
    }
}
