<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
    use HasFactory;
    protected $table = "resignations";
    protected $fillable = ['volunteer_id','description','accepted'];
    protected $hidden = ['created_at','updated_at'];
    public $timestamps = false;

    //--------One to One:
    public function volunteer()
    {
        return $this->belongsTo(Resignation::class, 'volunteer_id');
    }
}
