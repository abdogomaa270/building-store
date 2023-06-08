<?php

namespace App\project\Factories\Controllers;

use App\project\Factories\Requests\FactoryRequest;
use App\project\Factories\Services\FactoryService;

class FactoryController
{
  private FactoryService $factoryService;
  public function __construct(FactoryService $factoryService){
      $this->factoryService = $factoryService;
  }

    public function showall(){
       return $this->factoryService->showall();
    }
    public function showallRelated(){
        return $this->factoryService->showallRelated();
    }
    public function show($id){
       return $this->factoryService->show($id);
    }
    public function showRelated($id){
        return $this->factoryService->showRelated($id);
    }

    public function store(FactoryRequest $request){

        return $this->factoryService->store($request);
    }

    public function destroy($id)
    {
        return $this->factoryService->destroy($id);
    }

}
