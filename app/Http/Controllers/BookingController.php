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
    return Booking::all();
}

    #[OA\Post(
        path: '/api/bookings',
        summary: 'Create a booking',
        tags: ['Bookings']
    )]
    #[OA\Parameter(name: 'pet_id', in: 'query', required: true, description: 'Pet ID')]
    #[OA\Parameter(name: 'owner_name', in: 'query', required: true, description: 'Owner name')]
    #[OA\Parameter(name: 'service_type', in: 'query', required: true, description: 'Service type')]
    #[OA\Parameter(name: 'check_in_date', in: 'query', required: true, description: 'Check in date')]
    #[OA\Parameter(name: 'check_out_date', in: 'query', required: true, description: 'Check out date')]
    #[OA\Parameter(name: 'status', in: 'query', required: false, description: 'Booking status')]
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
    #[OA\Parameter(name: 'id', in: 'path', required: true, description: 'Booking ID')]
    #[OA\Response(response: 200, description: 'Booking details')]
    public function show($id)
{
    return Booking::findOrFail($id);
}

    #[OA\Put(
        path: '/api/bookings/{id}',
        summary: 'Update booking',
        tags: ['Bookings']
    )]
    #[OA\Parameter(name: 'id', in: 'path', required: true, description: 'Booking ID')]
    #[OA\Parameter(name: 'pet_id', in: 'query', required: false, description: 'Pet ID')]
    #[OA\Parameter(name: 'owner_name', in: 'query', required: false, description: 'Owner name')]
    #[OA\Parameter(name: 'service_type', in: 'query', required: false, description: 'Service type')]
    #[OA\Parameter(name: 'check_in_date', in: 'query', required: false, description: 'Check in date')]
    #[OA\Parameter(name: 'check_out_date', in: 'query', required: false, description: 'Check out date')]
    #[OA\Parameter(name: 'status', in: 'query', required: false, description: 'Booking status')]
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
    #[OA\Parameter(name: 'id', in: 'path', required: true, description: 'Booking ID')]
    #[OA\Response(response: 200, description: 'Booking deleted')]
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json([
            'message' => 'Booking deleted successfully'
        ]);
    }
}