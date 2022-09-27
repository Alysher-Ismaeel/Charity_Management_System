<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory,HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "admins";
    protected $fillable = ['name','email','password'];
    public $timestamps = true;

    //ONE TO ONE:
    public function code()
    {
        return $this->hasOne(Code::class,'admin_id');
    }
    public function takeout(){
        return $this->hasMany(Takeout::class,'admin_id');
    }
    
    
}
