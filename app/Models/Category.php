<?php

namespace App\Models;

use App\Models\Education\Guarantee;
use App\Models\Education\Stationery;
use App\Models\Feeding\FoodParcel;
use App\Models\Feeding\FoodSection;
use App\Models\Feeding\KitchenSet;
use App\Models\Health\MedicalTool;
use App\Models\Health\Medicine;
use App\Models\Health\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = ['name'];
    public $timestamps = false;


    //__________________________________Education_______________________________________
    public function stationery(){
        return $this->hasMany(Stationery::class,'category_id');
    }

    public function guarantee(){
        return $this->hasMany(Guarantee::class,'category_id');
    }
    //___________________________________Feeding______________________________________
    public function foodsection(){
        return $this->hasMany(FoodSection::class,'category_id');
    }

    public function foodparcel(){
        return $this->hasMany(FoodParcel::class,'category_id');
    }

    public function kitchenset(){
        return $this->hasMany(KitchenSet::class,'category_id');
    }
    //_____________________________________Health____________________________________
    public function patient(){
        return $this->hasMany(Patient::class,'category_id');
    }

    public function medicine(){
        return $this->hasMany(Medicine::class,'category_id');
    }

    public function medicaltool(){
        return $this->hasMany(MedicalTool::class,'category_id');
    }

    //---------------------VOLUNTEER-------------------------------------------
    public function volunteer(){
        return $this->hasMany(Volunteer::class,'category_id');
    }
    //_________________________________________________________________________
    public function user(){
        return $this->belongsToMany('App\Models\User' , 'users');
    }
}
