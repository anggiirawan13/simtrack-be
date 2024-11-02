<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(5);

        return new UserResource(true, 'List Data User', $users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'fullname' => 'required',
            'username' => 'required',
            'role_id' => 'required',
            'address_id' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'role_id' => $request->role_id,
            'address_id' => $request->address_id
        ]);

        //return response
        return new UserResource(true, 'Data User Berhasil Ditambahkan!', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        return new UserResource(true, 'Detail Data User!', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'fullname' => 'required',
            'username' => 'required',
            'role_id' => 'required',
            'address_id' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find user by ID
        $user = User::find($id);

        //check if image is not empty
        if ($request->hasFile('image')) {

            //update user with new image
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'fullname' => $request->fullname,
                'username' => $request->username,
                'role_id' => $request->role_id,
                'address_id' => $request->address_id
            ]);
        } else {

            //update user without image
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'fullname' => $request->fullname,
                'username' => $request->username,
                'role_id' => $request->role_id,
                'address_id' => $request->address_id
            ]);
        }

        //return response
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
