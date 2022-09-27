<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
//    public function adminLogin(){
//        $input = Input::all();
//        if(count($input) > 0){
//            $auth = auth()->guard('admin');
//
//            $credentials = [
//                'email' =>  $input['email'],
//                'password' =>  $input['password'],
//            ];
//
//            if ($auth->attempt($credentials)) {
//                return redirect()->action('LoginController@profile');
//            } else {
//                echo 'Error';
//            }
//        } else {
//            return view('admin.login');
//        }
//    }
//
//    public function profile(){
//        if(auth()->guard('admin')->check()){
//            pr(auth()->guard('admin')->user()->toArray());
//        }
//        if(auth()->guard('user')->check()){
//            pr(auth()->guard('user')->user()->toArray());
//        }
//    }
    public function register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'validator error'],400);
        }
        $input['password'] = bcrypt($input['password']);
        $user = Admin::create($input);
        $token = $user->createToken('ABC')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'Admin sign up Successfully!'],200);
    }
    //__________________________________________________________________________________________________________________
    public function login(Request $request)
    {
        if (\auth('admin')->attempt(['email' => request('email'),
                                            'password' => request('password')]))
        {
            $admin=Auth::guard('admin')->user();
            $token = $admin->createToken('ABC')->plainTextToken;
            return response()->json(
                ['name' => $admin['name'],
                    'token' => $token,
                    'message' => 'login successfully'
                ],200);}
        return response()->json(['message' =>'Unauthorised'],401);
    }
    //__________________________________________________________________________________________________________________
    public function logout()
    {
        Auth::guard('admin')->logout();
        return response()->json(['message' => "you have logout successfully"],200);}
}
