<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;
    protected $table = "volunteers";
    protected $fillable = ['category_id','user_id','birth','gender','phone','job','accepted','identity','certificate'];
    protected $hidden = ['created_at','updated_at'];
    public $timestamps = false;


    //--------One to One:
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function resignation()
    {
        return $this->hasOne(Resignation::class,'volunteer_id');
    }


    //---------One to Many:
    public function category(){
        return $this->belongsTo(Category::class,'category_id');

    }



}
