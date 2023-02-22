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

    public function store(Request $request, khachhang $khachhangs)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'ten' => 'required', 'sdt' => 'required', 'diachi' => 'required'
        ]);
        if($validator->fails()){
            $arr = [
            'success' => false,
            'message' => 'Lỗi dữ liệu đầu vào',
            'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $khachhangs->ten = $input['ten'];
        $khachhangs->sdt = $input['sdt'];
        $khachhangs->diachi = $input['diachi'];
        $khachhangs->save();
        $arr = [
            'status' => true,
            'message' => 'Thêm thành công',
            'data' => new KhachhangResource($khachhangs)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, khachhang $product)
    {
        // $input = $request->all();
        // $validator = Validator::make($input, [
        //     'ten' => 'required', 'sdt' => 'required', 'diachi' => 'required'
        // ]);
        // if($validator->fails()){
        //     $arr = [
        //     'success' => false,
        //     'message' => 'Lỗi kiểm tra dữ liệu',
        //     'data' => $validator->errors()
        //     ];
        //     return response()->json($arr, 200);
        // }
        // $product->ten = $input['ten'];
        // $product->sdt = $input['sdt'];
        // $product->diachi = $input['diachi'];
        // $product->save();
        // $arr = [
        //     'status' => true,
        //     'message' => 'Khách hàng cập nhật thành công',
        //     'data' => new KhachhangResource($product)
        // ];
        // return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(khachhang $product)
    {
        $product->delete();
        $arr = [
           'status' => true,
           'message' =>'Sản phẩm đã được xóa',
           'data' => [],
        ];
        return response()->json($arr, 200);
    }
}