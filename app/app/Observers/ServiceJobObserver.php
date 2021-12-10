<?php

namespace App\Observers;

use App\Models\ServiceJob;
use App\Models\User;
use App\Notifications\JobBookingProvider;
use App\Notifications\JobBookingUser;

class ServiceJobObserver
{
    /**
     * Handle the Job "created" event.
     *
     * @param  \App\Models\ServiceJob  $job
     * @return void
     */
    public function created(ServiceJob $job)
    {
        if (env('MAIL_FROM_ADDRESS')) {
            $jobDetails = ServiceJob::getJobByIdWithNoUser($job->id)->first();

            if($jobDetails){
                $provider = User::where('id', $jobDetails->provider_id)->get()->first();
                $applicant = User::where('id', $jobDetails->applicant_id)->get()->first();
    
                $applicant->notify(new JobBookingUser($jobDetails));
                $provider->notify(new JobBookingProvider($jobDetails));
            }
        }
    }

    /**
     * Handle the Job "updated" event.
     *
     * @param  \App\Models\ServiceJob  $job
     * @return void
     */
    public function updated(ServiceJob $job)
    {
        //
    }

    /**
     * Handle the Job "deleted" event.
     *
     * @param  \App\Models\ServiceJob  $job
     * @return void
     */
    public function deleted(ServiceJob $job)
    {
        //
    }

    /**
     * Handle the Job "restored" event.
     *
     * @param  \App\Models\ServiceJob  $job
     * @return void
     */
    public function restored(ServiceJob $job)
    {
        //
    }

    /**
     * Handle the Job "force deleted" event.
     *
     * @param  \App\Models\ServiceJob  $job
     * @return void
     */
    public function forceDeleted(ServiceJob $job)
    {
        //
    }
}
