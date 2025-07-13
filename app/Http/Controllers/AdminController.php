<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Notifications\BookingStatusNotification;
use Illuminate\Support\Facades\Notification;
use App\Exports\BookingsExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with bookings categorized by status.
     * Supports optional search filtering.
     */
    public function index()
    {
        $search = request('search'); // Get search input (if any)

        return view('admin.bookings.index', [
            // Fetch pending bookings (with optional search)
            'pendingBookings' => Booking::where('status', 'pending')
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
                })
                ->orderByDesc('created_at')
                ->paginate(5, ['*'], 'pending_page'),

            // Fetch approved bookings
            'approvedBookings' => Booking::where('status', 'approved')
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
                })
                ->orderByDesc('created_at')
                ->paginate(5, ['*'], 'approved_page'),

            // Fetch rejected bookings
            'rejectedBookings' => Booking::where('status', 'rejected')
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
                })
                ->orderByDesc('created_at')
                ->paginate(5, ['*'], 'rejected_page'),

            // Fetch cancelled bookings
            'cancelledBookings' => Booking::where('status', 'cancelled')
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
                })
                ->orderByDesc('created_at')
                ->paginate(5, ['*'], 'cancelled_page'),

            // Booking summary counts
            'totalBookings' => Booking::count(),
            'approvedCount' => Booking::where('status', 'approved')->count(),
            'rejectedCount' => Booking::where('status', 'rejected')->count(),
            'cancelledCount' => Booking::where('status', 'cancelled')->count(),
        ]);
    }

    /**
     * Approve a booking by ID and send an email notification.
     */
    public function approve($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'approved';
        $booking->save();

        // Send approval notification email
        Notification::route('mail', $booking->email)
            ->notify(new BookingStatusNotification('approved', $booking));

        return back()->with('success', 'Booking approved.');
    }

    /**
     * Reject a booking by ID, save reason and optional refund proof, send email.
     */
    public function reject(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'rejected';

        // Save rejection reason
        $booking->rejection_reason = $request->input('rejection_reason');

        // Save refund proof image if provided
        if ($request->hasFile('refund_proof')) {
            $proofPath = $request->file('refund_proof')->store('refund_proofs', 'public');
            $booking->refund_proof = $proofPath;
        }

        $booking->save();

        // Send rejection notification email
        Notification::route('mail', $booking->email)
            ->notify(new BookingStatusNotification('rejected', $booking));

        return redirect()->back()->with('success', 'Booking rejected successfully.');
    }

    /**
     * Cancel a booking (for admin use), save reason and refund proof.
     */
    public function cancel(Request $request, Booking $booking)
    {
        // Validate reason and optional image
        $request->validate([
            'rejection_reason' => 'required|string',
            'refund_proof' => 'nullable|image|max:2048',
        ]);

        // Set status and reason
        $booking->status = 'cancelled';
        $booking->rejection_reason = $request->rejection_reason;

        // Save refund proof image if provided
        if ($request->hasFile('refund_proof')) {
            $booking->refund_proof = $request->file('refund_proof')->store('refunds', 'public');
        }

        $booking->save();

        return redirect()->back()->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Export bookings to Excel. Optional status filtering.
     */
    public function export($status = null)
    {
        $fileName = $status ? "bookings_{$status}.xlsx" : "all_bookings.xlsx";
        return Excel::download(new BookingsExport($status), $fileName);
    }
}
