<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donate extends Model
{
    use HasFactory;
    protected $table = "donates";
    protected $fillable = ['amount','user_id','charity_box_id'];
    public $timestamps = false;
    
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function charity_box(){
        return $this->belongsTo(CharityBox::class,'charity_box_id');
    }
    
}
