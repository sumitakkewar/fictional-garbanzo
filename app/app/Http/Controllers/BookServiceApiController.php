<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceJobResource;
use App\Models\ServiceJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class BookServiceApiController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function book(Request $request){

        $validator = FacadesValidator::make($request->all(), [
            'service_user_id' => ['required'],
            'scheduled_time' => ['required', 'date_format:d-m-Y'],
            'desc' => ['required'],
            'address' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required']
        ]);
   
        if($validator->fails()){
            return $this->error($validator->errors());       
        }

        $scheduledTime = Carbon::parse($request->scheduled_time);

        if(Carbon::now() < $scheduledTime){

            $jobItemExists = ServiceJob::where([
                'service_user_id' => $request->service_user_id,
                'user_id' => $request->user()->id,
                'scheduled_time' => $scheduledTime
            ])->exists();

            $jobItem = null;

            if(!$jobItemExists){
                $input = $request->all();
                $input['user_id'] = $request->user()->id;
                $input['scheduled_time'] = $scheduledTime->format('Y-m-d H:i:s');
                $jobItem = ServiceJob::create($input);
            }

            if($jobItem){
                return $this->json(new ServiceJobResource($jobItem));
            } else {
                return $this->error("Sorry you cannot book same Job same day again!");
            }
        } else {
            return $this->error("Scheduled time can not be in past");
        }

    }
}
