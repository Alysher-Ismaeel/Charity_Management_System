<?php

namespace App\Http\Controllers\Feeding;

use App\Http\Controllers\Controller;
use App\Models\Feeding\FoodSection;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FoodSectionController extends Controller
{
    public function add(Request $request)
    {
        $input=$request->all();
        $input['user_id'] = Auth::id();
        $input['category_id']=2;
        $validator = Validator::make($input, [
            'name' => 'required',
            'count' => 'required',
            'cost' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' =>"validator error"
            ],400);
        }
        if($request->hasFile('image')){
            $input['image']= $this->saveimage($input['image'],'images');
        }
        if($input['user_id']==Auth::check()) {
            FoodSection::query()->create($input);
        }
        return response()->json(['message' =>'FoodSection added successfully'],200);
    }
//______________________________________________________________________________________________________________________
    
    public function update(FoodSection $foodSection, Request $request)
    {
        $foodSection->update($request->all());
        return response()->json(
            ['message'=>'updated successfully',
                'FoodSection' => $foodSection]
        );
    }
//______________________________________________________________________________________________________________________
    
    public function ShowComplete()
    {
        return DB::table('food_sections')->whereColumn('count', 'donate')->get();
    }
//______________________________________________________________________________________________________________________
    
    public function ShowIncomplete()
    {
        return FoodSection::query()->whereColumn('count', '>', 'donate')->get();
    }
//______________________________________________________________________________________________________________________
    
    public function Donate(FoodSection $foodSection,Request $request)
    {
        $user = Auth::id();
        $input = $request->all();
        $wallet = Wallet::query()->where('user_id',Auth::id())->first();
        if($input['donate'] * $foodSection['cost'] > $wallet['money']){ //donate: هنا عبارة عن عدد الأدوية التي يريد التبرع بها
            return response()->json([
                'message'=>'you do not have enough money'],400);
        }
        if($input['donate'] + $foodSection['donate']>$foodSection['count'])
        { return response()->json([
            'message'=>'you have added over count'],400);}
        $foodSection->update(['donate' => $foodSection['donate'] + $input['donate']]);
        $wallet->update(['money' => $wallet['money'] - $input['donate'] * $foodSection['cost']]); // سعر الدواء مضروب بعدده
        $foodSection->user()->syncWithoutDetaching([$user]); //without repetition
        return  response()->json(['message'=>'thanks for donating',
            'donate' => $foodSection['donate'],
            'money'=> $wallet['money'],
            'total donate'=> $foodSection['count'] - $foodSection['donate']]); //عدد الادوية المتبرع بها الكلي= عدد الأدية الكلي - الأدوية المتبرع بها
    }
//______________________________________________________________________________________________________________________
    
    public function Delete(FoodSection $foodSection)
    {
        $foodSection->delete();
        return response()->json([
            'message'=>'FoodSection record get deleted ',$foodSection],200);
    }
//______________________________________________________________________________________________________________________
    
    public function DeleteComplete()
    {
        $complete=FoodSection::query();
        $complete->whereColumn('count','donate')->get();
        $complete->delete();
        return response()->json([
            'message'=>' complete FoodSection records get deleted '],200);
    }
//______________________________________________________________________________________________________________________

}
