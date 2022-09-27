<?php
    
    namespace App\Http\Controllers\Feeding;
    
    use App\Http\Controllers\Controller;
    use App\Models\Feeding\KitchenSet;
    use App\Models\Wallet;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;
    
    class KitchenSetController extends Controller
    {
        public function add_Kitchen_Set(Request $request)
        {
            $input=$request->all();
            $input['user_id'] = Auth::id();
            $input['category_id']=2;
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
            { $kitchen_set=KitchenSet::query()->create($input);}
            return response()->json(['message' =>'Kitchen set added successfully'],200);
            
            
        }
        
        public function update_kitchen_set(KitchenSet $kitchen_set,Request $request)
        {
            
            $kitchen_set->update($request->except(['donate']));
            return response()->json(
                ['message'=>'updated successfully',$kitchen_set]
            );
        }
        
        public function Complete_kitchen_set()
        {
            
            return response()->json( ['kitchen set'=> $complete=DB::table('kitchen_sets')->whereColumn('count','donate')->get()]);
            
            
        }
        
        public function Incomplete_kitchen_set()
        {
            return response()->json( ['kitchen set'=>$incomplete = KitchenSet::query()->whereColumn('count','>','donate')->get()]);
            
        }
        public function Delete_kitchen_set(KitchenSet $kitchen_set)
        {
            $kitchen_set->delete();
            return response()->json([
                'message'=>'kitchen set record get deleted ',$kitchen_set],200);
        }
        
        public function DeleteComplete_kitchen_set()
        
        {
            $complete=KitchenSet::query();
            $complete->whereColumn('count','donate')->get();
            $complete->delete();
            
            return response()->json([
                'message'=>' complete kitchen set records get deleted '],200);
        }
        
        public function Donate_kitchen_set(KitchenSet $kitchen_set,Request $request)
        {
            $user=Auth::id();
            $input=$request->all();
            $wallet=Wallet::query()->where('user_id',$user)->first();
            $price_of_kitchen_set=$input['donate']*$kitchen_set['cost'];
            if($price_of_kitchen_set > $wallet['money']){
                return response()->json([
                    'message'=>'you do not have enough money'],400);
            }
            if($input['donate']+$kitchen_set['donate']>$kitchen_set['count'])
            { return response()->json([
                'message'=>'we do not need that much of this' ],400);}
            
            $kitchen_set->update(['donate'=>$kitchen_set['donate']+$input['donate']]);
            $wallet->update(['money'=>$wallet['money']-$price_of_kitchen_set]);
            $kitchen_set->user()->syncWithoutDetaching([$user]);
            return  response()->json(['meesage'=>'thanks for donating',
                'count'=>$kitchen_set['count'],
                'donate'=>$kitchen_set['donate'],
                'money'=>$wallet['money'],
                'total '=>$price_of_kitchen_set,
            ]);
            
            
        }
        
    }
