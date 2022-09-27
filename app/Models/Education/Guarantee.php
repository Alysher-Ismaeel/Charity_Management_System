<?php

namespace App\Models\Education;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{

    use HasFactory;
    protected $table = "guarantees";
    protected $fillable = ['name','birth_date','academic_year','guaranteed','cost',
                            'count','image','category_id','time','exp_date'];
    public $timestamps = false;


    //---------One to Many:
    public function education(){
        return $this->belongsTo(Category::class,'category_id');
    }


    //--------------------------

    //-------Many to Many:
    public function user()
    {
        return $this->belongsToMany(User::class,'guarantee_donates','guarantee_id','user_id');
    }
}
