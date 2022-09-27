<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Education\Guarantee;
use App\Models\Feeding\FoodSection;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\Mime\Header\get;

class GuaranteeController extends Controller
{
    public function add(Request $request){
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $input['category_id']=3;
        $validator = Validator::make($input, [
            'name' => 'required',
            'birth_date' => 'required',
            'academic_year' => 'required',
            'cost' => 'required'
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
            Guarantee::query()->create($input);
        }
        return response()->json(['message' =>'A student added successfully'],200);
    }
    //__________________________________________________________________________________________________________________
    public function show_unguranteed(){
        $guarantee =  DB::table('guarantees')->where('guaranteed', false)->get();
        return response()->json(['Students'=>$guarantee],200);
    }
    //__________________________________________________________________________________________________________________
    public function show_guaranteed(){
        return DB::table('guarantees')->where('guaranteed', true)->get();
    }
    //__________________________________________________________________________________________________________________
    public function user_guarantee(){
        $user=Auth::id();
        $guarantee = Guarantee::query()->whereRelation('user','user_id',$user)->get();
        return response()->json(['guarantee'=>$guarantee]);
    }
    //__________________________________________________________________________________________________________________
    public function showAll(){
        $guarantees = Guarantee::query()->get()->all();
        foreach ($guarantees as $guarantee){
            if (Carbon::parse($guarantee['exp_date']) <= now()) {
                $guarantee->update(['guaranteed'=> 0]);
            }
        }
        return response()->json(['Students'=>$guarantees]);
    }
    //__________________________________________________________________________________________________________________
    public function update(Guarantee $guarantee,Request $request){
        $guarantee->update($request->all());
        return response()->json(['message' => 'student update successfully',
                                  'student' => $guarantee ],200);
    }
    //__________________________________________________________________________________________________________________
    public function delete(Guarantee $guarantee){
        $guarantee->delete();
        return response()->json(['message'=>'student deleted successfully'],200);
    }
    //__________________________________________________________________________________________________________________
    public function search(Request $request){
        $results = Guarantee::query()->where('name',$request->name)
                                       ->orWhere('birth_date','=',$request->birth_date)
                                        ->orWhere('academic_year','=',$request->academic_year)->get();
        if($request->age){
            $birht = Carbon::now()->year;
            $guarantees = Guarantee::query()->get();
            $results = array();
            foreach ($guarantees as $guarantee){
                $date = Carbon::parse($guarantee['birth_date'])->year;
                $age = $birht - $date;
                if ($request->age == $age)
                    $results[] = $guarantee;}
        }
        return response()->json(['Students' => $results]);
    }
    //__________________________________________________________________________________________________________________
    public function sort($method){
    return Guarantee::query()->get()->sortBy($method);
    }
    //__________________________________________________________________________________________________________________
        public function donate(Guarantee $guarantee,Request $request){
        $user = Auth::id();
        $wallet=Wallet::query()->where('user_id',$user)->first();
        if($guarantee['cost'] > $wallet['money']){
            return response()->json([
                'message'=>'you do not have enough money'],400);
        }
        if($guarantee['guaranteed']){
            return response()->json(['message' => 'Already guaranteed'],400);
        }
        $guarantee->update(['guaranteed'=>'1', 'time' => now(), 'exp_date' =>Carbon::now()->addYear()]);
        $wallet->update(['money'=>$wallet['money']-$guarantee['cost']]);
        $guarantee->user()->syncWithoutDetaching([$user]);
            return response()->json(['message' => $guarantee],200);
        }
}
