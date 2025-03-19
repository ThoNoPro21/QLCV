<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TaskCard;
use Illuminate\Http\Request;

class TaskCardController extends Controller
{
    
    public function index(string $id)
    {
        //
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'TaskCardName' => 'required|max:255',
            'StatustTaskID' => 'required|numeric|min:0',
            'EmployeeID' => 'required|numeric|min:0',
        ], [
            'TaskCardName.required' => 'Không được bỏ trống !',
            'TaskCardName.max' => 'Tối đa 255 kí tự!',
            'StatustTaskID.required' => 'Không được bỏ trống !',
            'StatustTaskID.numeric' => 'Phải là 1 số',
            'EmployeeID.required' => 'Không được bỏ trống !',
            'EmployeeID.numeric' => 'Phải là 1 số',
        ]);

        try {            
            $taskCard = new TaskCard();

            $taskCard->TaskCardName = $request->TaskCardName;
            $taskCard->StatustTaskID = $request->StatustTaskID;
            $taskCard->EmployeeID = $request->EmployeeID;

            $taskCard->save();
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
            'TaskCardName' => [
                'required',
                'max:255',
            ],
            'StatustTaskID' => 'required|numeric',
            'EmployeeID' => 'required|numeric',
        ], [
            'TaskCardName.required' => 'Không được bỏ trống!',
            'TaskCardName.max' => 'Tối đa 255 kí tự!',
            'StatustTaskID.required' => 'Không được bỏ trống!',
            'StatustTaskID.numeric' => 'Phải là một số!',
            'EmployeeID.required' => 'Không được bỏ trống!',
            'EmployeeID.numeric' => 'Phải là một số!',
        ]);

        try {            
            // Tìm bản ghi cần cập nhật
            $taskCard = TaskCard::where('TaskCardID',$id)->first();

            // Cập nhật dữ liệu
            $taskCard->update([
                'TaskCardName' => $validated['TaskCardName'],
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
            $taskCard = TaskCard::find($id);
    
            // Kiểm tra bản ghi có tồn tại hay không
            if (!$taskCard) {
                return response()->json([
                    'success' => false,
                    'message' => 'Thẻ không tồn tại!',
                ], 404);
            }
    
            // Xóa bản ghi
            $taskCard->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Xóa thẻ thành công!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa thẻ task!',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}