<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShipperResource;
use App\Models\Delivery;
use App\Models\Shipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');             // Search query parameter
        $page = $request->query('page', 1);    // Page number, default to 1
        $limit = $request->query('limit', 10); // Items per page, default to 10

        // Start a query builder for Shippers with 'user' relationship
        $query = Shipper::with('user');

        // Apply search filter if 'q' parameter is provided
        if ($q) {
            $query->whereHas('user', function($subQuery) use ($q) {
                $subQuery->where('fullname', 'like', '%' . $q . '%')
                        ->orWhere('role', 'like', '%' . $q . '%')
                        ->orWhere('username', 'like', '%' . $q . '%');
            })
            ->orWhere('device_mapping', 'like', '%' . $q . '%');
        }

        // Paginate the results based on 'page' and 'limit' parameters
        $shippers = $query->paginate($limit, ['*'], 'page', $page);

        // Return paginated response as a resource
        return new ShipperResource(true, 'List Data Shippers', $shippers);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'     => 'required',
            'device_mapping'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create shipper
        $shipper = Shipper::create([
            'user_id'     => $request->user_id,
            'device_mapping'   => $request->device_mapping,
        ]);

        //return response
        return new ShipperResource(true, 'Data Shipper Berhasil Ditambahkan!', $shipper);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $shipper = Shipper::find($id);

        return new ShipperResource(true, 'Detail Data Shipper!', $shipper);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'user_id'     => 'required',
            'device_mapping'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find shipper by ID
        $shipper = Shipper::find($id);

        //update shipper without image
        $shipper->update([
            'user_id'     => $request->user_id,
            'device_mapping'   => $request->device_mapping,
        ]);

        //return response
        return new ShipperResource(true, 'Data Shipper Berhasil Diubah!', $shipper);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delivery = Delivery::where('shipper_id', $id)->first();
        if ($delivery) {
            return new ShipperResource(false, 'Shipper tidak bisa dihapus, karena sudah pernah ditugaskan untuk pengiriman.', null);
        }

        $shipper = Shipper::find($id);
        if (!$shipper) {
            return new ShipperResource(false, 'Data shipper tidak ditemukan!', null);
        }

        $shipper->delete();

        //return response
        return new ShipperResource(true, 'Data Shipper Berhasil Dihapus!', null);
    }
}
