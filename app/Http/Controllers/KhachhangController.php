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
        $khachhang = khachhang::find($id);
        if(!$khachhang){
          return response()->json([
             'message'=>'Không tìm thấy khách hàng!.'
          ],404);
        }
      
        // Return Json Response
        return response()->json([
           'khachhang' => $khachhang
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {   
        try {
            //tìm kiếm khách hàng
            $khachhang = khachhang::find($id);
            if(!$khachhang){
              return response()->json([
                'message'=>'Không tìm thấy khách hàng'
              ],404);
            }

            $khachhang->ten = $request->ten;
            $khachhang->sdt = $request->sdt;
            $khachhang->email = $request->email;
            $khachhang->diachi = $request->diachi;
            //lưu khách hàng vào db
            $khachhang->save();
            return response()->json([
                'message' => "Sửa sản phẩm thành công",
                'data'=>[
                    'id' => $khachhang->id,
                    'ten' => $khachhang->ten,
                    'mota' => $khachhang->sdt,
                    'trangthai' => $khachhang->email,
                    'soluong' => $khachhang->diachi,
                    'created_at' => $khachhang->created_at->format('d/m/Y H:i:s'),
                    'updated_at' => $khachhang->updated_at->format('d/m/Y H:i:s'),
                ]
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Lỗi!"
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $khachhang = khachhang::find($id);
        if(!$khachhang){
          return response()->json([
             'message'=>'Không tim thấy khách hàng.'
          ],404);
        }
        $khachhang->delete();
        return response()->json([
            'message' => "Xóa khách hàng thành công!"
        ],200);
    }
}