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
        $khachhangs = khachhang::select('id','ten', 'sdt','email', 'diachi')->get();
        return response()->json($khachhangs);
    }

    public function store(Request $request, khachhang $khachhangs)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'ten' => 'required', 'sdt' => 'required', 'email' => 'required','diachi' => 'required'
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
        $khachhangs->email = $input['email'];
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
    public function update(Request $request, khachhang $khachhangs, $id)
    {   
        $input = $request->all();
        $validator = Validator::make($input, [
            'ten' => 'required', 'sdt' => 'required', 'email' => 'required', 'diachi' => 'required'
        ]);
        if($validator->fails()){
            $arr = [
            'success' => false,
            'message' => 'Lỗi dữ liệu đầu vào',
            'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $khachhang = $khachhangs->find($id);
        if(!$khachhang){
            $arr = [
                'status' => false,
                'message' => 'Không tìm thấy khách hàng',
            ];
            return response()->json($arr, 404);
        }
        $khachhang->ten = $input['ten'];
        $khachhang->sdt = $input['sdt'];
        $khachhang->diachi = $input['diachi'];
        $khachhang->save();
        $arr = [
            'status' => true,
            'message' => 'Cập nhật thành công',
            'data' => new KhachhangResource($khachhang)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(khachhang $khachhangs)
    {
        $khachhangs->delete();
        $arr = [
           'status' => true,
           'message' =>'Sản phẩm đã được xóa',
           'data' => [],
        ];
        return response()->json($arr, 200);
    }
}