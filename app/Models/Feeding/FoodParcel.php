<?php

namespace App\Models\Feeding;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodParcel extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "food_parcels";
    protected $fillable = ['size','cost','content','donate','category_id','count'];
    public $timestamps = false;

    //-------One to Many:
    public function feeding(){
        return $this->belongsTo(Category::class,'category_id');
    }

    //------

    //-----Many to Many:
    public function user()
    {
        return $this->belongsToMany(User::class, 'food_parcel_donates', 'food_parcel_id', 'user_id');
    }
}
