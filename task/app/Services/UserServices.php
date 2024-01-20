<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendEmail;

class UserServices
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(protected UserRepository $userRepository)
    {

    }

  
    public function index()
    {
        return $this->userRepository->index();
    }

    public function show($id)
    {
        return $this->userRepository->show($id);
    }

    public function store($request)
    {
        $user =$this->userRepository->store($request);
        dispatch(new SendEmail($user));
        return response()->json(['user' => $user, 'message' => 'User created successfully'], 201);
    }

    public function login($request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user=$this->userRepository->getByEmail($request);
                $token = $user->createToken('User')->accessToken;
                $accessToken = Auth::user()->createToken('User')->accessToken;

                $allData = [
                    "id" => intval($user["id"]),
                    "name" => $user["name"],
                    "email" => $user["email"],
                    "created_at" => $user["created_at"],
                    "updated_at" => $user["updated_at"],
                    'token' =>  $accessToken          
                ];
                $response = response()->json(['message'=>$allData],200);
        } else { $response = response()->json(['message' => "wrong credintiels"], 404);
        }
        return $response;
    }





    public function update( $request, $id)
    {
     
        $user =  $this->userRepository->show($id);
        $this->userRepository->update($request, $user);
        return response()->json(['user' => $user, 'message' => 'User updated successfully']);
    }

    public function destroy($id)
    {
        $user =  $this->userRepository->show($id);
        $this->userRepository->destroy( $user);
        return response()->json(['message' => 'User deleted successfully']);
    }


}
