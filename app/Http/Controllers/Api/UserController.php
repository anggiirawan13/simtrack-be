<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('address')->get();

        return new UserResource(true, 'List Data User', $users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'fullname' => 'required',
            'username' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $address = Address::create([
            'street' => $request->address['street'],
            'sub_district' => $request->address['sub_district'],
            'district' => $request->address['district'],
            'city' => $request->address['city'],
            'province' => $request->address['province'],
            'postal_code' => $request->address['postal_code'],
        ]);

        //create user
        $user = User::create([
            'password' => $request->password,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'role' => $request->role,
            'address_id' => $address->id,
        ]);

        //return response
        return new UserResource(true, 'Data User Berhasil Ditambahkan!', null);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with('address')->find($id);

        return new UserResource(true, 'Detail Data User!', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'password' => 'nullable', // Allow password to be null
            'fullname' => 'required',
            'username' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find user by ID
        $user = User::find($id);
        $address = Address::find($user->address_id);

        // Update address fields
        $address->update([
            'street' => $request->address['street'],
            'sub_district' => $request->address['sub_district'],
            'district' => $request->address['district'],
            'city' => $request->address['city'],
            'province' => $request->address['province'],
            'postal_code' => $request->address['postal_code'],
        ]);

        // Prepare data for user update
        $userData = [
            'id' => $id,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'role' => $request->role,
            'address_id' => $address->id,
        ];

        // Update password only if provided
        if ($request->filled('password') && !Hash::check($request->password, $user->password)) {
            $userData['password'] = Hash::make($request->password); // Hash password before saving
        }

        // Update user
        $user->update($userData);

        // Return response
        return new UserResource(true, 'Data User Berhasil Diubah!', $user);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        //delete user
        $user->delete();

        //return response
        return new UserResource(true, 'Data User Berhasil Dihapus!', null);
    }
}
