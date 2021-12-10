<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function json($data, $status = 200){
        return response()->json([
            "data" => $data
        ], $status);
    }

    public function error($data, $status = 400){
        return response()->json([
            "error" => $data
        ], $status);
    }

}
