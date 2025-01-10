<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Subsciption;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $validated = $request->validate([
            'Name' => 'required|max:255',
            'Price' => 'required|numeric|min:0',
            'PriceSale' => 'required|numeric|min:0',
            'Feature' => 'required',
        ], [
            'Name.required' => 'Không được bỏ trống !',
            'Name.max' => 'Tối đa 255 kí tự!',
            'Price.required' => 'Không được bỏ trống !',
            'Price.numeric' => 'Phải là 1 số',
            'Price.min' => 'Phải lớn hơn 1',
            'PriceSale.required' => 'Không được bỏ trống !',
            'PriceSale.numeric' => 'Phải là 1 số',
            'PriceSale.min' => 'Phải lớn hơn 1',
            'Feature.required' => 'Không được bỏ trống !',
            ]);
        if ($validated['PriceSale'] > $validated['Price']) {
            return response()->json(['PriceSale' => 'Giá sale phải nhỏ hơn giá gốc !'],400);
        }

            try {            
                $subsciption = new Subsciption();
    
                $subsciption->Name = $request->Name;
                $subsciption->Price = $request->Price;
                $subsciption->PriceSale = $request->PriceSale;
                $subsciption->Feature = $request->Feature;

                $subsciption->save();
                return response() -> json([
                    'success' => true,
                    'message' => 'Thành công !']);
            } catch (\Exception $e) {
                // Return error response if saving fails
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi khi tạo dữ liệu!',
                    'error' => $e->getMessage(),
                ], 500);
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}