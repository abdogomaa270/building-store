<?php

namespace App\project\Product\Controllers;
use App\project\Product\Requests\ProductRequest;
use App\project\Product\Requests\ProdUpdate;
use App\project\Product\Services\ProductService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ProductController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    private ProductService $ProductService;

    public function __construct(ProductService $ProductService)
    {

        $this->ProductService = $ProductService;
    }

    public function showall()
    {
        return $this->ProductService->showall();
    }

    public function show($id)
    {
        return $this->ProductService->show($id);
    }

    public function store(ProductRequest $request)
    {
        return $this->ProductService->store($request);
    }

    public function update(ProdUpdate $request, $categ_id)
    {
        return $this->ProductService->update($request, $categ_id);
    }

    public function destroy($categ_id)
    {
        return $this->ProductService->destroy($categ_id);

    }

    public function getProdDetails($id){

        return $this->ProductService->getProdDetails($id);
    }
}
