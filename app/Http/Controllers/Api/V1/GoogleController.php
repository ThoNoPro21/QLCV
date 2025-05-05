<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectInvitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;


class GoogleController extends Controller
{
    public function redirect(Request $request)
    {
        $invitationToken = $request->query('invitation_token');
        if ($invitationToken) {
            session()->put('oauth_invitation_token', $invitationToken);
            return Socialite::driver('google')
                ->with(['state' => $invitationToken])
                ->redirect();
        }

        return Socialite::driver('google')->redirect();
    }

    public function loginCallback(Request $request)
    {
        $getInfo = Socialite::driver('google')->stateless()->user();
        $user = $this->createUser($getInfo);

        if ($user) {
            Auth::login($user,true);
            $token = $user->createToken('google-auth')->plainTextToken;
            $invitationToken = session()->pull('oauth_invitation_token');

            if ($invitationToken) {
                return redirect()->to('/accept-invite/' . $invitationToken)
                    ->withCookie(cookie('auth_token', $invitationToken, 60, null, null, true, true));
            }

            return redirect()->away('http://localhost:3000?token=' . $token);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không thể tạo hoặc xác thực người dùng.'
        ], 400);
    }
    function createUser($getInfo)
    {
        $user = User::where('google_id', $getInfo->id)->first();
        if (!$user) {
            $user = User::updateOrCreate([
                'google_id' => $getInfo->getId(),
            ], [
                'fullname' => $getInfo->getName(),
                'email' => $getInfo->getEmail(),
                'avatar' => $getInfo->getAvatar(),
                'password' => Hash::make(Str::random(16))
            ]);
            Employee::updateOrCreate([
                'userId' => $user->id,
            ], [
                'Address' => '123 Lê Duẫn',
                'Dateofbirth' => '2001-11-21',
                'Role' => 'user',
                'SubsciptionID' =>1
            ]);
        }
        return $user;
    }

}