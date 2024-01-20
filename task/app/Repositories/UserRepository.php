<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{

  
    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }
    public function getByEmail($request)
    {
        return User::where("email",$request->email)->first();
    }
    public function store( $request)
    {
      return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

    }


    public function update( $request, $user)
    {

        return  $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

    }

    public function destroy($user)
    {
        return  $user->delete();
    }


}
