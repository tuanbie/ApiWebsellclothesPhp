<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\khachhang;
use App\Http\Resources\khachhang as KhachhangResource;
use Illuminate\Support\Facades\Validator;

class KhachhangController extends Controller
{
    public function index()
    {
        $khachhangs = khachhang::select(
            'id',
            'ten', 
            'sdt',
            'email', 
            'diachi',
            'matkhau',
            'created_at',
            'updated_at')->get();
        return response()->json($khachhangs);
    }

    public function store(Request $request, khachhang $khachhangs) //add custommer
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'ten' => 'required', 
            'sdt' => 'required', 
            'email' => 'required|unique:khachhang,email',
            'diachi' => 'required',
            'matkhau' => 'required'
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
        $khachhangs->matkhau = bcrypt($input['matkhau']);
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
    public function show(string $id) //show custommer by id
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

    public function update(Request $request, $id)//update
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


    public function destroy($id)//delete
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

    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => 'required',
            'matkhau' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi dữ liệu đầu vào',
                'data' => $validator->errors()
            ], 200);
        }
        $khachhang = khachhang::where('email', $input['email'])->first();
        if (!$khachhang) {
            return response()->json([
                'status' => false,
                'message' => 'Tài khoản không tồn tại',
                'data' => null
            ], 200);
        }
        if (!Hash::check($input['matkhau'], $khachhang->matkhau)) {
            return response()->json([
                'status' => false,
                'message' => 'Mật khẩu không đúng',
                'data' => null
            ], 200);
        }
        $token = $khachhang->createToken('token')->accessToken;
        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công',
            'data' => [
                'khachhang' => new KhachhangResource($khachhang),
                'access_token' => $token
            ]
        ], 200);
    }
}
