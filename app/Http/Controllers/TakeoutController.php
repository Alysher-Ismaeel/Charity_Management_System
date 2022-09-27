<?php

namespace App\Http\Controllers;

use App\Models\CharityBox;
use App\Models\Takeout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TakeoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin_api');
    }
    public function takeout(Request $request){
        $box = CharityBox::query()->first();
        $input = $request->all();
        $input['charity_box_id']=$box['id'];
        $input['admin_id'] = Auth::id();
        $validator = Validator::make($input, [
            'amount'=>'required',
            'reason'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => "validator error"
            ], 400);
        }
        if ($box['money']<$input['amount'])
            return response()->json(['message'=>'This amount is not available'],400);
        $takeout = Takeout::query()->create($input);
        $box->update(['money'=>$box['money']-$input['amount']]);
        return response()->json(['message'=>'done','takeout'=>$takeout],200);
    }
}
