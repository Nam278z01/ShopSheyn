<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Size;

class ProductController extends Controller
{
    //
    public function search(Request $request)
    {
        //
        $page = $request->get('page');
        $page_size = $request->get('page_size');
        $category_id = $request->get('category_id');
        $list_subcategory_id = $request->get('list_subcategory_id');
        $text_search = $request->get('text_search');
        $min_price = $request->get('min_price');
        $max_price = $request->get('max_price');
        $sort = $request->get('sort');
        $data = DB::select('call getProductsSearch(?, ?, ?, ?, ?, ?, ?, ?, @total_row)', [$page, $page_size, $category_id, $list_subcategory_id, $text_search, $min_price, $max_price, $sort]);
        $total_row = DB::select('select @total_row as total_row');
        return ["data" => json_decode($data[0]->data), "total_row" => $total_row[0]->total_row];
    }

    public function getProduct($id)
    {
        //
        return Product::with(['subcategory', 'subcategory.category', 'colors', 'colors.sizes'])->findOrFail($id);
    }

    public function getProductsBySubcategory($subcategory_id, $product_id)
    {
        //
        return Product::with(['subcategory', 'subcategory.category', 'colors', 'colors.sizes'])
            ->where('subcategory_id', $subcategory_id)
            ->where('product_id', '<>', $product_id)
            ->inRandomOrder()
            ->limit(10)
            ->get();
    }

    public function getQuantity($id) {
        return Size::findOrFail($id);
    }
}
