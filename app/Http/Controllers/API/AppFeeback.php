<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\API\AppFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppFeeback extends Controller
{
    function addFeedack(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'You must be looged in to post a feedback'], 404);
        }

        $feedback = new AppFeedback();
        $feedback->type = $request->type;
        $feedback->rating = $request->rating;
        $feedback->department = $request->department;
        $feedback->comment = $request->comment;
        $feedback->user_id = $user->id;
        $feedback->save();

        return response()->json(['message' => 'Your feedback has been submitted successfully. We appreciate your input to help us improve our services.'], 201);
    }
}
