<?php

namespace App\Validations;
class UserValidations
{
    public function login($request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);
    }

    public function edit($request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
    }

    public function store($request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])/',
        ], [
            'password.regex' => 'The password must have at least one special character, one number and one letter.',
        ]);
    }
}
