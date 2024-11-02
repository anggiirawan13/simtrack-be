<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryResource;
use App\Models\Delivery;
use App\Models\DeliveryRecipient;
use App\Models\DeliveryHistoryLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveries = Delivery::latest()->paginate(5);

        return new DeliveryResource(true, 'List Data Deliveries', $deliveries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'delivery_number' => 'required|string',
            'company_name' => 'required|string',
            'shipper_id' => 'required|integer',
            'status_id' => 'required|integer',
            'delivery_date' => 'required|date',
            'receive_date' => 'nullable|date',
            'confirmation_code' => 'required|string',
            'details' => 'required|array', // array of delivery details
            'history_locations' => 'required|array', // array of history locations
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create delivery
        $delivery = Delivery::create([
            'delivery_number' => $request->delivery_number,
            'company_name' => $request->company_name,
            'shipper_id' => $request->shipper_id,
            'status_id' => $request->status_id,
            'delivery_date' => $request->delivery_date,
            'receive_date' => $request->receive_date,
            'confirmation_code' => $request->confirmation_code,
            'created_by' => $request->created_by, // Assuming user is authenticated
            'updated_by' => $request->updated_by,
        ]);

        // Create delivery details
        foreach ($request->details as $detail) {
            DeliveryRecipient::create([
                'delivery_number' => $delivery->delivery_number,
                'name' => $detail['name'], // Assuming detail has 'name' field
                'address_id' => $detail['address_id'], // Assuming detail has 'address_id' field
            ]);
        }

        // Create delivery history locations
        foreach ($request->history_locations as $location) {
            DeliveryHistoryLocation::create([
                'delivery_number' => $delivery->delivery_number,
                'latitude' => $location['latitude'],
                'longitude' => $location['longitude'],
            ]);
        }

        // Return response
        return new DeliveryResource(true, 'Data Delivery Berhasil Ditambahkan!', $delivery);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $delivery = Delivery::find($id);

        return new DeliveryResource(true, 'Detail Data Delivery!', $delivery);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'delivery_number' => 'required|string',
            'company_name' => 'required|string',
            'shipper_id' => 'required|integer',
            'status_id' => 'required|integer',
            'delivery_date' => 'required|date',
            'receive_date' => 'nullable|date',
            'confirmation_code' => 'required|string',
            'details' => 'required|array', // array of delivery details
            'history_locations' => 'required|array', // array of history locations
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create delivery
        $delivery = Delivery::create([
            'delivery_number' => $request->delivery_number,
            'company_name' => $request->company_name,
            'shipper_id' => $request->shipper_id,
            'status_id' => $request->status_id,
            'delivery_date' => $request->delivery_date,
            'receive_date' => $request->receive_date,
            'confirmation_code' => $request->confirmation_code,
            'created_by' => $request->created_by, // Assuming user is authenticated
            'updated_by' => $request->updated_by,
        ]);

        // Create delivery details
        foreach ($request->details as $detail) {
            DeliveryRecipient::create([
                'delivery_number' => $delivery->delivery_number,
                'name' => $detail['name'], // Assuming detail has 'name' field
                'address_id' => $detail['address_id'], // Assuming detail has 'address_id' field
            ]);
        }

        // Create delivery history locations
        foreach ($request->history_locations as $location) {
            DeliveryHistoryLocation::create([
                'delivery_number' => $delivery->delivery_number,
                'latitude' => $location['latitude'],
                'longitude' => $location['longitude'],
            ]);
        }

        // Return response
        return new DeliveryResource(true, 'Data Delivery Berhasil Ditambahkan!', $delivery);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delivery = Delivery::find($id);

        // Delete delivery
        $delivery->delete();

        // Return response
        return new DeliveryResource(true, 'Data Delivery Berhasil Dihapus!', null);
    }
}
