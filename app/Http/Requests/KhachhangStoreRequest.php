<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KhachhangStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules()
    {
        if(request()->isMethod('post')) {
            return [
                'ten' => 'required|string|max:255',
                'mota' => 'required|string',
                'trangthai' => 'required|integer',
                'soluong' => 'required|integer|min:0',
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
