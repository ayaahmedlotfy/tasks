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
       $user= $this->userRepository->show($id);
        if ($user)return $user;
        return response()->json(['message' => 'User did not exist'], 402);

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
                $accessToken = Auth::user()->createToken('User')->accessToken;
                return response()->json(['message'=>[  'token' =>  $accessToken ]],200);
        } else {return response()->json(['message' => "wrong credintiels"], 404);
        }
    }

    public function update( $request, $id)
    {
     
        $user =  $this->userRepository->show($id);
        if ($user){  
            $this->userRepository->update($request, $user);
            return response()->json(['user' => $user, 'message' => 'User updated successfully']);
        }else{
            return response()->json(['message' => 'User did not exist'], 402);
        }
    }

    public function destroy($id)
    {
        $user =  $this->userRepository->show($id);
        if($user){
            $this->userRepository->destroy( $user);
            return response()->json(['message' => 'User deleted successfully']);
        }else{
            return response()->json(['message' => 'User did not exist'],402);
        }
    }


}
