<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::select('products.*', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS user_name"))
        ->join('users', 'users.id', '=', 'products.user_id')
        ->get();

        foreach($products as $product) {
            if (!$product->image) {
                $product->image = 'https://image.shutterstock.com/image-vector/no-user-profile-picture-hand-260nw-99335579.jpg';
            }

            if ($product->user_id == Auth::user()->id) {
                $product->can_edit = true;
            } else {
                $product->can_edit = false;
            }
            
        }

        return new ProductResourceCollection($products);

    }

    /**
     * Display a listing of the available resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function availableIndex()
    {
        $products = Product::select('products.*', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS user_name"))
        ->join('users', 'users.id', '=', 'products.user_id')
        ->where('products.is_available', '=', true)
        ->get();

        foreach ($products as $product) {
            if (!$product->image) {
                $product->image = 'https://image.shutterstock.com/image-vector/no-user-profile-picture-hand-260nw-99335579.jpg';
            }
        }

        return new ProductResourceCollection($products);
    }

    /**
     * Display a listing of the resource owned by user.
     *
     * @return \Illuminate\Http\Response
     */
    public function personalIndex()
    {
        $products = Product::select('products.*', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS user_name"))
        ->join('users', 'users.id', '=', 'products.user_id')
        ->where('users.id', '=', Auth::user()->id)
        ->get();

        foreach ($products as $product) {
            if (!$product->image) {
                $product->image = 'https://image.shutterstock.com/image-vector/no-user-profile-picture-hand-260nw-99335579.jpg';
            }

            if ($product->user_id == Auth::user()->id) {
                $product->can_edit = true;
            } else {
                $product->can_edit = false;
            }
        }

        return new ProductResourceCollection($products);
    }

    /**
     * Display a listing of the resource taken by user.
     *
     * @return \Illuminate\Http\Response
     */
    public function takenByMeIndex()
    {
        $products = Product::select('products.*', DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS user_name"))
        ->join('users', 'users.id', '=', 'products.user_id')
        ->where('products.taken_by', '=', Auth::user()->id)
        ->get();

        foreach ($products as $product) {
            if (!$product->image) {
                $product->image = 'https://image.shutterstock.com/image-vector/no-user-profile-picture-hand-260nw-99335579.jpg';
            }

            if ($product->user_id == Auth::user()->id) {
                $product->can_edit = true;
            } else {
                $product->can_edit = false;
            }
        }

        return new ProductResourceCollection($products);
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
    public function store(Request $request)
    {
        //
        // unauthorized user if user id is invalid
        if (!Auth::user()->is_subscribed && (is_null(Auth::user()->id) || Auth::user()->id == '')) {
            abort(401);
        }

        $rules = [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer'
        ];

        $messages = [
            'name.required' => 'Product must have a name',
            'description.required' => 'Product must have a description.',
            'price.required' => 'Product must have a price.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages
        );

        $product = new Product([
            'user_id' => $request->get('user_id'),
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'image' => $request->get('image'),
            'price' => $request->get('price'),
        ]);

        $product->save();
        
        $product->user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $product->can_edit = true;
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        // unauthorized user if user id is invalid
        if (!Auth::user()->is_subscribed && Auth::user()->id != $product->user_id) {
            abort(401);

        $rules = [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer'
        ];

        $messages = [
            'name.required' => 'Product must have a name',
            'description.required' => 'Product must have a description.',
            'price.required' => 'Product must have a price.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        }
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->image = $request->get('image');
        $product->price = $request->get('price');

        $product->save();

        $product->user_name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        return new ProductResource($product);
    
    }


    /**
     * Update the specified resource in storage to make unavailable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function takeProduct(Product $product)
    {
        //
        if (!Auth::user()->is_subscribed) {
            abort('401');
        }

        $product->is_available = false;
        $product->taken_by = Auth::user()->id;
        $product->save();

        return new ProductResource($product);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // unauthorized user if user id is invalid
        if (!Auth::user()->is_subscribed && Auth::user()->id != $product->user_id) {
            abort(401);
        }

        $product->delete();
        return json_decode('Product Deleted');

    }
}
