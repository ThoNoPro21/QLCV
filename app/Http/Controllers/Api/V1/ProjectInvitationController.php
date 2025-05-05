<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\ProjectInvitationMail;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class ProjectInvitationController extends Controller
{
    //
    public function invite(Request $request, $projectId)
    {
        $request->validate([
            'email' => 'required|email'
        ],
        [
            'email.required' => 'Không được bỏ trống!',]);
    
        $exists = ProjectInvitation::where('ProjectID', $projectId)
            ->where('email', $request->email)
            ->whereIn('status', ['pending', 'accepted', 'declined'])
            ->exists();
        if (!$projectId || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'message' => 'Dữ liệu đầu vào không hợp lệ.',
            ], 400);
        }
        if ($exists) {
            return response()->json(['message' => 'Bạn đã gửi lời mời đến email này rồi, vui lòng không gửi lại!'], 400);
        }
      
        $token = Str::uuid();
        $invitation = ProjectInvitation::create([
            'ProjectID' => $projectId,
            'email' => $request->email,
            'token' => $token,
            'status' => 'pending',
        ]);
        if (!$invitation) {
            return response()->json([
                'message' => 'Không thể tạo lời mời.',
            ], 500);
        }
    
        try {
            Mail::to($request->email)->send(new ProjectInvitationMail($invitation));
            return response()->json([
                'message' => 'Lời mời đã được gửi thành công.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Không thể gửi email. Vui lòng kiểm tra cấu hình mail.',
                'error' => $e->getMessage(),
            ], 500);
        }
    
    }
      public function accept(Request $request,$token)
    {
        $invitation = ProjectInvitation::where('token', $token)
                                    ->where('status', 'pending')
                                    ->first();
        if (! $invitation) {
            return response()->json(['message' => 'Lời mời không hợp lệ hoặc đã được xử lý.'], 404);
        }
       
        if (!Auth::check()) {
            session()->put('oauth_invitation_token', $token);
            return redirect()->away(url('/redirect?invitation_token=' . $token));
        }
        $user = Auth::user();
        $employee = Employee::where('userId', $user->id)->first();

        if ($user->email !== $invitation->email) {
            return redirect()->away('http://localhost:3000?message=' . urlencode('Email của nhân viên không khớp với lời mời.'));
        }

        $project = Project::find($invitation->ProjectID);
        if (!$project) {
            return response()->json(['message' => 'Dự án không tồn tại.'], 404);
        }
        
        DB::transaction(function () use ($invitation, $employee, $project) {
            $project->members()
                    ->syncWithoutDetaching([
                        $employee->EmployeeID => ['Role' => 'member']
                    ]);

            $invitation->update(['status' => 'accepted']);
        });

        return redirect("http://localhost:3000/project/{$project->ProjectID}?joined=true");

      
    }
}