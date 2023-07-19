<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const HTTP_OK = 0;
    const HTTP_AUTH_ERROR = 1001;
    const HTTP_AUTH_BLOCK = 1002;
    const HTTP_AUTH_PHONE_ERROR = 1003;

    const HTTP_REQUEST_ERROR = 4001;

    public static function validateErrorResponse(Validator $validator) {
        return response()->json([
            'code' => self::HTTP_REQUEST_ERROR,
            'msg' => $validator->messages()->first(),
        ]);
    }

    public static function okResponse($data = null, $msg = "OK")
    {
        return response()
            ->json([
                'code' => self::HTTP_OK,
                'data' => $data,
                'msg' => $msg
            ]);
    }
}
