<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
        
        $validated = $request->validate([
            'ProjectName' => 'required|max:255',
            'Role' => 'required|in:manager,user',
            'EmployeeID' => 'required',
        ], [
            'ProjectName.required' => 'Không được bỏ trống !',
            'EmployeeID.max' => 'Tối đa 255 kí tự!',
            'Role.required' => 'Không được bỏ trống !',
            'Role.in' => 'Chỉ có thể là manager hoặc user',
            'EmployeeID.required' => 'Không được bỏ trống !',
            ]);

            try {            
                $projetc = new Project();
    
                $projetc->ProjectName = $request->ProjectName;
                $projetc->Role = 'manager';
                $projetc->Background = $request->Background ?? 'none';
                $projetc->Status = $request->Status ?? 0;
                $projetc->EmployeeID = $request->EmployeeID;
        
                $projetc->save();
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