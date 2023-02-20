<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\khachhang;
use App\Http\Resources\khachhang as KhachhangResource;
use Illuminate\Support\Facades\Validator;

class KhachhangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $khachhangs = khachhang::select('id','ten', 'sdt', 'diachi')->get();
        return response()->json($khachhangs);
    }

    public function store(Request $request)
    {
        $input = $request->all(); 
        $validator = Validator::make($input, [
        'ten' => 'required', 'sdt' => 'required','diachi' => 'required'
        ]);
        if($validator->fails()){
            $arr = [
            'success' => false,
            'message' => 'Lỗi kiểm tra dữ liệu',
            'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $product = khachhang::create($input);
        $arr = ['status' => true,
            'message'=>"Khách hàng đã lưu thành công",
            'data'=> new KhachhangResource($product)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        //
    }
}