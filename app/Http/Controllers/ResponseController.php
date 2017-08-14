<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public static $error_codes = [
        'OK' => '200',
        'CREATED' => '201',
        'BAD REQUEST' => '400',
        'UNAUTHORIZED' => '401',
        'NOT FOUD' => '404',
    ];

    public static $response = [
        'errors' => false,
        'success' => false,
        'messagess' => [],
        'data' => []
    ];

    public static function response($status){
        return response()->json(['response', self::$response], $status);
    }
}
