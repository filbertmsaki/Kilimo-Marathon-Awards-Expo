<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{


    public function handleResponse($msg, $code)
    {
        $res = [
            'success' => true,
            'message' => $msg,
        ];
        if (!empty($result)) {
            $res['data'] = $result;
        }
        return response()->json($res, $code);
    }

    public function handleError($error, $code)
    {

        $res = [
            'success' => false,
            'message' => $error,
        ];
        return response()->json($res, $code);
    }
}
