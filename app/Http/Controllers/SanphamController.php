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
use App\Http\Resources\Sanpham as SanphamResource;


class SanphamController extends Controller
{
    public function index()
    {
        $products = sanpham::select(
            'id',
            'ten', 
            'hinh',
            'mota',
            'trangthai',
            'soluong',
            'created_at',
            'updated_at'
            )->get()->map(function ($product) {
            $product['hinh'] = $imageLink = Storage::url( $product['hinh']);
            return $product;
        });
        return response()->json(['products' => $products], 200);
    }
    public function create()
    {
        
    }
    public function store(SanphamStoreRequest $request)
    {
        try {
            $hinh = Str::random(32).".".$request->hinh->getClientOriginalExtension();
     
            // thêm sản pahamr
            $sanpham = sanpham::create([
                'ten' => $request->ten,
                'hinh' => $hinh,
                'mota' => $request->mota,
                'trangthai' => $request->trangthai,
                'soluong' => $request->soluong,
            ]);
     
            // thêm hình vào thư mục storage liên kết với server
            Storage::disk('public')->put($hinh, file_get_contents($request->hinh));
    
            $imageLink = Storage::url($hinh);
            
            return response()->json([
                'message' => "Thêm sản phẩm thành công !",
                'data' => [
                    'id' => $sanpham->id,
                    'ten' => $sanpham->ten,
                    'hinh' => $imageLink,
                    'mota' => $sanpham->mota,
                    'trangthai' => $sanpham->trangthai,
                    'soluong' => $sanpham->soluong,
                    'created_at' => $sanpham->created_at->format('d/m/Y H:i:s'),
                    'updated_at' => $sanpham->updated_at->format('d/m/Y H:i:s'),]
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Lỗi!"
            ],500);
        }
    }
    public function show(string $id)
    {
       $product = sanpham::find($id);
       if(!$product){
         return response()->json([
            'message'=>'Product Not Found.'
         ],404);
       }
       $imageLink = Storage::url($product->hinh);
       $product->hinh = $imageLink;
       return response()->json([
          'product' => $product
       ],200);
    }

    public function edit(SanphamStoreRequest $request,string $id)
    {
        
    }

    public function update(SanphamStoreRequest $request, string $id)//cập nhật
    {
        try {
            //tìm kienems ản phẩm
            $product = sanpham::find($id);
            if(!$product){
              return response()->json([
                'message'=>'Không tìm thấy sản phẩm'
              ],404);
            }
            //kiểm tra thông tin đầu vào
            $product->ten = $request->ten;
            $product->mota = $request->mota;
            $product->trangthai = $request->trangthai;
            $product->soluong = $request->soluong;
            //cập nhật hình ảnh
            if($request->hinh) {
                $storage = Storage::disk('public');
                if($storage->exists($product->hinh))
                    $storage->delete($product->hinh);
                $imageName = Str::random(32).".".$request->hinh->getClientOriginalExtension();
                $product->hinh = $imageName;
                $storage->put($imageName, file_get_contents($request->hinh));
            }
            //lưu sản phẩm vào db
            $product->save();
            $imageLink = Storage::url($imageName);
            return response()->json([
                'message' => "Sửa sản phẩm thành công",
                'data'=>[
                    'id' => $product->id,
                    'ten' => $product->ten,
                    'mota' => $product->mota,
                    'trangthai' => $product->trangthai,
                    'soluong' => $product->soluong,
                    'hinh' => $imageLink,
                    'created_at' => $product->created_at->format('d/m/Y H:i:s'),
                    'updated_at' => $product->updated_at->format('d/m/Y H:i:s'),
                ]
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Lỗi!"
            ],500);
        }
    }

    public function destroy($id)//xóa sản phẩm
    {
        $product = sanpham::find($id);
        if(!$product){
          return response()->json([
             'message'=>'Không tim thấy sản phẩm.'
          ],404);
        }
     
        $storage = Storage::disk('public');
     
        if($storage->exists($product->hinh))
            $storage->delete($product->hinh);
     
        $product->delete();
     
        return response()->json([
            'message' => "Xóa sản phẩm thành công!"
        ],200);
    }
}