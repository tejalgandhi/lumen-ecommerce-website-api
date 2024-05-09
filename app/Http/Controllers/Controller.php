<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    public function response($message,$content=[],$statusCode=200){
        return response()->json(['message'=>$message,'data'=>$content], $statusCode);
    }
}
