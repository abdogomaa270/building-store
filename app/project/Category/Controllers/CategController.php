<?php

namespace App\project\Category\Controllers;

use App\Models\Category;
use App\Models\Products;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\project\Category\Requests\CategUpdateRequest;
use App\project\Category\Requests\CategoryRequest;
use App\project\Category\Services\CategoryService;
use http\Client\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class CategController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    private CategoryService $CategoryService;
    public function __construct(CategoryService $CategoryService) {

        $this->CategoryService = $CategoryService;
    }

    public function showall(){
        return $this->CategoryService->showall();
    }
    public function show($id){
        return $this->CategoryService->show($id);
    }
    public function store(CategoryRequest $request){
        return $this->CategoryService->store($request);
    }
    public function update(CategUpdateRequest $request,$categ_id){
        return $this->CategoryService->update($request,$categ_id);
    }
    public function destroy($categ_id){
        return $this->CategoryService->destroy($categ_id);

    }
    function getrealted($categoryId)
    {
      return $this->CategoryService->getrelated($categoryId);
    }


}
