<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingNotification;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Show the booking form page.
     * Also sends already approved dates to disable them in the calendar.
     */
    public function create()
    {
        // Get all approved booking dates and format to Y-m-d for frontend
        $approvedDates = Booking::where('status', 'approved')
            ->pluck('booking_date')
            ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'))
            ->toArray();

        return view('booking.create', [
            'approvedDates' => $approvedDates,
        ]);
    }

    /**
     * Store the booking request submitted by the user.
     */
    public function store(Request $request)
    {
        $isCustom = $request->time_slot === 'custom'; // Check if custom time slot is selected

        // Step 1: Validate request input
        $rules = [
            'name' => 'required',
            'ic' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'purpose' => 'required',
            'booking_date' => 'required|date',
            'time_slot' => 'required',
            'account_number' => 'required|numeric',
            'proof_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'agree' => 'accepted',
        ];

        // If custom time slot selected, require start and end time
        if ($isCustom) {
            $rules['start_time'] = 'required';
            $rules['end_time'] = 'required';
        }

        $validated = $request->validate($rules);

        // Step 2: Get time values
        $start_time = $request->start_time;
        $end_time = $request->end_time;

        // If using predefined time slot, split it into start and end
        if (!$isCustom) {
            [$start_time, $end_time] = explode(' - ', $request->time_slot);
            $start_time = date('H:i', strtotime($start_time));
            $end_time = date('H:i', strtotime($end_time));
        }

        // Step 3: Check for overlapping approved bookings
        $existing = Booking::where('booking_date', $request->booking_date)
            ->where('status', 'approved')
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time, $end_time])
                    ->orWhereBetween('end_time', [$start_time, $end_time])
                    ->orWhere(function ($q) use ($start_time, $end_time) {
                        $q->where('start_time', '<=', $start_time)
                            ->where('end_time', '>=', $end_time);
                    });
            })->exists();

        if ($existing) {
            return back()->with('error', 'Slot already taken. Please choose a different time.');
        }

        // Step 4: Determine price based on purpose
        $price = match ($request->purpose) {
            'Tahlil' => 50,
            'Kenduri' => 100,
            'Majlis Kahwin' => 150,
            'Jualan Tapak' => 80,
            default => 0,
        };

        // Step 5: Upload payment proof file
        $proofPath = null;
        if ($request->hasFile('proof_file')) {
            $proofPath = $request->file('proof_file')->store('proofs', 'public');
        }

        // Step 6: Save booking to database
        $booking = Booking::create([
            'name' => $request->name,
            'ic' => $request->ic,
            'email' => $request->email,
            'phone' => $request->phone,
            'purpose' => $request->purpose,
            'booking_date' => $request->booking_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'account_number' => $request->account_number,
            'proof_file' => $proofPath,
            'price' => $price,
        ]);

        // Step 7: Send email notification to admin
        Mail::to('iniasuhida@gmail.com')->send(new BookingNotification($booking)); // Replace with your admin email

        // Step 8: Redirect back with success message
        return redirect()->back()->with('success', 'Booking submitted successfully! Admin will review it shortly.');
    }
}
