<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ProductException;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class ProductController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        return $this->returnData(200, 'Retrieve all products', ProductResource::collection(Product::all()));
    }

    public function show(Product $product)
    {
        return $this->returnData(200, 'Retrieve product details', new ProductResource($product));
    }
}
