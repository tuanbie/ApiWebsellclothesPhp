<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\sanpham;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class SanphamStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        if(request()->isMethod('post')) {
            return [
                'ten' => 'required|string|max:258',
                'hinh' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'mota' => 'required|string',
                'trangthai' => 'required|string',
                'soluong'=>'required|string'
            ];
        } else {
            return [
                'ten' => 'required|string|max:258',
                'hinh' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'mota' => 'required|string',
                'trangthai' => 'required|string',
                'soluong'=>'required|string'
            ];
        }
    }
    public function messages()
    {
        if(request()->isMethod('post')) {
            return [
                'ten.required' => 'Name is required!',
                'hinh.required' => 'Image is required!',
                'mota.required' => 'Descritpion is required!',
                'trangthai.required' => 'Status is required!',
                'soluong.required' => 'Quality is required!'
            ];
        } else {
            return [
                'ten.required' => 'Name is required!',
                'mota.required' => 'Descritpion is required!',
                'trangthai.required' => 'Status is required!',
                'soluong.required' => 'Quality is required!'
            ];   
        }
    }
}
