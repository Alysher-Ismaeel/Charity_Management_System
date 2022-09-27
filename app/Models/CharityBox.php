<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharityBox extends Model
{
    use HasFactory;
    protected $table = "charity_boxes";
    protected $fillable = ['money','charity_box_id','password'];
    public $timestamps = false;
    public $hidden = ['password'];
    public function donate(){
        return $this->hasMany(Donate::class);
    }
    public function takeout(){
        return $this->hasMany(Takeout::class);
    }
}
