<?php

namespace App\Http\Controllers;

use App\Contracts\Service;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        return view('index');
    }

    /**
     * Send Message
     *
     * @param Service $service
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function sendMessage(Service $service, Request $request)
    {
        $result = $service->sendMessage($request->all());
        return response($result['data'], $result['status']);
    }

    /**
     * Undocumented function
     *
     * @param Service $service
     * @return \Illuminate\Http\Response
     */
    public function getAllMessages(Service $service)
    {
        $result = $service->getAllMessages();
        return response()->json($result['data'], $result['status']);
    }

    public function serverSentEvent(Service $service)
    {
        $result = $service->getEventStream();
        return response()
                ->stream(
                    $result['event'], 
                    $result['status'], 
                    $result['headers']
                );
    }
}