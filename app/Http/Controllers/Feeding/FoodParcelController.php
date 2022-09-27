<?php

namespace App\Http\Controllers\Feeding;

use App\Http\Controllers\Controller;
use App\Models\Feeding\FoodParcel;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FoodParcelController extends Controller
{
    public function add(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $input['category_id']=1;
        $validator = Validator::make($input, [
            'size' => 'required',
            'cost' => 'required',
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' =>"validator error"
            ],400);
        }
        if($request->hasFile('image')){
            $input['image']= $this->saveimage($input['image'],'images');
        }
        if($input['user_id'] == Auth::check()) {
            FoodParcel::query()->create($input);
        }
        return response()->json(['message' =>'food parcel added successfully'],200);
    }
    
    public function update(FoodParcel $foodParcel,Request $request)
    {
        $foodParcel->update($request->all());
        return response()->json(
            ['message'=>'updated successfully',$foodParcel]
        );
    }
    
    public function Show()
    {
        return FoodParcel::query()->get()->all();
    }
    
    public function Donate(FoodParcel $foodParcel,Request $request)
    {
        $user = Auth::id();
        $input = $request->all();
        $wallet = Wallet::query()->where('user_id',Auth::id())->first();
        if($input['donate'] * $foodParcel['cost'] > $wallet['money']){ //donate: هنا عبارة عن عدد الأدوية التي يريد التبرع بها
            return response()->json([
                'message'=>'you do not have enough money'],400);
        }
        $foodParcel->update(['donate' => $foodParcel['donate'] + $input['donate']]);
        $wallet->update(['money' => $wallet['money'] - $input['donate'] * $foodParcel['cost']]); // سعر الدواء مضروب بعدده
        //$foodParcel['count'] =
        $foodParcel->user()->syncWithoutDetaching([$user]); //without repetition
        return  response()->json(['message'=>'thanks for donating',
            'total_donate' => $foodParcel['donate'],
            'money'=> $wallet['money'],
            ]); //عدد الادوية المتبرع بها الكلي= عدد الأدية الكلي - الأدوية المتبرع بها
    }
    
    public function Delete(FoodParcel $foodParcel)
    {
        $foodParcel->delete();
        return response()->json([
            'message'=>'food parcel record get deleted ',$foodParcel],200);
    }
}
