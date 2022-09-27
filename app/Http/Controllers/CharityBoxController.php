<?php

namespace App\Http\Controllers;

use App\Models\CharityBox;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CharityBoxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin_api');
    }
    
    public function create(Request $request){
        $input = $request->all();
        $input['money'] = 0;
        $validator = Validator::make($input,[
            'password'=>'required ',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => "validator error"
            ], 400);
        }
        $input['password'] = bcrypt($input['password']);
        $box = CharityBox::query()->create($input);
        return response()->json(['message'=>'done'],200);
    }
    public function show(){
        return CharityBox::query()->first();
    }
    public function set_password(Request $request){
        $box  = CharityBox::query()->first();
        if ($request->password == $box['password'])
            return response()->json(['message' => 'true']);
        return response()->json(['message' => 'false']);
}
}
