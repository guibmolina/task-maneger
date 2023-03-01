<?php

namespace App\Http\Controllers;

use App\Jobs\TaskAttachedEmailJob;
use Exception;
use Illuminate\Http\JsonResponse;
use Infra\Status\Repositories\StatusRepository;


class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        $statusRepository = new StatusRepository();

        try {
            $status = $statusRepository->allStatus();
        } catch (Exception $e) {
            return response()->json(['Server Error'], 500);
        }
        return response()->json($status);
    }

}
