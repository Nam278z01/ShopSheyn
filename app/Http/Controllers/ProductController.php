<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        //
        $page = request()->get('page');
        $page_size = request()->get('page_size');
        $category_id = request()->get('category_id');
        $list_subcategory_id = request()->get('list_subcategory_id');
        $text_search = request()->get('text_search');
        $min_price = request()->get('min_price');
        $max_price = request()->get('max_price');
        $sort = request()->get('sort');
        $data = DB::select('call getProductsSearch(?, ?, ?, ?, ?, ?, ?, ?, @total_row)', [$page, $page_size, $category_id, $list_subcategory_id, $text_search, $min_price, $max_price, $sort]);
        $total_row = DB::select('select @total_row as total_row');
        return ["data" => json_decode($data[0]->data), "total_row" => $total_row[0]->total_row];
    }

    public function index()
    {
        //
        return ProductResource::collection(Product::orderByDesc('created_time')->get());
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
        //...
        $product = new Product();
        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->product_discount = $request->product_discount;
        $product->subcategory_id = $request->subcategory_id;
        $product->admin_created_id = 1;
        $product->save();
        foreach ($request->colors as $color) {
            $color_new = new Color();
            $color_new->color_name = $color['color_name'];
            $color_new->product_price = $color['product_price'];
            $color_new->product_image1 = $color['product_image1'];
            if (isset($color['product_image2'])) {
                $color_new->product_image2 = $color['product_image2'];
            }
            if (isset($color['product_image3'])) {
                $color_new->product_image2 = $color['product_image3'];
            }
            if (isset($color['product_image4'])) {
                $color_new->product_image2 = $color['product_image4'];
            }
            if (isset($color['product_image5'])) {
                $color_new->product_image2 = $color['product_image5'];
            }
            $color_new->product_id = $product->product_id;
            $color_new->save();
            foreach ($color['sizes'] as $size) {
                $size_new = new Size();
                $size_new->size_name = $size['size_name'];
                $size_new->quantity = $size['quantity'];
                $size_new->color_id = $color_new->color_id;
                $size_new->save();
            }
        }
        return new ProductResource(Product::findOrFail($product->product_id));;
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
        return new ProductResource(Product::findOrFail($id));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::find($id);
        $product->delete();
        return response()->json("success");
    }
}
