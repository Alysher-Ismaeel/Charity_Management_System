<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isNull;

class WalletController extends Controller
{
    
    public function charge_wallet(Request $request){
        $money=Wallet::query()->where('user_id',Auth::id())->first();//try but first, get &find does not work
        $new_charge= $money['money']+$request['money'];
        $money->update(['money'=>$new_charge]);
        return response()->json(['message' => 'wallet charged successfully','wallet'=>$money['money']],200);
        
    }
//______________________________________________________________________________________________________________________
    public function show_wallet()//show wallet info
    {
        $wallet = Wallet::query()->where('user_id' , Auth::id())->first();
        return response()->json(['wallet' => $wallet['money']]);
    }
}
