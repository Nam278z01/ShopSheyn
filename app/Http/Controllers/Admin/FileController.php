<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
    //
    public function addFiles(Request $request)
    {
        //
        if ($request->hasFile('files')) {
            $array_name = [];
            $files = $request->file('files');
            foreach ($files as $file) {
                $name = uniqid() . $file->getClientOriginalName();
                $array_name[] = $name;
                $file->move(public_path('/image/product/'), $name);
            }
            return $array_name;
        } else {
            return response()->json("failed");;
        }
    }
    public function deleteFiles(Request $request)
    {
        if ($request->has('paths')) {
            foreach($request->paths as $path) {
                File::delete(public_path("/image/product/" . $path));
            }
            return response()->json("success");
        } else {
            return response()->json("failed");
        }
    }
}
