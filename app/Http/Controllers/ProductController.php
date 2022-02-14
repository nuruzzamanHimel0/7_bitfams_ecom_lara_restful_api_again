<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }

    public function index()
    {

        return  ProductCollection::collection( Product::orderBy('id','desc')->paginate(20) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->details = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->discount = $request->discount;
        $product->save();

        return response()->json([
            'data' => new ProductResource($product)
        ],201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // return $product;

        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function productUserCheck($product){

        if(Auth::user()->id !== $product->user_id ){
            throw new ProductNotBelongsToUser;

        }
    }
    public function update(Request $request, Product $product)
    {
        $this->productUserCheck($product);

        $request->validate([
            'name' => 'required|max:255|unique:products,name,'.$product->id,
            'description' => 'required',
            'price' => 'required|max:20',
            'stock' => 'required|max:6',
            'discount' => 'required|max:10',
        ]);



        $request['details'] = $request->description;
        unset($request['description']);

        $product->update($request->all());
        return response()->json([
            'data' => new ProductResource($product)
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->productUserCheck($product);

        if($product->delete()){
            return response()->json(null,Response::HTTP_NO_CONTENT);
        }
        // return $product;
    }





}
