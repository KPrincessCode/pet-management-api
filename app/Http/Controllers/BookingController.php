<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class BookingController extends Controller
{
    #[OA\Get(
        path: '/api/bookings',
        summary: 'Get all bookings',
        tags: ['Bookings']
    )]
    #[OA\Response(response: 200, description: 'List of bookings')]
    public function index()
    {
        // 🔥 LOAD PET RELATION
        $bookings = Booking::with('pet')->get();

        // 🔥 ADD pet_name dynamically
        $bookings->transform(function ($booking) {
            $booking->pet_name = $booking->pet ? $booking->pet->name : 'Unknown Pet';
            return $booking;
        });

        return response()->json($bookings);
    }

    #[OA\Post(
        path: '/api/bookings',
        summary: 'Create a booking',
        tags: ['Bookings']
    )]
    #[OA\Response(response: 201, description: 'Booking created')]
    public function store(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'owner_name' => 'required|string|max:255',
            'service_type' => 'required|string|max:255',
            'pet_type' => 'required|string|max:255',
            'medicine_needed' => 'nullable|string|max:255',
            'injection_status' => 'nullable|string|max:255',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
            'payment_amount' => 'nullable|numeric',
            'payment_status' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $booking = Booking::create([
            'pet_id' => $request->pet_id,
            'owner_name' => $request->owner_name,
            'service_type' => $request->service_type,
            'pet_type' => $request->pet_type,
            'medicine_needed' => $request->medicine_needed,
            'injection_status' => $request->injection_status,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'payment_amount' => $request->payment_amount,
            'payment_status' => $request->payment_status ?? 'unpaid',
            'status' => $request->status ?? 'Pending',
        ]);

        return response()->json($booking, 201);
    }

    #[OA\Get(
        path: '/api/bookings/{id}',
        summary: 'Get single booking',
        tags: ['Bookings']
    )]
    #[OA\Response(response: 200, description: 'Booking details')]
    public function show($id)
    {
        $booking = Booking::with('pet')->findOrFail($id);
        $booking->pet_name = $booking->pet ? $booking->pet->name : 'Unknown Pet';

        return response()->json($booking);
    }

    #[OA\Put(
        path: '/api/bookings/{id}',
        summary: 'Update booking',
        tags: ['Bookings']
    )]
    #[OA\Response(response: 200, description: 'Booking updated')]
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'pet_id' => $request->pet_id ?? $booking->pet_id,
            'owner_name' => $request->owner_name ?? $booking->owner_name,
            'service_type' => $request->service_type ?? $booking->service_type,
            'pet_type' => $request->pet_type ?? $booking->pet_type,
            'medicine_needed' => $request->medicine_needed ?? $booking->medicine_needed,
            'injection_status' => $request->injection_status ?? $booking->injection_status,
            'check_in_date' => $request->check_in_date ?? $booking->check_in_date,
            'check_out_date' => $request->check_out_date ?? $booking->check_out_date,
            'payment_amount' => $request->payment_amount ?? $booking->payment_amount,
            'payment_status' => $request->payment_status ?? $booking->payment_status,
            'status' => $request->status ?? $booking->status,
        ]);

        return response()->json($booking);
    }

    #[OA\Delete(
        path: '/api/bookings/{id}',
        summary: 'Delete booking',
        tags: ['Bookings']
    )]
    #[OA\Response(response: 200, description: 'Booking deleted')]
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json([
            'message' => 'Booking deleted successfully'
        ]);
    }

    // ✅ APPROVE
    public function approve(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        if ($booking->payment_status !== 'paid') {
            return response()->json([
                'message' => 'Booking cannot be approved until payment is paid.'
            ], 400);
        }

        $booking->status = 'Approved';
        $booking->admin_notes = $request->admin_notes ?? 'Booking approved. Please prepare your pet for check-in.';
        $booking->save();

        return response()->json([
            'message' => 'Booking approved',
            'data' => $booking
        ]);
    }

    // ❌ REJECT
    public function reject(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->status = 'Rejected';
        $booking->admin_notes = $request->admin_notes ?? 'Booking rejected. Please contact the clinic for more information.';
        $booking->save();

        return response()->json([
            'message' => 'Booking rejected',
            'data' => $booking
        ]);
    }
    public function checkIn($id)
{
    $booking = Booking::find($id);

    if (!$booking) {
        return response()->json(['message' => 'Booking not found'], 404);
    }

    if ($booking->status !== 'Approved') {
        return response()->json([
            'message' => 'Only approved bookings can be checked in.'
        ], 400);
    }

    $booking->status = 'Checked In';
    $booking->boarding_status = 'Checked In';
    $booking->save();

    return response()->json([
        'message' => 'Pet checked in successfully',
        'data' => $booking
    ]);
}

public function checkOut($id)
{
    $booking = Booking::find($id);

    if (!$booking) {
        return response()->json(['message' => 'Booking not found'], 404);
    }

    if ($booking->status !== 'Checked In') {
        return response()->json([
            'message' => 'Only checked-in pets can be checked out.'
        ], 400);
    }

    $booking->status = 'Checked Out';
    $booking->boarding_status = 'Checked Out';
    $booking->save();

    return response()->json([
        'message' => 'Pet checked out successfully',
        'data' => $booking
    ]);
}
}