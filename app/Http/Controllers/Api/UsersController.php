<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class UsersController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
  
        $token = $user->createToken('Laravel8PassportAuth')->accessToken;
  
        return response()->json(['token' => $token], 200);
    }
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('Laravel8PassportAuth')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    public function changeRole(Request $request)
    {
        $token = auth()->user()->roles;
        $user_id = $request->user_id;
        $roles = $request->roles;
        if($token == 'Admin'){
            try{
                DB::table('users')->where('id', $user_id)->update(['roles' => $roles]);
                $status = 'success';
            }catch(\Exception $e) {
                $status = 'error';
            }
            return response()->json(['status' => $status], 200);
        }else{
            return response()->json(['error' => 'Unauthorised to change role'], 401);
        }
    }
}
