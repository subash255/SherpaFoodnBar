<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
   

    public function store(Request $request)
    {
        // Validate the incoming form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'number_of_people' => 'required|integer',
            'booking_date' => 'required|date',
        ]);

        // Create a new booking record in the database
        Booking::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'number_of_people' => $request->number_of_people,
            'booking_date' => $request->booking_date,
        ]);

        // Redirect or return a success message
        return redirect()->route('welcome')->with('success', 'Your booking was successful!');
    }
}