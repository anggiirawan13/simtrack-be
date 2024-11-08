<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryResource;
use App\Models\Address;
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
    public function index(Request $request)
    {
        $q = $request->query('q');             // Search query parameter
        $paginate = $request->query('paginate');
        $page = $request->query('page', 1);    // Page number, default to 1
        $limit = $request->query('limit', 10); // Items per page, default to 10

        // Start a query builder for Delivery with 'shipper' and 'user' relationships
        $query = Delivery::with(['shipper.user']);

        // Apply search filter if 'q' parameter is provided
        if ($q) {
            $query->where('delivery_number', 'like', '%' . $q . '%')
                ->orWhere('company_name', 'like', '%' . $q . '%')
                ->orWhereHas('shipper.user', function($subQuery) use ($q) {
                    $subQuery->where('fullname', 'like', '%' . $q . '%');
                });
        }

        if ($paginate == 'false' || $paginate == 0) {
            $deiveries = $query->get();
        } else {
            // Paginate the results based on 'page' and 'limit' parameters
            $deliveries = $query->paginate($limit, ['*'], 'page', $page);
        }

        // Return paginated response as a resource
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
            'status' => 'required|string',
            'delivery_date' => 'required', // Adjusting to match yyyy-MM-dd format
            'receive_date' => 'nullable', // Adjusting to match yyyy-MM-dd format
            'confirmation_code' => 'nullable',
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
            'status' => $request->status,
            'delivery_date' => \Carbon\Carbon::createFromFormat('M j, Y H:i:s', $request->delivery_date)->format('Y-m-d'), // Convert to yyyy-MM-dd
            'receive_date' => $request->receive_date 
                ? \Carbon\Carbon::createFromFormat('M j, Y H:i:s', $request->receive_date)->format('Y-m-d') 
                : null, // Convert to yyyy-MM-dd if not null // Parsing if not null
            'confirmation_code' => $request->confirmation_code == null ? "code1234" : $request->confirmation_code,
            'created_by' => 'admin', // Assuming user is authenticated
            'updated_by' => 'admin',
        ]);

        // Create recipient address
        $address = Address::create([
            'street' => $request->recipient['street'],
            'sub_district' => $request->recipient['sub_district'],
            'district' => $request->recipient['district'],
            'city' => $request->recipient['city'],
            'province' => $request->recipient['province'],
            'postal_code' => $request->recipient['postal_code'],
        ]);

        // Create delivery recipient
        DeliveryRecipient::create([
            'delivery_number' => $delivery->delivery_number,
            'name' => $request->recipient['name'], // Assuming detail has 'name' field
            'address_id' => $address->id, // Assuming detail has 'address_id' field
        ]);

        // Create delivery history locations
        if ($request->history != null) {
            foreach ($request->history as $location) {
                DeliveryHistoryLocation::create([
                    'delivery_number' => $delivery->delivery_number,
                    'latitude' => $location['latitude'],
                    'longitude' => $location['longitude'],
                ]);
            }
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
            'status' => 'required|string',
            'delivery_date' => 'required|date',
            'receive_date' => 'nullable|date',
            'confirmation_code' => 'required|string',
            'recipient' => 'required|array', // array of delivery recipient
            'history' => 'required|array', // array of history locations
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
            'status' => $request->status,
            'delivery_date' => $request->delivery_date,
            'receive_date' => $request->receive_date,
            'confirmation_code' => $request->confirmation_code,
            'created_by' => 'admin', // Assuming user is authenticated
            'updated_by' => 'admin',
        ]);

        // Create delivery recipient
        foreach ($request->recipient as $detail) {
            DeliveryRecipient::create([
                'delivery_number' => $delivery->delivery_number,
                'name' => $detail['name'], // Assuming detail has 'name' field
                'address_id' => $detail['address_id'], // Assuming detail has 'address_id' field
            ]);
        }

        // Create delivery history locations
        foreach ($request->history as $location) {
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

    public function filterByStatus(Request $request)
    {
        $q = $request->query('q');  // Get 'status' query parameter
        $page = $request->query('page', 1);   // Page number, default to 1
        $limit = $request->query('limit', 10); // Items per page, default to 10

        // Start a query builder for Delivery with 'shipper' and 'user' relationships
        $query = Delivery::with(['shipper.user']);

        // Apply status filter if 'status' parameter is provided
        if ($q) {
            $query->where('status', $q);
        }

        // Paginate the results
        $deliveries = $query->paginate($limit, ['*'], 'page', $page);

        // Return paginated response as a resource
        return new DeliveryResource(true, 'Filtered Deliveries by Status', $deliveries);
    }

}
