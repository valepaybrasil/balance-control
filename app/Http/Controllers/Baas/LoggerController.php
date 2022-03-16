<?php

namespace App\Http\Controllers\Baas;

use App\Http\Controllers\Controller;
use App\Services\Baas\LoggerService;

use Illuminate\Http\Request;


class LoggerController extends Controller
{

    public function getLogger(Request $request)
    {
        $loggerService = new LoggerService();
        $response = $loggerService->getLogger();

        return response()->json($response, 200);
    }

    public function getLoggerDetail(Request $request, string $logger)
    {
        $loggerService = new LoggerService();
        $response = $loggerService->getLoggerDetail($logger);

        return response()->json($response, 200);
    }

    public function create(Request $request)
    {
        $loggerService = new LoggerService();
        $response = $loggerService->create($request->all());

        return response()->json($response, 200);
    }
}
