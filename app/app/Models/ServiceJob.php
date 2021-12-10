<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceJob extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_user_id',
        'user_id',
        'scheduled_time',
        'desc',
        'latitude',
        'longitude',
        'address',
        'job_status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'service_user_id' => 'integer',
        'user_id' => 'integer',
        'scheduled_time' => 'timestamp',
    ];


    public function serviceUser()
    {
        return $this->belongsTo(\App\Models\ServiceUser::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public static function jobs($fromDate = null, $toDate = null, $pageNumber = 1)
    {
        $query = DB::table('service_jobs as j')
            ->join('users as applicant', 'applicant.id', '=', 'j.user_id')
            ->join('service_user as su', 'su.id', '=', 'j.service_user_id')
            ->join('services as s', 's.id', '=', 'su.service_id')
            ->join('users as provider', 'provider.id', '=', 'su.user_id')
            ->where('su.user_id', '=', Auth::user()->id)
            ->select([
                'j.*',
                'applicant.name as applicant_name',
                'applicant.id as applicant_id',
                's.name as service_name',
                'provider.name as provider_name',
                'provider.id as provider_id'
            ]);

        if ($fromDate) {
            $query->where('j.scheduled_time', '>=', Carbon::parse($fromDate)->format('Y-m-d'));
        }

        if ($toDate) {
            $query->where('j.scheduled_time', '<=', Carbon::parse($toDate)->format('Y-m-d'));
        }

        return $query->paginate(10, ['*'], 'page', $pageNumber);
    }

    public static function orders($fromDate = null, $toDate = null, $pageNumber = 1)
    {
        $query = DB::table('service_jobs as j')
            ->join('users as applicant', 'applicant.id', '=', 'j.user_id')
            ->join('service_user as su', 'su.id', '=', 'j.service_user_id')
            ->join('services as s', 's.id', '=', 'su.service_id')
            ->join('users as provider', 'provider.id', '=', 'su.user_id')
            ->where('j.user_id', '=', Auth::user()->id)
            ->select([
                'j.*',
                'applicant.name as applicant_name',
                'applicant.id as applicant_id',
                's.name as service_name',
                'provider.name as provider_name',
                'provider.id as provider_id'
            ]);

        if ($fromDate) {
            $query->where('j.scheduled_time', '>=', Carbon::parse($fromDate)->format('Y-m-d'));
        }

        if ($toDate) {
            $query->where('j.scheduled_time', '<=', Carbon::parse($toDate)->format('Y-m-d'));
        }

        return $query->paginate(10, ['*'], 'page', $pageNumber);
    }

    public static function getJobById($jobId)
    {
        return DB::table('service_jobs as j')
            ->join('users as applicant', 'applicant.id', '=', 'j.user_id')
            ->join('service_user as su', 'su.id', '=', 'j.service_user_id')
            ->join('services as s', 's.id', '=', 'su.service_id')
            ->join('users as provider', 'provider.id', '=', 'su.user_id')
            ->where('su.user_id', '=', Auth::user()->id)
            ->where('j.id', '=', $jobId)
            ->select([
                'j.*',
                'applicant.name as applicant_name',
                'applicant.id as applicant_id',
                's.name as service_name',
                'provider.name as provider_name',
                'provider.id as provider_id'
            ])
            ->get();
    }

    public static function getJobByIdWithNoUser($jobId)
    {
        return DB::table('service_jobs as j')
            ->join('users as applicant', 'applicant.id', '=', 'j.user_id')
            ->join('service_user as su', 'su.id', '=', 'j.service_user_id')
            ->join('services as s', 's.id', '=', 'su.service_id')
            ->join('users as provider', 'provider.id', '=', 'su.user_id')
            ->where('j.id', '=', $jobId)
            ->select([
                'j.*',
                'applicant.name as applicant_name',
                'applicant.id as applicant_id',
                's.name as service_name',
                'provider.name as provider_name',
                'provider.id as provider_id'
            ])
            ->get();
    }
}
