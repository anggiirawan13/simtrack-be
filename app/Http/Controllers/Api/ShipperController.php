<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShipperResource;
use App\Models\Shipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippers = Shipper::with('user')->get();

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
        $shipper = Shipper::find($id);

        //delete shipper
        $shipper->delete();

        //return response
        return new ShipperResource(true, 'Data Shipper Berhasil Dihapus!', null);
    }
}
