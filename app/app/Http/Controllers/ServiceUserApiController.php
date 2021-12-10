<?php

namespace App\Http\Controllers;

use App\BusinessLogic\DeregisterProvider;
use App\BusinessLogic\RegisterProvider;
use App\Constants\App;
use App\Models\Service;
use App\Models\ServiceUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceUserApiController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'serviceId' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }
        $user = $request->user();

        $serviceUser = null;
        if (!ServiceUser::where([
            'service_id' => $request->serviceId,
            'user_id' => $user->id,
            'type' => App::PROVIDER
        ])->exists()) {
            $serviceUser = (new RegisterProvider())->handle($request->serviceId);
            return $this->json($serviceUser);
        } else {
            return $this->error("already registered for service");
        }
    }
    /**
     * @param Request $request
     * @return Response
     */
    public function deregister(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'serviceId' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $serviceUser =  (new DeregisterProvider())->handle($request->serviceId);
        return $this->json($serviceUser);
    }
}
