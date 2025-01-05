<?php

// app/Http/Controllers/SearchController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor; // Replace 'Doctor' with your actual model name
use App\Models\User;

class SearchController extends Controller
{
    public function index()
    {
        // You can load any necessary data for the search form here
        return view('searchResults');
    }

    public function search(Request $request)
    {
        // Retrieve search criteria from the form
        $specialty = $request->input('specialty');
        //$category = $request->input('category');
        $doctor = $request->input('doctor');

        //dd($doctor);

        // Query the database based on the search criteria
        $doctors = Doctor::with('user')
            ->where(function ($query) use ($specialty) {
                $query->whereRaw('LOWER(specialty) LIKE ?', ['%' . strtolower($specialty) . '%'])
                    ->orWhereRaw('LOWER(specialty) LIKE ?', ['%' . str_replace(' ', '%', strtolower($specialty)) . '%']);
            })
            ->orWhere('user_id', $doctor)
            ->get();

        // Pass the search results to the view for display
        return view('searchResults', ['doctors' => $doctors]);
    }
}
