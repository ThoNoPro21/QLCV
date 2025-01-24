<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\StatusTask;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StatusTaskController extends Controller
{
    //
    public function index(string $id)
    {
        //
            $statusTask =StatusTask::where('ProjectID',$id)->get();
            try {
    
            // Trả về danh sách dự án
            return response()->json([
                'success' => true,
                'message' => 'Lấy danh sách trạng thái Task thành công!',
                'data' => $statusTask,
            ], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách trạng thái Task!',
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
            'StatusName' => 'required|max:255',
            'ProjectID' => 'required|numeric|min:0',
        ], [
            'StatusName.required' => 'Không được bỏ trống !',
            'StatusName.max' => 'Tối đa 255 kí tự!',
            'ProjectID.required' => 'Không được bỏ trống !',
            'ProjectID.numeric' => 'Phải là 1 số',
    
        ]);

        try {            
            $statusTask = new StatusTask();

            $statusTask->StatusName = $request->StatusName;
            $statusTask->ProjectID = $request->ProjectID;

            $statusTask->save();
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
    public function edit(Request $request,string $id)
    {
        //
         //
         $validated = $request->validate([
            'StatusName' => [
                'required',
                'max:255',
                Rule::unique('statustask', 'StatusName')->ignore($id,'StatustTaskID'), // Kiểm tra unique nhưng bỏ qua bản ghi hiện tại
            ],
            'ProjectID' => 'required|numeric',
        ], [
            'StatusName.required' => 'Không được bỏ trống!',
            'StatusName.max' => 'Tối đa 255 kí tự!',
            'StatusName.unique' => 'Tên trạng thái đã tồn tại!',
            'ProjectID.required' => 'Không được bỏ trống!',
            'ProjectID.numeric' => 'Phải là một số!',
        ]);

        try {            
            // Tìm bản ghi cần cập nhật
            $statusTask = StatusTask::where('StatustTaskID',$id)->first();

            // Cập nhật dữ liệu
            $statusTask->update([
                'StatusName' => $validated['StatusName'],
            ]);

            // Trả về phản hồi
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công!',
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
        //
        try {
            // Kiểm tra ID có hợp lệ không (có phải là số không)
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID không hợp lệ!',
                ], 400);
            }
    
            // Tìm bản ghi dự án cần xóa
            $statusTask = StatusTask::find($id);
    
            // Kiểm tra bản ghi có tồn tại hay không
            if (!$statusTask) {
                return response()->json([
                    'success' => false,
                    'message' => 'Trạng thái Task không tồn tại!',
                ], 404);
            }
    
            // Xóa bản ghi
            $statusTask->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Xóa trạng thái thành công!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa trạng thái task!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}