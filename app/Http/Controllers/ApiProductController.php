<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiProductController extends Controller
{
    /**
     * 商品の一覧を表示
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }

    /**
     * 新しい商品の作成フォームを表示
     */
    public function create()
    {
        //
    }

    /**
     * 新しい商品をデータベースに保存
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Product Created successfully!",
            'product' => $product
        ], 200);
    }


    /**
     * 指定された商品を表示
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * 指定された商品の編集フォームを表示
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * 指定された商品を更新
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * 指定された商品を削除
     */
    public function destroy(Product $product)
    {
        //
    }
}
