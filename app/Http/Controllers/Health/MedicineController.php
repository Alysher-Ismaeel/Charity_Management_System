<?php

namespace App\Http\Controllers\Health;
use App\Http\Controllers\Controller;
use App\Models\Health\Medicine;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class MedicineController extends Controller
{
    
    public function add(Request $request)
    {
        $input=$request->all();
        $input['user_id'] = Auth::id();
        $input['category_id']=1;
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
            Medicine::query()->create($input);
        }
        return response()->json(['message' =>'medicine added successfully'],200);
    }
//______________________________________________________________________________________________________________________
    
    public function update(Medicine $medicine, Request $request)
    {
        $medicine->update($request->all());
        return response()->json(
            ['message'=>'updated successfully',
                'medicine' => $medicine]
        );
    }
//______________________________________________________________________________________________________________________
    
    public function ShowComplete()
    {
        return DB::table('medicines')->whereColumn('count', 'donate')->get();
    }
//______________________________________________________________________________________________________________________
    
    public function ShowIncomplete()
    {
        return Medicine::query()->whereColumn('count', '>', 'donate')->get();
    }
//______________________________________________________________________________________________________________________
    
    public function Donate(Medicine $medicine,Request $request)
    {
        $user = Auth::id();
        $input = $request->all();
        $wallet = Wallet::query()->where('user_id',Auth::id())->first();
        if($input['donate'] * $medicine['cost'] > $wallet['money']){ //donate: هنا عبارة عن عدد الأدوية التي يريد التبرع بها
            return response()->json([
                'message'=>'you do not have enough money'],400);
        }
        if($input['donate'] + $medicine['donate']>$medicine['count'])
        { return response()->json([
            'message'=>'you have added over count'],400);}
        $medicine->update(['donate' => $medicine['donate'] + $input['donate']]);
        $wallet->update(['money' => $wallet['money'] - $input['donate'] * $medicine['cost']]); // سعر الدواء مضروب بعدده
        $medicine->user()->syncWithoutDetaching([$user]); //without repetition
        return  response()->json(['message'=>'thanks for donating',
            'donate' => $medicine['donate'],
            'money'=> $wallet['money'],
            'count'=> $medicine['count'] - $medicine['donate']]); //عدد الادوية المتبرع بها الكلي= عدد الأدية الكلي - الأدوية المتبرع بها
    }
//______________________________________________________________________________________________________________________
   
    public function Delete(Medicine $medicine)
    {
        $medicine->delete();
        return response()->json([
            'message'=>'medicine record get deleted ',$medicine],200);
    }
//______________________________________________________________________________________________________________________
   
    public function DeleteComplete()
    {
        $complete=Medicine::query();
        $complete->whereColumn('count','donate')->get();
        $complete->delete();
        return response()->json([
            'message'=>' complete medicine records get deleted '],200);
    }
//______________________________________________________________________________________________________________________
}
