<?php
    
    namespace App\Http\Controllers\Education;
    
    use App\Http\Controllers\Controller;
    use App\Models\Education\Stationery;
    use App\Models\Wallet;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;
    
    class StationeryController extends Controller
    {
        
        public function add_stationery(Request $request)
        {
            $input = $request->all();
            $input['user_id'] = Auth::id();
            $input['category_id'] = 3;
            $validator = Validator::make($input, [
                'name' => 'required',
                'cost' => 'required',
                'size'=>'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => "validator error"
                ], 400);
            }
            if ($request->hasFile('image')) {
                $input['image'] = $this->saveimage($input['image'], 'images');
            }
            if ($input['user_id'] == Auth::check()) {
                $stationery = Stationery::query()->create($input);
            }
            return response()->json(['message' => 'Stationery added successfully'], 200);
            
            
        }
        
        public function update_stationery(Stationery $stationery, Request $request)
        {
            
            $stationery->update($request->except(['count','donate']));
            return response()->json(
                ['message' => 'updated successfully', $stationery]
            );
        }
        
        public function show_stationery()
        {
            
            return response()->json(['stationery' => $stationery = Stationery::query()->get()]);
            
        }
        public function Delete_stationery(Stationery $stationery)
        {
            $stationery->delete();
            return response()->json([
                'message' => 'stationery record get deleted ', $stationery], 200);
        }
        
        
        
        public function Donate_stationery(Stationery $stationery,Request $request)
        {
            $user=Auth::id();
            $input=$request->all();
            $wallet=Wallet::query()->where('user_id',$user)->first();
            $price_of_stationery=$input['donate']*$stationery['cost'];
            if($price_of_stationery > $wallet['money']){
                return response()->json([
                    'message'=>'you do not have enough money'],400);
            }
            $stationery->update(['donate'=>$input['donate']]);
            $stationery->update(['count'=>$stationery['count']+$stationery['donate']]);
            $wallet->update(['money'=>$wallet['money']-$price_of_stationery]);
            $stationery->user()->syncWithoutDetaching([$user]);
            return  response()->json(['message'=>'thanks for donating',
                'count'=>$stationery['count'],
                'donate'=>$stationery['donate'],
                'money'=>$wallet['money'],
                'total '=>$price_of_stationery
                ,
            ]);
            
            
        }
    }
