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
    public function index(Request $request)
    {
        $q = $request->query('q');            
        $page = $request->query('page', 1);   
        $limit = $request->query('limit', 10);
       
        $query = Delivery::query();
       
        if ($q) {
            $query->where('delivery_number', 'like', '%' . $q . '%')
                ->orWhere('company_name', 'like', '%' . $q . '%')
                ->orWhereHas('shipper.user', function($subQuery) use ($q) {
                    $subQuery->where('fullname', 'like', '%' . $q . '%');
                });
        }

        $deliveries = $query->paginate($limit, ['*'], 'page', $page);

        return new DeliveryResource(true, 'List Data Deliveries', $deliveries);
    }


    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'delivery_number' => 'required|string',
            'company_name' => 'required|string',
            'shipper_id' => 'required|integer',
            'status' => 'required|string',
            'delivery_date' => 'required',
            'receive_date' => 'nullable',
            'confirmation_code' => 'nullable',
        ]);

       
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

       
        $delivery = Delivery::create([
            'delivery_number' => $request->delivery_number,
            'company_name' => $request->company_name,
            'shipper_id' => $request->shipper_id,
            'status' => $request->status,
            'delivery_date' => \Carbon\Carbon::createFromFormat('M j, Y H:i:s', $request->delivery_date)->format('Y-m-d'),
            'receive_date' => $request->receive_date 
                ? \Carbon\Carbon::createFromFormat('M j, Y H:i:s', $request->receive_date)->format('Y-m-d') 
                : null,
            'confirmation_code' => $request->confirmation_code == null ? "code1234" : $request->confirmation_code,
            'created_by' => 'admin',
            'updated_by' => 'admin',
        ]);

       
        $address = Address::create([
            'whatsapp' => $request->recipient['address']['whatsapp'],
            'street' => $request->recipient['address']['street'],
            'sub_district' => $request->recipient['address']['sub_district'],
            'district' => $request->recipient['address']['district'],
            'city' => $request->recipient['address']['city'],
            'province' => $request->recipient['address']['province'],
            'postal_code' => $request->recipient['address']['postal_code'],
        ]);

       
        DeliveryRecipient::create([
            'delivery_number' => $delivery->delivery_number,
            'name' => $request->recipient['name'],
            'address_id' => $address->id,
        ]);

       
        if ($request->history != null) {
            foreach ($request->history as $location) {
                DeliveryHistoryLocation::create([
                    'delivery_number' => $delivery->delivery_number,
                    'latitude' => $location['latitude'],
                    'longitude' => $location['longitude'],
                ]);
            }
        }

       
        return new DeliveryResource(true, 'Data Delivery Berhasil Ditambahkan!', $delivery);
    }


    public function show($id)
    {
        $delivery = Delivery::with('recipient')->with('recipient.address')->find($id);

        return new DeliveryResource(true, 'Detail Data Delivery!', $delivery);
    }

    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'id' => 'required|integer',
        'delivery_number' => 'required|string',
        'company_name' => 'required|string',
        'shipper_id' => 'required|integer',
        'status' => 'required|string',
        'delivery_date' => 'required|date',
        'receive_date' => 'nullable|date',
        'confirmation_code' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $delivery = Delivery::findOrFail($id);

    $delivery->update([
        'delivery_number' => $request->delivery_number,
        'company_name' => $request->company_name,
        'shipper_id' => $request->shipper_id,
        'status' => $request->status,
        'delivery_date' => \Carbon\Carbon::createFromFormat('M j, Y H:i:s', $request->delivery_date)->format('Y-m-d'),
            'receive_date' => $request->receive_date 
                ? \Carbon\Carbon::createFromFormat('M j, Y H:i:s', $request->receive_date)->format('Y-m-d') 
                : null,
        'confirmation_code' => $request->confirmation_code,
        'created_by' => 'admin',
        'updated_by' => 'admin',
    ]);

    // Pastikan address_id dan recipient_id ditambahkan dalam request atau sesuaikan pengambilan id-nya
    $address = Address::findOrFail($request->recipient['address']['id']);

    $address->update([
        'whatsapp' => $request->recipient['address']['whatsapp'],
        'street' => $request->recipient['address']['street'],
        'sub_district' => $request->recipient['address']['sub_district'],
        'district' => $request->recipient['address']['district'],
        'city' => $request->recipient['address']['city'],
        'province' => $request->recipient['address']['province'],
        'postal_code' => $request->recipient['address']['postal_code'],
    ]);

    $recipient = DeliveryRecipient::findOrFail($request->recipient['id']);
    $recipient->update([
        'delivery_number' => $delivery->delivery_number,
        'name' => $request->recipient['name'],
        'address_id' => $address->id,
    ]);

    return new DeliveryResource(true, 'Data Delivery Berhasil Ditambahkan!', $delivery);
}


    public function destroy($id)
    {
        $delivery = Delivery::find($id);

       
        $delivery->delete();

       
        return new DeliveryResource(true, 'Data Delivery Berhasil Dihapus!', null);
    }

    public function filterByStatus(Request $request)
    {
        $q = $request->query('q'); 
        $page = $request->query('page', 1);  
        $limit = $request->query('limit', 10);

       
        $query = Delivery::with(['shipper.user']);

       
        if ($q) {
            $query->where('status', $q);
        }

       
        $deliveries = $query->paginate($limit, ['*'], 'page', $page);

       
        return new DeliveryResource(true, 'Filtered Deliveries by Status', $deliveries);
    }

    public function generateDeliveryNumber() {
       
        $date = date('ymd');
        
       
        $prefix = 'AHE' . $date;
        
       
       
        $lastDelivery = Delivery::where('delivery_number', 'like', $prefix . '%')
                                ->orderBy('delivery_number', 'desc')
                                ->first();
        
       
        if ($lastDelivery) {
            $lastNumber = (int)substr($lastDelivery->delivery_number, -5);
            $newNumber = $lastNumber + 1;
        } else {
           
            $newNumber = 1;
        }
        
       
        $runningNumber = str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        
       
        $deliveryNumber = $prefix . $runningNumber;
        
        return new DeliveryResource(true, 'Generate Delivery Number Success', $deliveryNumber);
    }
    
    public function getByShipper(Request $request)
    {
        $id = $request->query('id');  
        $q = $request->query('q');  
        $page = $request->query('page', 1);   
        $limit = $request->query('limit', 10);
       
        $query = Delivery::where('shipper_id', $id);
       
        if ($q) {
            $query->where('delivery_number', 'like', '%' . $q . '%')
                ->orWhere('company_name', 'like', '%' . $q . '%')
                ->orWhereHas('shipper.user', function($subQuery) use ($q) {
                    $subQuery->where('fullname', 'like', '%' . $q . '%');
                });
        }

        $deliveries = $query->paginate($limit, ['*'], 'page', $page);

        return new DeliveryResource(true, 'List Data Deliveries', $deliveries);
    }
}
