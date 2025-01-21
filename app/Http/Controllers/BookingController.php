<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::paginate(5);
        return view('admin.booking.index',  [
            'title' => 'Table Reservations'
        ], compact('bookings'));
    }


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

        // Check if a booking with the same email or phone number already exists
        $existingBooking = Booking::where('email', $request->email)
            ->orWhere('phone', $request->phone)
            ->first();

        // If a booking already exists, prevent further processing and return an error message
        if ($existingBooking) {
            // Return the error message with no further action (prevents creating a duplicate)
            return redirect()->back()->with('error', 'You have already reserved a table with this email or phone number.')->withInput()->header('Location', url()->previous() . '#reservation');
        }

        // Create a new booking record in the database
        Booking::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'number_of_people' => $request->number_of_people,
            'booking_date' => $request->booking_date,
        ]);

        // Redirect or return a success message
        return redirect()->route('welcome')->with('success', 'Your booking was successful!')->header('Location', route('welcome') . '#reservation');
    }

    //delete
    public function destroy($id)
    {
        $booking = Booking::find($id);
        $booking->delete();
        return redirect()->route('admin.booking.index')->with('success', 'Booking deleted successfully');
    }
}
