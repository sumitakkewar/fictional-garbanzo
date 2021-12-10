<?php

namespace App\Http\Controllers;

use App\Models\ServiceJob;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserServiceApiController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'from_date' => ['nullable', 'date_format:d-m-Y'],
            'to_date' => ['nullable', 'date_format:d-m-Y']
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $page = isset($request->page) ? $request->page : 1;

        $jobs = null;
        if (isset($request->from_date) && isset($request->to_date)) {
            $jobs = ServiceJob::jobs($request->from_date, $request->to_date, $page);
        } else if (isset($request->from_date)) {
            $jobs = ServiceJob::jobs($request->from_date, null, $page);
        } else if (isset($request->to_date)) {
            $jobs = ServiceJob::jobs(null, $request->to_date, $page);
        } else {
            $jobs = ServiceJob::jobs(null, null, $page);
        }

        return $this->json($jobs);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function orders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_date' => ['nullable', 'date_format:d-m-Y'],
            'to_date' => ['nullable', 'date_format:d-m-Y']
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        $page = isset($request->page) ? $request->page : 1;

        $orders = null;
        if (isset($request->from_date) && isset($request->to_date)) {
            $orders = ServiceJob::orders($request->from_date, $request->to_date, $page);
        } else if (isset($request->from_date)) {
            $orders = ServiceJob::orders($request->from_date, null, $page);
        } else if (isset($request->to_date)) {
            $orders = ServiceJob::orders(null, $request->to_date, $page);
        } else {
            $orders = ServiceJob::orders(null, null, $page);
        }

        return $this->json($orders);
    }

    /**
     * @param int $jobId
     * @return Response
     */
    public function show(int $id)
    {

        $job = ServiceJob::getJobById($id);

        if ($job) {
            return $this->json($job->first());
        }

        return $this->error("Job not found!");
    }
}
