<?php

namespace App\Observers;

use App\Constants\App;
use App\Models\ServiceUser;
use App\Models\User;
use App\Notifications\NewProvider;
use App\Notifications\NewSubscriber;

class ServiceUserObserver
{
    /**
     * Handle the ServiceUser "created" event.
     *
     * @param  \App\Models\ServiceUser  $serviceUser
     * @return void
     */
    public function created(ServiceUser $serviceUser)
    {
        if (env('MAIL_FROM_ADDRESS')) {
            if ($serviceUser->type == App::PROVIDER) {
                $subscribers = User::whereIn('id', ServiceUser::where([
                    'type' => App::SUBSCRIBER,
                    'service_id' => $serviceUser->service_id
                ])->select('user_id')->get()->toArray())->get();

                $providerDetails = User::where(['id' => $serviceUser->user_id])->get()->first();

                foreach ($subscribers as $subscriber) {
                    $subscriber->notify(new NewProvider($providerDetails));
                }
            } else {
                $providers = User::whereIn('id', ServiceUser::where([
                    'type' => App::PROVIDER,
                    'service_id' => $serviceUser->service_id
                ])->select('user_id')->get()->toArray())->get();

                $subscriberDetails = User::where(['id' => $serviceUser->user_id])->get()->first();

                foreach ($providers as $provider) {
                    $provider->notify(new NewSubscriber($subscriberDetails));
                }
            }
        }
    }

    /**
     * Handle the ServiceUser "updated" event.
     *
     * @param  \App\Models\ServiceUser  $serviceUser
     * @return void
     */
    public function updated(ServiceUser $serviceUser)
    {
        //
    }

    /**
     * Handle the ServiceUser "deleted" event.
     *
     * @param  \App\Models\ServiceUser  $serviceUser
     * @return void
     */
    public function deleted(ServiceUser $serviceUser)
    {
        //
    }

    /**
     * Handle the ServiceUser "restored" event.
     *
     * @param  \App\Models\ServiceUser  $serviceUser
     * @return void
     */
    public function restored(ServiceUser $serviceUser)
    {
        //
    }

    /**
     * Handle the ServiceUser "force deleted" event.
     *
     * @param  \App\Models\ServiceUser  $serviceUser
     * @return void
     */
    public function forceDeleted(ServiceUser $serviceUser)
    {
        //
    }
}
