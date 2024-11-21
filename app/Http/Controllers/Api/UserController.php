<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\Shipper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $paginate = $request->query('paginate', true);
        $page = $request->query('page', 1); 
        $limit = $request->query('limit', 10);

       
        $query = User::with('address');

       
        if ($q) {
            $query->where(function($subQuery) use ($q) {
                $subQuery->where('username', 'like', '%' . $q . '%')
                        ->orWhere('fullname', 'like', '%' . $q . '%')
                        ->orWhere('role', 'like', '%' . $q . '%');
            });
        }

        if ($paginate === 'false' || $paginate == 0) {
           
            $users = $query->get();
        } else {
           
            $users = $query->paginate($limit, ['*'], 'page', $page);
        }

       
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
            'whatsapp' => $request->address['whatsapp'],
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

    public function show($id)
    {
        $user = User::with('address')->find($id);

        return new UserResource(true, 'Detail Data User!', $user);
    }

    public function update(Request $request, $id)
    {
       
        $validator = Validator::make($request->all(), [
            'password' => 'nullable',
            'fullname' => 'required',
            'username' => 'required',
        ]);

       
        if ($validator->fails()) {
            return new UserResource(false, 'Ada kolom yang wajid diisi.', $validator->errors());
        }

        $user = User::where('username', $request->username)->first();
        if ($user->id != $id) {
            return new UserResource(false, 'Username sudah ada.', null);
        }

       
        $user = User::find($id);
        $address = Address::find($user->address_id);

       
        $address->update([
            'whatsapp' => $request->address['whatsapp'],
            'street' => $request->address['street'],
            'sub_district' => $request->address['sub_district'],
            'district' => $request->address['district'],
            'city' => $request->address['city'],
            'province' => $request->address['province'],
            'postal_code' => $request->address['postal_code'],
        ]);

       
        $userData = [
            'id' => $id,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => $request->password,
            'role' => $request->role,
            'address_id' => $address->id,
        ];

       
        $user->update($userData);

       
        return new UserResource(true, 'Data User Berhasil Diubah!', $user);
    }


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

       
        $user->delete();

       
        return new UserResource(true, 'Data User Berhasil Dihapus!', null);
    }

    public function getUsersShipper()
    {     
        $users = User::with('address')->where('role', 'Shipper')->get();
       
        return new UserResource(true, 'List Data User', $users);
    }
}
