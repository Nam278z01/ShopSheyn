<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function getCategories()
    {
        //
        return Category::with('subcategories')->get();
    }
}
