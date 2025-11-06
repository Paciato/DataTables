<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query();
        return DataTables::of($products)
            ->addColumn('action', function ($product) {

                $showBtn =  '<button ' .
                    ' class="btn btn-outline-info" ' .
                    ' onclick="showProduct(' . $product->id . ')">Show' .
                    '</button> ';

                $editBtn =  '<button ' .
                    ' class="btn btn-outline-success" ' .
                    ' onclick="editProduct(' . $product->id . ')">Edit' .
                    '</button> ';

                $deleteBtn =  '<button ' .
                    ' class="btn btn-outline-danger" ' .
                    ' onclick="destroyProduct(' . $product->id . ')">Delete' .
                    '</button> ';

                return $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(
                [
                    'action',
                ]
            )
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();
        return response()->json(['status' => "success"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        return response()->json(['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        request()->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->save();
        return response()->json(['status' => "success"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        return response()->json(['status' => "success"]);
    }
}
