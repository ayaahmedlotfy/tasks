<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validations\UserValidations;
use App\Services\UserServices;


class UserController extends Controller
{   /**
    * @param UserValidation $userValidation
    */
   public function __construct(protected UserValidations $userValidation,protected UserServices $userServices)
   {
   }
   public function login(Request $request)
    {
        $this->userValidation->login($request);
        return $this->userServices->login($request);
    }
    public function index()
    {
        return $this->userServices->index();
    }

    public function show($id)
    {
        return $this->userServices->show($id);
    }

    public function register(Request $request)
    {
    
        $this->userValidation->store($request);
        return $this->userServices->store($request);
    }

    public function update(Request $request, $id)
    {
        $this->userValidation->edit($request,$id);
        return $this->userServices->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->userServices->destroy($id);
    }
}
