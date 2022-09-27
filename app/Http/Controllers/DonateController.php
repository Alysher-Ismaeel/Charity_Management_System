<?php

namespace App\Http\Controllers;

use App\Models\CharityBox;
use App\Models\Donate;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class DonateController extends Controller
{
    public function donate(Request $request){
       $user = Auth::id();
       $box = CharityBox::query()->first();
       $input = $request->all();
       $input['user_id']=$user;
        $validator = Validator::make($input, [
            'amount'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => "validator error"
            ], 400);
        }
        $input['charity_box_id'] = $box['id'];
       $wallet=Wallet::query()->where('user_id',$user)->first();
       $box = CharityBox::query()->first();
       if($input['amount'] > $wallet['money'])//donate: هنا عبارة عن عدد الأدوية التي يريد التبرع بها
       {
           return response()->json([
               'message' => 'you do not have enough money'], 400);
       }
       $donate = Donate::query()->create($input);
       $wallet->update(['money' => $wallet['money'] - $input['amount']]);
       $box->update(['money'=>$box['money']+$input['amount']]);
       return response()->json(['message'=>'thanks for your donation','donate'=>$donate],200);
   }
   public function show(){
        return Donate::query()->with('user')->get();
   }
}
