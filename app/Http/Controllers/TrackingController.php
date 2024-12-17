<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\DeliveryHistoryLocation;
use Illuminate\Http\Request;
use App\Services\FirebaseService;
use App\Models\DeliveryTracking; // Model untuk menyimpan data lokasi

class TrackingController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Endpoint untuk memulai tracking lokasi.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function startTracking(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'delivery_number' => 'required|string',
        ]);

        $deliveryNumber = $validated['delivery_number'];

        // Ambil data pengiriman berdasarkan nomor resi
        $deliveries = Delivery::with(['recipient.address', 'history', 'shipper'])
            ->where('delivery_number', $deliveryNumber)
            ->first();

        if (!$deliveries) {
            return response()->json([
                'status' => 'error',
                'message' => 'Delivery not found for the given tracking number.',
            ], 404);
        }

        // Ambil Firebase Device Token dari shipper
        $deviceToken = $deliveries->shipper->device_mapping;

        if (!$deviceToken) {
            return response()->json([
                'status' => 'error',
                'message' => 'Firebase device token not found for the shipper.',
            ], 404);
        }

        // Persiapkan pesan untuk dikirim ke Firebase
        $title = 'Request Location';
        $body = 'Tolong kirimkan lokasi terkini untuk resi: ' . $deliveryNumber;

        // Kirim notifikasi ke Firebase menggunakan FirebaseService
        $response = $this->firebaseService->sendNotification(
            [$deviceToken], // Firebase Device Token
            $title,
            $body,
            ['tracking_number' => $deliveryNumber] // Data tambahan untuk payload
        );

        // Return response ke pengguna
        return response()->json([
            'status' => 'success',
            'message' => 'Tracking request sent to Firebase',
            'firebase_response' => $response,
        ]);
    }


    /**
     * Endpoint untuk menerima lokasi dari mobile.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveLocation(Request $request)
    {
        $validated = $request->validate([
            'tracking_number' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $location = DeliveryHistoryLocation::create([
            'tracking_number' => $validated['delivery_number'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Location saved successfully',
            'location' => $location,
        ]);
    }
}
