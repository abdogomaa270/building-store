<?php

namespace App\project\SubSubCateg\Controllers;

use App\project\SubCateg\Requests\SubUpdate;
use App\project\SubSubCateg\Requests\SubSubRequest;
use App\project\SubSubCateg\Services\SubSubCategService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class SubSubCategController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    private SubSubCategService $SubSubCategService;

    public function __construct(SubSubCategService $SubSubCategService)
    {

        $this->SubSubCategService = $SubSubCategService;
    }

    public function showall()
    {
        return $this->SubSubCategService->showall();
    }

    public function show($id)
    {
        return $this->SubSubCategService->show($id);
    }

    public function store(SubSubRequest $request)
    {
        return $this->SubSubCategService->store($request);
    }
    public function update(SubUpdate $request,$id){
        return $this->SubSubCategService->update($request,$id);
    }
    public function destroy($id){
        return $this->SubSubCategService->destroy($id);
    }
    public function getrelated($SubSubId){
        return $this->SubSubCategService->getrelated($SubSubId);
    }
}
