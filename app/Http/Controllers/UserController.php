<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Admin;
    use App\Models\Code;
    use App\Models\User;
    use App\Models\Wallet;
    use App\Notifications\EmailNotification;
    use Illuminate\Auth\Events\Registered;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Notification;
    use Illuminate\Support\Facades\Validator;
    
    
    class UserController extends Controller
    {
        
        //------User Auth (sign up,log in,log out):
        
        public function register(Request $request)
        {
            $input = $request->all();
            
            $validator = Validator::make($input, [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
                'phone' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => 'validator error'], 400);
            }
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            
            $money = new Wallet();
            $money->user_id = $user->id;
            $money->money = 0;

//        $money->update(['money'=>$money['money']+$input['money']]);//but the update new in variables or brackets
            $money->save();
            $token = $user->createToken('ABC')->plainTextToken;
            $user->markEmailAsVerified();
            event(new Registered($user));
            return response()->json([
                'token' => $token,
                'message' => 'User sign up Successfully!'], 200);
        }
        
        //---
        public function login(Request $request)
        {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $token = $user->createToken('ABC')->plainTextToken;
                return response()->json(
                    [
                        'name' => $user['name'],
                        
                        'token' => $token,
                        'message' => 'user login successfully'
                    ], 200);
            } else {
                return response()->json(['message' => 'Unauthorised'], 401);
            }
            
            
        }
        
        //---
        public function logout(Request $request)
        {
            $request->user()->currentAccessToken()->delete();
            
            return response()->json(['message' => "you have logout successfully"], 200);
        }
        
        //---
        
        public function send()
        {
            //try {
            //$input = $request->all();
            $token = 'dr5G-byLT0uiQ_X_cnVdat:APA91bFjJzWnLFotYzah0dmAbVfMge2eJRNLTWLOkupfDE7MkZeHygFT-iYEY04GY_oF-va7d9OgApAXnNrrQHjS6QUjN_RN3fz81Zv15IiJrOfju3qzsSP9lOMrMtu-ranC27eA48ec';
            
            $SERVER_API_KEY = 'AAAAD-78T2w:APA91bEP0gpC3s8hBEYMNI7a4UQvYOOon2nuUKOgJ4L8IROvEX6SLwlilRmR8JTNa20J-G5TlAjRp6Zu2ZHeHMB7RNBNg6r0eJ_QRte2peo6RLgt7NuAYQduqH_QNBEOpy17iyCJ4e9Q';
            // payload data, it will vary according to requirement
            $data = [
                "registration_ids" => [
                    $token
                ], // for multiple device ids
                "notification" => [
                    "title" => 'IT',
                    "body" => 'hi',
                    "sound" => "default"
                
                ]
            ];
            $dataString = json_encode($data);
            
            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json'
            ];
            
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            $response = curl_exec($ch);
            //   curl_close($ch);
            dd($response);
            
        }
        
        
        public function random_code(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'email' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => "validator error"
                ], 400);
            }
            $admin = Admin::query()->get()->first();
            if ($request->email == $admin->email) {
                $customer = ['name' => $admin['name']];
                $code = random_int(0000, 9999);
                Notification::send($admin, new EmailNotification($customer, $code));
                $Random = Code::query()->where('admin_id', $admin['id'])->get();
                foreach ($Random as $random) {
                    if ($random->admin_id == $admin['id']) {
                        $random->update(['code' => $code]);
                        return \response()->json(['message' => 'updated code sent successfully', $code]);
                    }
                }
                $random = new Code();
                $random->admin_id = $admin['id'];
                $random->code = $code;
                $random->save();
                return \response()->json([
                    'message' => 'new code sent successfully', $code]);
            }
            $users = User::query()->get();
//                foreach ($users as $user) {
            if ($user = User::query()->where('email', $request->email)->get()->first()) {
                $customer = ['name' => $user->name];
                $code = random_int(0000, 9999);
                Notification::send($user, new EmailNotification($customer, $code));
                $Random = Code::query()->where('user_id', $user->id)->get();
                foreach ($Random as $random) {
                    if ($random->user_id == $user->id) {
                        $random->update(['code' => $code]);
                        
                        return \response()->json([
                            'message' => 'updated code sent successfully', $code]);
                    }
                }
                $random = new Code();
                $random->user_id = $user->id;
                $random->code = $code;
                $random->save();
                return \response()->json([
                    'message' => 'new code sent successfully', $request['email'], $code]);
            }
            
            return response()->json(['wrong email' => $request->email]);
        }
        
        public function check_code(Request $request)
        {
            //تتحقق من صحة الكود
            $input = $request->all();
            if ($admin = Admin::query()->where('email', $input['email'])->get()->first()) {
                $code = Code::query()->where('admin_id', $admin['id'])->get()->first();
                $input = $request->all();
                if ($input['code'] == $code->code) {
                    return \response()->json([
                        'message' => 'ADMIN RIGHT CODE!', $code['admin_id'], $admin], 200);
                }
                return \response()->json([
                    'message' => 'ADMIN WRONG CODE!', $code['admin_id'], $input['code'], $admin], 401);
            } else {
                $user = User::query()->where('email', $input['email'])->get()->first();
                $code = Code::query()->where('user_id', $user['id'])->get()->first();
                if ($input['code'] == $code->code) {
                    return \response()->json([
                        'message' => 'True', $code['user_id'], $user], 200);
                }
                return \response()->json([
                    'message' => 'False', $code['user_id'], $input['code'], $user], 401);
                
                
            }
            
        }
        
        public function reset_password(Request $request)
        {
            $input = $request->all();
            if ($admin = Admin::query()->where('email', $input['email'])->get()->first()) {
                
                $admin->update(['password' => bcrypt($input['password'])]);
                return \response()->json([
                    'message' => 'PASSWORD RESET SUCCESSFULLY!'], 200);
                
            }
            $user = User::query()->where('email', $input['email'])->get()->first();
            
            $user->update(['password' => bcrypt($input['password'])]);
            return \response()->json([
                'message' => 'PASSWORD RESET SUCCESSFULLY!'], 200);
            
        }
        
    }
    
    
    
    //-----------------------------------------------------------------------


