<?php

namespace App\Models\Health;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "patients";
    protected $fillable =  ['name', 'birth_date','donate',
                            'medical_condition','cost',
                            'gender','image','description','category_id'];
    
    public $timestamps = false;

    //---------One to Many:
    public function category(){
        return $this->belongsTo(Category::class,'category_id');

    }


    //------

    //-----Many to Many:
    public function user()
    {
        return $this->belongsToMany(User::class, 'patient_donates', 'patient_id', 'user_id');

    }

}
