<?php
    
    namespace App\Models\Health;
    
    use App\Models\Category;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    
    class MedicalTool extends Model
    {
        use HasFactory;
        
        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $table = "medical_tools";
        protected $fillable = ['name','cost','count','image','category_id','donate'];
        public $timestamps = false;
        
        
        //---------One to Many:
        public function category(){
            return $this->belongsTo(Category::class,'category_id');
            
        }
        
        
        //------
        
        //-----Many to Many:
        public function user()
        {
            return $this->belongsToMany(User::class, 'medical_tools_donates', 'medical_tool_id', 'user_id');
            
        }
        
    }
