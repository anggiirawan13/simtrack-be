<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShipperResource;
use App\Models\Delivery;
use App\Models\Shipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ShipperController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');            
        $page = $request->query('page', 1);   
        $limit = $request->query('limit', 10);

       
        $query = Shipper::with('user');

       
        if ($q) {
            $query->whereHas('user', function($subQuery) use ($q) {
                $subQuery->where('fullname', 'like', '%' . $q . '%')
                        ->orWhere('role', 'like', '%' . $q . '%')
                        ->orWhere('username', 'like', '%' . $q . '%');
            })
            ->orWhere('device_mapping', 'like', '%' . $q . '%');
        }

       
        $shippers = $query->paginate($limit, ['*'], 'page', $page);

       
        return new ShipperResource(true, 'List Data Shippers', $shippers);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'     => 'required',
            'device_mapping'   => 'required',
        ]);

       
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

       
        $shipper = Shipper::create([
            'user_id'     => $request->user_id,
            'device_mapping'   => $request->device_mapping,
        ]);

       
        return new ShipperResource(true, 'Data Shipper Berhasil Ditambahkan!', $shipper);
    }

    public function show($id)
    {
        $shipper = Shipper::find($id);

        return new ShipperResource(true, 'Detail Data Shipper!', $shipper);
    }

    public function update(Request $request, $id)
    {
       
        $validator = Validator::make($request->all(), [
            'user_id'     => 'required',
            'device_mapping'   => 'required',
        ]);

       
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

       
        $shipper = Shipper::find($id);

       
        $shipper->update([
            'user_id'     => $request->user_id,
            'device_mapping'   => $request->device_mapping,
        ]);

       
        return new ShipperResource(true, 'Data Shipper Berhasil Diubah!', $shipper);
    }

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

       
        return new ShipperResource(true, 'Data Shipper Berhasil Dihapus!', null);
    }

    public function updateDeviceMapping($id, Request $request)
    {
        $shipper = Shipper::find($id);

        Log::info($id);
        Log::info($request->all());

       
        $shipper->update([
            'device_mapping'   => $request->device_mapping,
        ]);

       
        return new ShipperResource(true, 'Device mapping berhasi diubah!', $shipper);
    }
}
