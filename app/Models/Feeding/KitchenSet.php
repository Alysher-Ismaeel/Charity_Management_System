<?php
    
    namespace App\Models\Feeding;
    
    use App\Models\Category;
    use App\Models\Feeding\Feeding;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    
    class KitchenSet extends Model
    {
        use HasFactory;
        
        
        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $table = "kitchen_sets";
        protected $fillable = ['name', 'cost','count', 'image','category_id','donate'];
        public $timestamps = false;
        
        //-------One to Many:
        public function category(){
            return $this->belongsTo(Category::class,'category_id');
        }
        
        
        //------
        
        //-----Many to Many:
        public function user()
        {
            return $this->belongsToMany(User::class, 'kitchen_set_donates', 'kitchen_set_id', 'user_id');
            
        }
    }
