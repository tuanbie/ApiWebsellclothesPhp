<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\sanpham;
use App\http\Requests\SanphamStoreRequest;

class SanphamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // All Product
       $products = sanpham::all();
     
       // Return Json Response
       return response()->json([
          'products' => $products
       ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SanphamStoreRequest $request)
    {
        try {
            $hinh = Str::random(32).".".$request->hinh->getClientOriginalExtension();
     
            // Create Product
            sanpham::create([
                'ten' => $request->ten,
                'hinh' => $hinh,
                'mota' => $request->mota,
                'trangthai' => $request->trangthai,
                'soluong' => $request->soluong,
            ]);
     
            // Save Image in Storage folder
            Storage::disk('public')->put($hinh, file_get_contents($request->hinh));
     
            // Return Json Response
            return response()->json([
                'message' => "Product successfully created."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         // Product Detail 
       $product = sanpham::find($id);
       if(!$product){
         return response()->json([
            'message'=>'Product Not Found.'
         ],404);
       }
     
       // Return Json Response
       return response()->json([
          'product' => $product
       ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SanphamStoreRequest $request, string $id)
    {
        try {
            // Find product
            $product = sanpham::find($id);
            if(!$product){
              return response()->json([
                'message'=>'Product Not Found.'
              ],404);
            }
     
            $product->ten = $request->ten;
            $product->mota = $request->mota;
            $product->trangthai = $request->trangthai;
            $product->soluong = $request->soluong;
            if($request->hinh) {
                // Public storage
                $storage = Storage::disk('public');
     
                // Old iamge delete
                if($storage->exists($product->hinh))
                    $storage->delete($product->hinh);
     
                // Image name
                $imageName = Str::random(32).".".$request->hinh->getClientOriginalExtension();
                $product->hinh = $imageName;
     
                // Image save in public folder
                $storage->put($imageName, file_get_contents($request->hinh));
            }
     
            // Update Product
            $product->save();
     
            // Return Json Response
            return response()->json([
                'message' => "Product successfully updated."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => "Something went really wrong!"
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Detail 
        $product = sanpham::find($id);
        if(!$product){
          return response()->json([
             'message'=>'Product Not Found.'
          ],404);
        }
     
        // Public storage
        $storage = Storage::disk('public');
     
        // Iamge delete
        if($storage->exists($product->hinh))
            $storage->delete($product->hinh);
     
        // Delete Product
        $product->delete();
     
        // Return Json Response
        return response()->json([
            'message' => "Product successfully deleted."
        ],200);
    }
}
