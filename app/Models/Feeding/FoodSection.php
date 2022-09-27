<?php

namespace App\Models\Feeding;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodSection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "food_sections";
    protected $fillable = ['name', 'cost','count', 'image','donate','category_id'];
    public $timestamps = false;


    //-------One to Many:
    public function feeding(){
        return $this->belongsTo(Category::class,'category_id');
    }
    //------

    //-----Many to Many:
    public function user()
    {
        return $this->belongsToMany(User::class,'food_section_donates','food_section_id','user_id');

    }

}
