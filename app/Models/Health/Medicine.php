<?php

namespace App\Models\Health;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "medicines";
    protected $fillable = ['name','cost','count','image','donate','category_id'];
    public $timestamps = false;

    //---------One to Many:
    public function health(){
        return $this->belongsTo(Category::class,'category_id');

    }


    //------

    //-----Many to Many:
    public function user()
    {
        return $this->belongsToMany(User::class, 'medicine_donates', 'medicine_id', 'user_id');

    }


}
