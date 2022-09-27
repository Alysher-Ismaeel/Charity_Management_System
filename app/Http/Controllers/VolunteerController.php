<?php
    
    namespace App\Http\Controllers;
    
    use App\Mail\SendMail;
    use App\Models\Admin;
    use App\Models\Resignation;
    use App\Models\User;
    use App\Models\Volunteer;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\Validator;
    
    class VolunteerController extends Controller
    {
        //تقديم طلب التطوعات
        public function volunteer(Request $request){
            $input = $request->all();
            $input['user_id'] = Auth::id();
            $validator = Validator::make($input, [
                'identity'=>'required',
                'certificate'=>'required',
                'phone'=>'required',
                'gender' => 'required',
                'job' => 'required',
                'category_id'=>'required',
                'birth'=>'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => "validator error"
                ], 400);
            }
            if($request->hasFile('identity')){
                $input['identity']= $this->saveimage($input['identity'],'identity');}
    
            if($request->hasFile('certificate')){
                $input['certificate']= $this->saveimage($input['certificate'],'certificate');
            }
            $user = Auth::id();
            $volunteers = Volunteer::query()->where('user_id',$user)->get();
            foreach ($volunteers as $volunteer)
            if($volunteer->user_id==$user)
                return response()->json(['volunteer' => "already exist"], 400);
            
            Volunteer::query()->create($input);
            return response()->json(['volunteer'=> "done"],200);
            }
            
        public function VolunteerRequests()
        {
            return response()->json(['Requests'=>Volunteer::query()->with('user')->where('accepted','=','0')->get()->all()]);
        }
        public function AcceptedRequests(Volunteer $volunteer){
            $volunteer['accepted']=1;
            $volunteer->save();
            return response()->json(['message'=>"volunteer accepted",$volunteer],200);
            
        }
        public function RejectedRequests(Volunteer $volunteer){
            $volunteer->delete();
            return response()->json([
                'message'=>'not accepted',$volunteer],200);
        }
        public function MedicalTeam()
        {
            $volunteer=Volunteer::query()->with('user')->where('accepted','=','1')
                ->where('category_id','=','1')->get();
            return response()->json(['MEDICAL_TEAM'=>$volunteer]);
        }
        public function EducationalTeam()
        {
            $volunteer=Volunteer::query()->with('user')->where('accepted','=','1')
                ->where('category_id','=','3')->get();
            return response()->json(['EDUCATIONAL_TEAM'=>$volunteer]);
        }
        public function FoodServiceTeam()
        {
            $volunteer=Volunteer::query()->with('user')->where('accepted','=','1')
                ->where('category_id','=','2')->get();
            return response()->json(['FOOD_SERVICE_TEAM'=>$volunteer]);
        }
        
        
        //تقديم استقالة
        public function SubmitResignation(Request $request){
            $input=$request->all();
            $input['volunteer_id'] = Auth::id();
            return response()->json(['message'=> $resignation=Resignation::query()->create($input)],200);
        }
        public function ResignationRequests()
        {
            
            return response()->json([$users = DB::table('users')
                ->join('volunteers', 'users.id', '=', 'volunteers.user_id')
                ->join('resignations', 'volunteers.id', '=', 'resignations.volunteer_id')
                -> where('resignations.accepted','=','0')->select('users.name','users.email','volunteers.gender','volunteers.job','volunteers.birth','volunteers.phone','volunteers.accepted','resignations.description')
                ->get()]);
        }
        public function Accepted_resignation_requests(Resignation $resignation){
            $resignation['accepted']=1;
            $resignation->save();
            return response()->json(['message'=>"resignaton accepted",$resignation],200);
            
        }
        public function Rejected_resignation_Requests(Resignation $resignation){
            $resignation->delete();
            return response()->json([
                'message'=>'not accepted',$resignation],200);
        }
        
        //فصل الموظف
        public function StaffDismissal(Volunteer $volunteer)
        {
            $users = DB::table('users')->join('volunteers', 'users.id', '=', 'volunteers.user_id')->where('accepted','=','1')->select('users.name')->get();
//        $user = DB::table('users')->select('user_id','users.name','users.email')->get();
//       $users= $volunteer->with('user')->where('accepted','=','1')->get();

//        $info=['name'=>$users['name'],'email'=>$users['email']];
            //$email=Admin::query()->select('email')->get();
            //  $sendmail = Mail::to($volunteer['email'])->send(new SendMail($info,$email));
            //  $volunteer->delete();
            if($users['volunteer_id']=$volunteer)
                $volunteer->delete();
                return response()->json([
                    'message'=>'you got fired',$users['volunteer_id']],200);
            
        }}
