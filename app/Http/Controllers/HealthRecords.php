<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\HealthRecords as ModelsHealthRecords;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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

    // Generate Heallth Record PDF
    function generateHealthRecordPDF($healthRecordId)
    {
        $healthRecord = ModelsHealthRecords::find($healthRecordId);
        if (!$healthRecord) {
            return view('pdf/no-record');
        }

        $user = User::find($healthRecord->user_id);
        $docId = (int) $healthRecord->doctor_id;
        $doctorPersonalInfo = User::find($docId);
        $doctor = Doctor::where('user_id', $doctorPersonalInfo->id)->first();

        $data = [
            'user' => $user,
            'doctor' => $doctorPersonalInfo,
            'doc_specialty' => $doctor->specialty,
            'healthRecord' => $healthRecord,
        ];

        $pdf = Pdf::loadView('pdf/health-record', $data);

        return $pdf->download("$healthRecord->title.pdf");
    }
}
