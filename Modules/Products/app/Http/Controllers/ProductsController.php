<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Products\Models\Product;
use Modules\Products\Services\ProductService;
use Modules\Products\Http\Requests\CreateProductRequest;

class ProductsController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function list()
    {
        return response()->json([
            "data" => Product::get()
        ]);
    }

    public function create(CreateProductRequest $request)
    {
        return response()->json([
            "is_success" => $this->productService->createProduct($request->validated())
        ]);
    }

    public function insertItems(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        return $this->productService->insertItems($payload);
    }
}
