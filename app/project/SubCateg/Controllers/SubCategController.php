<?php

namespace App\project\SubCateg\Controllers;

use App\project\SubCateg\Requests\SubCategRequest;
use App\project\SubCateg\Requests\SubUpdate;
use App\project\SubCateg\Services\SubCategService;
use http\Client\Request;

class SubCategController
{
    private SubCategService $SubCategoryService;
    public function __construct(SubCategService $SubCategoryService) {

        $this->SubCategoryService = $SubCategoryService;
    }

    public function showall(){
        return $this->SubCategoryService->showall();
    }
    public function show($id){
        return $this->SubCategoryService->show($id);
    }
    public function store(SubCategRequest $request){
        return $this->SubCategoryService->store($request);
    }
    public function update(SubUpdate $request,$categ_id){
        return $this->SubCategoryService->update($request,$categ_id);
    }
    public function destroy($categ_id){
        return $this->SubCategoryService->destroy($categ_id);

    }
    public function getrelated($SubCategid){
        return $this->SubCategoryService->getrelated($SubCategid);
    }

}
