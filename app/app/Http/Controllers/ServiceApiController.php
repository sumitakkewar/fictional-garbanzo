<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServiceApiController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()){
            $services = Service::where([ 'status' => 'active' ])->get();
            return $this->json(ServiceResource::collection($services));
        }
        
    }

     /**
      * @param Service $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        if(Auth::user() && $service){
            return $this->json(new ServiceResource($service));
        }

        return $this->error("No service found!");
        
    }

}
