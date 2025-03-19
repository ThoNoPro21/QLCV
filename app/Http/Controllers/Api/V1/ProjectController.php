<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            // Lấy tất cả các dự án
            $userId = auth()->id();
            $employee = Employee::where('userId', $userId)->first();
            
            if (!$employee) {
                return response()->json(['success' => false, 'message' => 'Không tìm thấy nhân viên']);
            }
            
            $createdProjects = $employee->createdProjects; 
            $joinedProjects = $employee->projects; 
        
            // Gộp tất cả dự án vào một mảng chung
            $allProjects = $createdProjects->merge($joinedProjects);
            
            // Trả về danh sách dự án
            return response()->json([
                'success' => true,
                'message' => 'Lấy danh sách dự án thành công!',
                'data' => $allProjects,
            ], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách dự án!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'ProjectName' => 'required|max:255',
            'EmployeeID' => 'required|numeric',
        ], [
            'ProjectName.required' => 'Không được bỏ trống !',
            'ProjectName.max' => 'Tối đa 255 kí tự!',
            'EmployeeID.required' => 'Không được bỏ trống !',
            'EmployeeID.numeric' => 'Phải là 1 số !',
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
    public function edit(Request $request,string $id)
    {
        //
        $validated = $request->validate([
            'ProjectName' => [
                'required',
                'max:255',
                Rule::unique('projects', 'ProjectName')->ignore($id,'ProjectID'), // Kiểm tra unique nhưng bỏ qua bản ghi hiện tại
            ],
            'EmployeeID' => 'required|numeric',
        ], [
            'ProjectName.required' => 'Không được bỏ trống!',
            'ProjectName.max' => 'Tối đa 255 kí tự!',
            'ProjectName.unique' => 'Tên dự án đã tồn tại!',
            'EmployeeID.required' => 'Không được bỏ trống!',
            'EmployeeID.numeric' => 'Phải là một số!',
        ]);

        try {            
            // Tìm bản ghi cần cập nhật
            $project = Project::where('ProjectID',$id)->first();

            // Kiểm tra xem EmployeeID có phải là người tạo dự án hay không
            if ($project->EmployeeID !==(int) $request['EmployeeID']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền sửa dự án này!',
                ], 403);
            }

            // Cập nhật dữ liệu
            $project->update([
                'ProjectName' => $validated['ProjectName'],
            ]);

            // Trả về phản hồi
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công!',
                'data' => $project,
            ], 200);
        } catch (\Exception $e) {
            // Return error response if saving fails
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi sửa dữ liệu!',
                'error' => $e->getMessage(),
            ], 500);
        }
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
    public function delete(string $id)
    {
        try {
            // Kiểm tra ID có hợp lệ không (có phải là số không)
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID không hợp lệ!',
                ], 400);
            }
    
            // Tìm bản ghi dự án cần xóa
            $project = Project::find($id);
    
            // Kiểm tra bản ghi có tồn tại hay không
            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dự án không tồn tại!',
                ], 404);
            }
    
            // Xóa bản ghi
            $project->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Xóa dự án thành công!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa dự án!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}