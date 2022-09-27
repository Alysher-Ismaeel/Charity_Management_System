<?php

namespace App\Http\Controllers\Health;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Health\Patient;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function add_patient(Request $request)
    {
        $category = Category::query()->find(1);
        $input=$request->all();
        $input['user_id'] = Auth::id();
        $input['category_id']  = $category['id'];
        $validator = Validator::make($input, [
            'name' => 'required',
            'medical_condition'=> 'required',
            'cost'=> 'required',
            'gender'=> 'required',
            'birth_date' => 'required'//|date'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' =>"validator error"
            ],400);
        }
        if($request->hasFile('image')){
            $input['image']= $this->saveimage($input['image'],'images');
        }
        if($input['user_id']==Auth::check())
        {$patient =Patient::query()->create($input);}
        return response()->json(['message' =>'patient added successfully'],200);
    }
//______________________________________________________________________________________________________________________
    
    public function updatepatient(Patient $patient,Request $request)
    {
        $patient->update($request->all());
        return response()->json(
            ['message'=>'updated successfully',
                'patient' => $patient]
        );
    }
//______________________________________________________________________________________________________________________
    
    public function CompletePatient() //تظهر المرضى المنتهي تبرعهم للادمن فقط
    {
        $complete = DB::table('patients')->whereColumn('cost','donate')->get();
        return response()->json(['patients' => $complete]);
    }
//______________________________________________________________________________________________________________________
    
    public function IncompletePatient()//تظهر المرضى الغير منتهي تبرعهم للادمن و المتبرع
    {
        $patient = Patient::query()->whereColumn('cost', '>', 'donate')->get();
        return response()->json(['patients' => $patient]);
    }
//______________________________________________________________________________________________________________________
    public function DonatePatient(Patient $patient,Request $request)//عملية التبرع بالنسبة للمرضى من قبل المتبرعين //user_id
    {
        $user=Auth::id();
        $input=$request->all();
        $wallet=Wallet::query()->where('user_id',Auth::id())->first();

        if($input['donate'] > $wallet['money']){
            return response()->json([
                'message'=>'you do not have enough money'],400);
        }
        if($input['donate']>$patient['cost']-$patient['donate'])
        { return response()->json([
            'message'=>'you  add a lot of money'],400);}
        $patient->update(['donate'=>$patient['donate']+$input['donate']]);
        $wallet->update(['money'=>$wallet['money']-$input['donate']]);
        $patient->user()->syncWithoutDetaching([$user]);
        return  response()->json(['meesage'=>'thanks for donating',
            'donate'=>$patient['donate'],
            'money'=>$wallet['money'],
            'total donate'=>$patient['cost']-$patient['donate']]);
    }
//______________________________________________________________________________________________________________________
    public function Delete(Patient $patient)
    {
        $patient->delete();
        return response()->json([
            'message'=>'patient record get deleted ',$patient],200);
    }
//______________________________________________________________________________________________________________________
    public function DeleteCompletePatient()

    {
        $complete=Patient::query();
        $complete->whereColumn('cost','donate')->get();
        $complete->delete();

        return response()->json([
            'message'=>' complete patient records get deleted '],200);
    }
//______________________________________________________________________________________________________________________
}
