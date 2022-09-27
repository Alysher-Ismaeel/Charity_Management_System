<?php
    
    namespace App\Http\Controllers\Health;
    
    use App\Http\Controllers\Controller;
    use App\Models\Health\MedicalTool;
    use App\Models\Wallet;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;
    
    class MedicalToolsController extends Controller
    {
        public function add_medical_tool(Request $request)
        {
            $input=$request->all();
            $input['user_id'] = Auth::id();
            $input['category_id']=1;
            $validator = Validator::make($input, [
                'name' => 'required',
                'cost'=> 'required',
                'count'=> 'required',
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
            { $medical_tool =MedicalTool::query()->create($input);}
            return response()->json(['message' =>'Medical tool  added successfully'],200);
            
            
        }
        
        public function update_medical(MedicalTool $medicalTool,Request $request)
        {
            
            $medicalTool->update($request->all());
            return response()->json(
                ['message'=>'updated successfully',$medicalTool]
            );
        }
        
        public function Complete_medical()
        {
            
            return    $complete=DB::table('medical_tools')->whereColumn('count','donate')->get();
            
            
        }
        
        public function Incomplete_medical()
        {
            return $incomplete = MedicalTool::query()->whereColumn('count','>','donate')->get();
        }
        public function Delete_medical(MedicalTool $medicalTool)
        {
            $medicalTool->delete();
            return response()->json([
                'message'=>'medical record get deleted ',$medicalTool],200);
        }
        
        public function DeleteComplete_medical()
        
        {
            $complete=MedicalTool::query();
            $complete->whereColumn('count','donate')->get();
            $complete->delete();
            
            return response()->json([
                'message'=>' complete medical tool records get deleted '],200);
        }
        
        public function DonateMedicalTool(MedicalTool $medicalTool,Request $request)//عملية التبرع بالنسبة للمرضى من قبل المتبرعين //user_id
        {
            $user=Auth::id();
            $input=$request->all();
            $wallet=Wallet::query()->where('user_id',Auth::id())->first();
            $price_of_medical=$input['donate']*$medicalTool['cost'];
            if($price_of_medical > $wallet['money']){
                return response()->json([
                    'message'=>'you do not have enough money'],400);
            }
            if($input['donate']+$medicalTool['donate']>$medicalTool['count'])
            { return response()->json([
                'message'=>'we do not need that much of this' ],400);}
            
            $medicalTool->update(['donate'=>$medicalTool['donate']+$input['donate']]);
            $wallet->update(['money'=>$wallet['money']-$price_of_medical]);
            $medicalTool->user()->syncWithoutDetaching([$user]);
            return  response()->json(['meesage'=>'thanks for donating',
                'count'=>$medicalTool['count'],
                'donate'=>$medicalTool['donate'],
                'money'=>$wallet['money'],
                'total '=>$price_of_medical,
            ]);
            
            
        }
        
    }
