<?php

namespace App\Http\Controllers;

use App\Constants\App;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AuthApiController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        if (Auth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ])) {
            $authUser = Auth::user();
            $success['token'] = $authUser->createToken(App::API_SERVICE_TOKEN_NAME)->plainTextToken;
            // event(new Registered($authUser));
            return $this->json($success);
        } else {
            return $this->error('Unauthorised');
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken(App::API_SERVICE_TOKEN_NAME)->plainTextToken;
        // $success['name'] =  $user->name;

        return $this->json($success);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->json(true);
    }


}
