<?php
    
    namespace App\Models\Education;
    
    use App\Models\Category;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    
    class Stationery extends Model
    {
        use HasFactory;
        
        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $table = "stationeries";
        protected $fillable = ['name','cost','count','image','content','size','category_id','donate'];
        public $timestamps = false;
        
        
        //---------One to Many:
        public function category(){
            return $this->belongsTo(Category::class,'category_id');
        }
        
        
        //--------------------------
        
        //-------Many to Many:
        public function user()
        {
            return $this->belongsToMany(User::class,'stationery_donates','stationery_id','user_id');
            
        }
        
    }
