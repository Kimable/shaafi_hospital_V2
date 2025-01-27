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
        } else {
            return response()->json(["errorMsg" => "Invalid credentials"], 401);
        }
    }

    function profile()
    {
        try {

            $user = Auth::guard('sanctum')->user();
            if ($user) {
                return response()->json(['successMsg' => 'Logged in successfully', 'user' => $user]);
            } else {
                return response()->json(['message' => 'Invalid token'], 401);
            }
        } catch (\Exception $e) {
            // Handle any exceptions, e.g., if the token is malformed
            return response()->json(['message' => 'Error validating token'], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $auth_user = Auth::user();
            if (!$auth_user) {
                return response()->json(['errorMsg' => 'You must be logged in!', "status" => 401], 401);
            }

            $user = User::find($auth_user->id);
            $updateData = $request->only([
                'first_name',
                'middle_name',
                'last_name',
                'email',
                'phone'
            ]);

            $user->fill(array_filter($updateData));
            $user->save();

            return response()->json(['successMsg' => "Profile successfully updated!", "status" => 201], 201);
        } catch (\Throwable $th) {
            return response()->json(['errorMsg' => $th->getMessage(), "status" => 500], 500);
        }
    }

    // Update user image
    public function updateUserImage(Request $request)
    {

        $auth_user = Auth::user();
        if (!$auth_user) {
            return response()->json(['errorMsg' => 'You must be logged in!', "status" => 401], 401);
        }
        try {
            // Upload image and update url
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => "required|image|mimes:jpg,png,jpeg|max:2048"
                ]);

                $imagePath = $request->file('image')->store('uploads', 'public'); // Store image in the "public/images" directory
                $user = User::find($auth_user->id);

                $user->avatar = '/' . $imagePath;
                $user->save();
                return response()->json(['successMsg' => "Profile image successfully updated!", "status" => 201], 201);
            } else {
                return response()->json(['errorMsg' => "No image selected.", "status" => 400], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['errorMsg' => $th->getMessage(), "status" => 500], 500);
        }
    }
}
