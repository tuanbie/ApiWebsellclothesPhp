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
    public function index(): Response
    {
        //
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
    public function show(string $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        //
    }
}
