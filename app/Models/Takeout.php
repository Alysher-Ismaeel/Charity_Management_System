<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Takeout extends Model
{
    use HasFactory;
    protected $table = "takeouts";
    protected $fillable = ['amount','reason','admin_id','charity_box_id'];
    public $timestamps = false;
    
    
    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id');
    }
    public function charity_box(){
        return $this->belongsTo(CharityBox::class,'charity_box_id');
    }
}
