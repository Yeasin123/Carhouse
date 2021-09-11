<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(),[

            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|',
            'c_password' => 'required|same:password',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(),202);
        }
        else{

            $admin = new Admin;
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = $request->password;
            $admin->password = Hash::make($admin->password);
            $admin->save();
            $token =[];
            $token['token'] = $admin->createToken('api-token')->accessToken;
            return response()->json($token,200);


        }

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $admin = Admin::where('email', $request->email)->first();
        if ($admin) {
            if (Hash::check($request->password, $admin->password)) {
                $token = $admin->createToken('carhouse')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'admin does not exist'];
            return response($response, 422);
        }

    }

    public function getAdmin()
    {
        $admin = Admin::all();
        if($admin){
            return response()->json($admin);
        }
        else{
            return response()->json(['error' => 'Unauthorized'],203);
        } 
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);

    }
}
