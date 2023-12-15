<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function registration(Request $request)
    {
        try {
            $email = $request->input("email");

            $user = User::where('email', $email)->first();

            if ($user) {
                return response()->json(["errorMsg" => 'The email address already exists.'], 401);
            }

            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->password = $request->input('password');
            $user->avatar = '/uploads/avatar-min.jpg';

            $user->save();

            $token = $user->createToken('user-token');

            return response()->json(['user' => $user, 'token' => $token->plainTextToken], 201);


        } catch (\Throwable $th) {
            return response()->json(['errorMsg' => $th->getMessage(), "status" => 500], 500);
        }

    }

    public function login(Request $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('user-token');
            return response()->json(['successMsg' => 'You have successfully logged in!', 'token' => $token->plainTextToken], 200);
        }

        return response()->json(["errorMsg" => "Invalid credentials"], 401);
    }

    function profile()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }

    public function updateProfile(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['errorMsg' => 'You must be logged in!', "status" => 401], 401);
            }

            $user = Auth::user();
            $user = User::find($user->id);

            $user->first_name = $request->input('first_name');
            $user->middle_name = $request->input('middle_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');

            $user->save();

            return response()->json(['successMsg' => "Profile successfully updated!", "status" => 200], 200);

        } catch (\Throwable $th) {
            return response()->json(['errorMsg' => $th->getMessage(), "status" => 500], 500);
        }
    }
}
