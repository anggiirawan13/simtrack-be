<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\Shipper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $paginate = $request->query('paginate', true);
        $page = $request->query('page', 1);  // Default to page 1
        $limit = $request->query('limit', 10); // Default to 10 items per page

        // Start a query builder for users with address relationship
        $query = User::with('address');

        // Apply search filter if 'q' parameter is provided
        if ($q) {
            $query->where(function($subQuery) use ($q) {
                $subQuery->where('username', 'like', '%' . $q . '%')
                        ->orWhere('fullname', 'like', '%' . $q . '%')
                        ->orWhere('role', 'like', '%' . $q . '%');
            });
        }

        if ($paginate === 'false' || $paginate == 0) {
            // No pagination, get all results
            $users = $query->get();
        } else {
            // Paginate the results
            $users = $query->paginate($limit, ['*'], 'page', $page);
        }

        // Return paginated response as a resource
        return new UserResource(true, 'List Data User', $users);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'fullname' => 'required',
            'username' => 'required',
        ]);

        if ($validator->fails()) {
            return new UserResource(false, 'Ada kolom yang wajid diisi.', $validator->errors());
        }

        $user = User::where('username', $request->username)->first();
        if ($user) {
            return new UserResource(false, 'Username sudah ada.', null);
        }

        $address = Address::create([
            'street' => $request->address['street'],
            'sub_district' => $request->address['sub_district'],
            'district' => $request->address['district'],
            'city' => $request->address['city'],
            'province' => $request->address['province'],
            'postal_code' => $request->address['postal_code'],
        ]);

        $user = User::create([
            'password' => $request->password,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'role' => $request->role,
            'address_id' => $address->id,
        ]);

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
            return new UserResource(false, 'Ada kolom yang wajid diisi.', $validator->errors());
        }

        $user = User::where('username', $request->username)->first();
        if ($user) {
            return new UserResource(false, 'Username sudah ada.', null);
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
            'password' => $request->password,
            'role' => $request->role,
            'address_id' => $address->id,
        ];

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
        $shipper = Shipper::where('user_id', $id)->first();
        if ($shipper) {
            return new UserResource(false, 'User tidak bisa dihapus, karena sudah dimapping dengan shipper.', null);
        }

        $user = User::find($id);
        if (!$user) {
            return new UserResource(false, 'User tidak ditemukan.', null);
        }

        //delete user
        $user->delete();

        //return response
        return new UserResource(true, 'Data User Berhasil Dihapus!', null);
    }
}
