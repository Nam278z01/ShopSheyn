<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;

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
        return Product::with(['subcategory', 'colors', 'colors.sizes'])->orderByDesc('created_time')->get();
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
        $admin = $request->user();
        $product = new Product();
        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->product_discount = $request->product_discount;
        $product->subcategory_id = $request->subcategory_id;
        $product->admin_created_id = $admin->admin_id;
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
                $color_new->product_image3 = $color['product_image3'];
            }
            if (isset($color['product_image4'])) {
                $color_new->product_image4 = $color['product_image4'];
            }
            if (isset($color['product_image5'])) {
                $color_new->product_image5 = $color['product_image5'];
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
        return Product::with(['subcategory', 'colors', 'colors.sizes'])->findOrFail($product->product_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProduct($id)
    {
        //
        return Product::with(['subcategory', 'subcategory.category', 'colors', 'colors.sizes'])->findOrFail($id);
    }

    public function getProductBySubcategory($id)
    {
        //
        return Product::with(['subcategory', 'subcategory.category', 'colors', 'colors.sizes'])
            ->where('subcategory_id', $id)
            ->inRandomOrder()
            ->limit(10)
            ->get();
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
        $admin = $request->user();
        $product = Product::findOrFail($id);
        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->product_discount = $request->product_discount;
        $product->subcategory_id = $request->subcategory_id;
        $product->admin_updated_id = $admin->admin_id;
        $product->save();

        $colors_old = Color::where('product_id', $id)->get();

        foreach ($request->colors as $color) {
            $exists = false;
            foreach ($colors_old as $color_old) {
                if(isset($color['color_id']) && $color['color_id'] == $color_old->color_id) {
                    $color_old->color_name = $color['color_name'];
                    $color_old->product_price = $color['product_price'];
                    $color_old->product_image1 = $color['product_image1'];
                    $color_old->product_image2 = $color['product_image2'];
                    $color_old->product_image3 = $color['product_image3'];
                    $color_old->product_image4 = $color['product_image4'];
                    $color_old->product_image5 = $color['product_image5'];
                    $color_old->save();
                    $exists = true;
                    // Update Size
                    $sizes_old = Size::where('color_id', $color['color_id'])->get();
                    foreach ($color['sizes'] as $size) {
                        $exists_size = false;
                        foreach ($sizes_old as $size_old) {
                            if(isset($size['size_id']) && $size['size_id'] == $size_old->size_id) {
                                $size_old->size_name = $size['size_name'];
                                $size_old->quantity = $size['quantity'];
                                $size_old->save();

                                $exists_size = true;
                                break;
                            }
                        }
                        if(!$exists_size) {
                            $size_new = new Size();
                            $size_new->size_name = $size['size_name'];
                            $size_new->quantity = $size['quantity'];
                            $size_new->color_id =  $color['color_id'];
                            $size_new->save();
                        }
                    }

                    foreach ($sizes_old as $size_old) {
                        $exists_size = false;
                        foreach ($color['sizes'] as $size) {
                            if(isset($size['size_id']) && $size['size_id'] == $size_old->size_id) {
                                $exists_size = true;
                                break;
                            }
                        }
                        if(!$exists_size) {
                            Size::find($size_old->size_id)->delete();
                            $size_old->save();
                        }
                    }
                    break;
                }
            }
            if(!$exists) {
                $color_new = new Color();
                $color_new->color_name = $color['color_name'];
                $color_new->product_price = $color['product_price'];
                $color_new->product_image1 = $color['product_image1'];
                if (isset($color['product_image2'])) {
                    $color_new->product_image2 = $color['product_image2'];
                }
                if (isset($color['product_image3'])) {
                    $color_new->product_image3 = $color['product_image3'];
                }
                if (isset($color['product_image4'])) {
                    $color_new->product_image4 = $color['product_image4'];
                }
                if (isset($color['product_image5'])) {
                    $color_new->product_image5 = $color['product_image5'];
                }
                $color_new->product_id = $id;
                $color_new->save();
                // Update Size
                foreach ($color['sizes'] as $size) {
                    $size_new = new Size();
                    $size_new->size_name = $size['size_name'];
                    $size_new->quantity = $size['quantity'];
                    $size_new->color_id = $color_new->color_id;
                    $size_new->save();
                }
            }
        }

        // Delete Color
        foreach ($colors_old as $color_old) {
            $exists = false;
            foreach ($request->colors as $color) {
                if(isset($color['color_id']) && $color['color_id'] == $color_old->color_id) {
                    $exists = true;
                    break;
                }
            }
            if(!$exists) {
                Color::find($color_old->color_id)->delete();
                $color_old->save();
            }
        }

        return Product::with(['subcategory', 'colors', 'colors.sizes'])->findOrFail($id);
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
