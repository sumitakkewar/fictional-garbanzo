<?php

namespace App\BusinessLogic;

use App\Constants\App;
use App\Models\ServiceUser;
use Illuminate\Support\Facades\Auth;

class DeregisterProvider
{

    private $type = App::PROVIDER;

    public function withType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function handle($serviceId)
    {
        return ServiceUser::where(['service_id' => $serviceId, 'user_id' => Auth::user()->id, 'type' => $this->type])->delete();
    }
}
