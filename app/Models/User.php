<?php

namespace App\Models;

use App\Models\Education\Stationery;
use App\Models\Feeding\FoodParcel;
use App\Models\Feeding\FoodSection;
use App\Models\Feeding\KitchenSet;
use App\Models\Health\MedicalTool;
use App\Models\Health\Medicine;
use App\Models\Health\Patient;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at'

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    //---------One to One:
    public function wallet()
    {
        return $this->hasOne(Wallet::class,'user_id');
    }
    public function code()
    {
        return $this->hasOne(Code::class,'user_id');
    }

    public function volunteer()
    {
        return $this->hasOne(Volunteer::class,'user_id');
    }
    //--------------------------------------------

    //-------Many to Many:
    //Education:
    public function stationery(){
        return $this->belongsToMany(Stationery::class,'stationery_donate','user_id','stationery_id');

    }
//Feeding:
    public function foodparcel(){
        return $this->belongsToMany(FoodParcel::class,'user_foodparcel','user_id','foodparcel_id');

    }

    public function foodsection(){
        return $this->belongsToMany(FoodSection::class,'user_foodsection','user_id','foodsection_id');

    }

    public function kitchenset()
    {
        return $this->belongsToMany(KitchenSet::class, 'user_kitchenset', 'user_id', 'kitchenset_id');
    }
 //Health:
    public function patient()
    {
        return $this->belongsToMany(Patient::class, 'patient_donates', 'user_id', 'patient_id');
    }

    public function medicine()
    {
        return $this->belongsToMany(Medicine::class, 'user_medicine', 'user_id', 'medicine_id');
    }

    public function medicaltool()
    {
        return $this->belongsToMany(MedicalTool::class, 'medical_tools_donates', 'user_id', 'medicaltool_id');
    }
    
    public function donate(){
        return $this->hasMany(Donate::class,'user_id');
    }

}
