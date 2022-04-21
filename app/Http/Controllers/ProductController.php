<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

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
        $page = request()->get('page');
        $page_size = request()->get('page_size');
        $category_id = request()->get('category_id');
        $list_subcategory_id = request()->get('list_subcategory_id');
        $textSearch = request()->get('textSearch');
        $min_price1 = request()->get('min_price1');
        $max_price1 = request()->get('max_price1');
        $sort = request()->get('sort');
        $data = DB::select('call getProductsSearch(?, ?, ?, ?, ?, ?, ?, ?, @total_row)', [$page, $page_size, $category_id, $list_subcategory_id, $textSearch, $min_price1, $max_price1, $sort]);
        $total_row = DB::select('select @total_row as total_row');
        return ["data" => json_decode($data[0]->data), "total_row" => $total_row[0]->total_row];
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
    }
}
