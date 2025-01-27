<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HealthRecords as ModelsHealthRecords;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HealthRecords extends Controller
{
    //get all health records
    function getAllHealthRecords()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'You must be looged in to see your health records'], 404);
        }
        // get all heealth records for a specific user
        $healthRecords = ModelsHealthRecords::where('user_id', $user->id)->get();

        if (!$healthRecords) {
            return response()->json(['records' => [], 'message' => 'You have No health records. When your doctor uploads your health records, you will be able to see them here.'], 404);
        }
        return response()->json(['records' => $healthRecords]);
    }
}
