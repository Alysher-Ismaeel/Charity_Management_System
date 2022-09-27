<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Code;
    use App\Models\User;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller as BaseController;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\URL;
    
    class Controller extends BaseController
    {
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        public function saveimage($image,$file): string
        {
            $newimage= time().$image->getClientOriginalName();
            
            
            $image->move(public_path($file), $newimage);
            return URL::to("$file")."/".$newimage;
            
            
        }
        
        
    }
