<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;


class GoogleController extends Controller
{
    public function redirect()
    {
        try {
            return Socialite::driver('google') ->stateless() ->scopes([
                'profile', 
                'https://www.googleapis.com/auth/user.birthday.read', 
                'https://www.googleapis.com/auth/user.addresses.read'
            ])->redirect();
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    public function loginCallback(Request $request)
    {
        try {

            $getInfo = Socialite::driver('google')->stateless()->user();
            $user = $this->createUser($getInfo);

            if ($user) {
                Auth::login($user);
                return response()->json([
                    'success' => true,
                    'token' => $user->createToken($user->google_id)->plainTextToken,
                    'status' => __('google sign in successful'),
                ]);
            }
          
        } catch (\Exception $exception) {
            return response()->json([
                'success' => $user,
                'status' => __('google sign in failed'),
                'error' => $exception,
                'message' => $exception->getMessage()
            ],);
        }
    }
    function createUser($getInfo)
    {
        $birthDate = $getInfo['birthday'] ?? null; // Ngày sinh (nếu có)
        $address = $getInfo['addresses'][0]['formattedValue'] ?? null; // Địa chỉ (nếu có)
        $user = User::where('google_id', $getInfo->id)->first();
        if (!$user) {
            $user = User::updateOrCreate([
                'google_id' => $getInfo->getId(),
            ], [
                'fullname' => $getInfo->getName(),
                'email' => $getInfo->getEmail(),
                'avatar' => $getInfo->getAvatar(),
                'password' => 'password'
            ]);
            Employee::updateOrCreate([
                'userId' => $user->id,
            ], [
                'Address' => $address,
                'Dateofbirth' => $birthDate,
                'Role' => 'user',
                'SubsciptionID' =>1
            ]);
        }
        return $user;
    }
}