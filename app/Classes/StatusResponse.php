<?php

namespace App\Classes;

use Response;

class StatusResponse
{
    public static function ApiCode2xx($status_code, $response = null)
    {
        $status_code = (int)$status_code;

        switch($status_code)
        {
            case 200:
                if(empty($response))
                {
                    $response = ['message' => 'OK'];
                }
                return Response::json($response, $status_code);

            case 201:
                if(empty($response))
                {
                    $response = ['message' => 'Created'];
                }
                return Response::json($response, $status_code);

            case 202:
                if(empty($response))
                {
                    $response = ['message' => 'Accepted'];
                }
                return Response::json($response, $status_code);

            case 203:
                if(empty($response))
                {
                    $response = ['message' => 'Non-Authoritative Information'];
                }
                return Response::json($response, $status_code);

            case 204:
                if(empty($response))
                {
                    $response = ['message' => 'No Content'];
                }
                return Response::json($response, $status_code);

            case 205:
                if(empty($response))
                {
                    $response = ['message' => 'Reset Content'];
                }
                return Response::json($response, $status_code);

            case 206:
                if(empty($response))
                {
                    $response = ['message' => 'Partial Content'];
                }
                return Response::json($response, $status_code);

            case 207:
                if(empty($response))
                {
                    $response = ['message' => 'Multi-Status'];
                }
                return Response::json($response, $status_code);

            case 208:
                if(empty($response))
                {
                    $response = ['message' => 'Already Reported'];
                }
                return Response::json($response, $status_code);

            case 226:
                if(empty($response))
                {
                    $response = ['message' => 'IM Used'];
                }
                return Response::json($response, $status_code);
        }
    }


    public static function ApiCode4xx($status_code, $message = null)
    {
        $status_code = (int)$status_code;

        switch($status_code)
        {
            case 400:
                if(empty($message))
                {
                    $message = ['message' => 'Bad Request'];
                }
                return Response::json($message, $status_code);

            case 401:
                if(empty($message))
                {
                    $message = ['message' => 'Unauthorized'];
                }
                return Response::json($message, $status_code);

            case 402:
                if(empty($message))
                {
                    $message = ['message' => 'Payment Required'];
                }
                return Response::json($message, $status_code);

            case 403:
                if(empty($message))
                {
                    $message = ['message' => 'Forbidden'];
                }
                return Response::json($message, $status_code);

            case 404:
                if(empty($message))
                {
                    $message = ['message' => 'Not Found'];
                }
                return Response::json($message, $status_code);

            case 405:
                if(empty($message))
                {
                    $message = ['message' => 'Method Not Allowed'];
                }
                return Response::json($message, $status_code);

            case 406:
                if(empty($message))
                {
                    $message = ['message' => 'Not Acceptable'];
                }
                return Response::json($message, $status_code);

            case 407:
                if(empty($message))
                {
                    $message = ['message' => 'Proxy Authentication Required'];
                }
                return Response::json($message, $status_code);

            case 408:
                if(empty($message))
                {
                    $message = ['message' => 'Request Timeout'];
                }
                return Response::json($message, $status_code);

            case 409:
                if(empty($message))
                {
                    $message = ['message' => 'Conflict'];
                }
                return Response::json($message, $status_code);

            case 410:
                if(empty($message))
                {
                    $message = ['message' => 'Gone'];
                }
                return Response::json($message, $status_code);

            case 411:
                if(empty($message))
                {
                    $message = ['message' => 'Length Required'];
                }
                return Response::json($message, $status_code);

            case 412:
                if(empty($message))
                {
                    $message = ['message' => 'Precondition Failed'];
                }
                return Response::json($message, $status_code);

            case 413:
                if(empty($message))
                {
                    $message = ['message' => 'Payload Too Large'];
                }
                return Response::json($message, $status_code);

            case 414:
                if(empty($message))
                {
                    $message = ['message' => 'URI Too Long'];
                }
                return Response::json($message, $status_code);

            case 415:
                if(empty($message))
                {
                    $message = ['message' => 'Unsupported Media Type'];
                }
                return Response::json($message, $status_code);

            case 416:
                if(empty($message))
                {
                    $message = ['message' => 'Range Not Satisfiable'];
                }
                return Response::json($message, $status_code);

            case 417:
                if(empty($message))
                {
                    $message = ['message' => 'Expectation Failed'];
                }
                return Response::json($message, $status_code);

            case 418:
                if(empty($message))
                {
                    $message = ['message' => "I'm a teapot"];
                }
                return Response::json($message, $status_code);

            case 421:
                if(empty($message))
                {
                    $message = ['message' => 'Misdirected Request'];
                }
                return Response::json($message, $status_code);

            case 422:
                if(empty($message))
                {
                    $message = ['message' => 'Unprocessable Entity'];
                }
                return Response::json($message, $status_code);

            case 423:
                if(empty($message))
                {
                    $message = ['message' => 'Locked'];
                }
                return Response::json($message, $status_code);

            case 424:
                if(empty($message))
                {
                    $message = ['message' => 'Failed Dependency'];
                }
                return Response::json($message, $status_code);

            case 426:
                if(empty($message))
                {
                    $message = ['message' => 'Upgrade Required'];
                }
                return Response::json($message, $status_code);

            case 428:
                if(empty($message))
                {
                    $message = ['message' => 'Precondition Required'];
                }
                return Response::json($message, $status_code);

            case 429:
                if(empty($message))
                {
                    $message = ['message' => 'Too Many Requests'];
                }
                return Response::json($message, $status_code);

            case 431:
                if(empty($message))
                {
                    $message = ['message' => 'Request Header Fields Too Large'];
                }
                return Response::json($message, $status_code);

            case 451:
                if(empty($message))
                {
                    $message = ['message' => 'Unavailable For Legal Reasons'];
                }
                return Response::json($message, $status_code);

        }
    }

    public static function ApiCode5xx($status_code, $message = null)
    {
        $status_code = (int)$status_code;

        switch($status_code)
        {
            case 500:
                if(empty($message))
                {
                    $message = ['message' => 'Bad Request'];
                }
                return Response::json($message, $status_code);

            case 501:
                if(empty($message))
                {
                    $message = ['message' => 'Unauthorized'];
                }
                return Response::json($message, $status_code);

            case 502:
                if(empty($message))
                {
                    $message = ['message' => 'Bad Gateway'];
                }
                return Response::json($message, $status_code);

            case 503:
                if(empty($message))
                {
                    $message = ['message' => 'Service Unavailable'];
                }
                return Response::json($message, $status_code);

            case 504:
                if(empty($message))
                {
                    $message = ['message' => 'Gateway Timeout'];
                }
                return Response::json($message, $status_code);

            case 505:
                if(empty($message))
                {
                    $message = ['message' => 'HTTP Version Not Supported'];
                }
                return Response::json($message, $status_code);

            case 506:
                if(empty($message))
                {
                    $message = ['message' => 'Variant Also Negotiates'];
                }
                return Response::json($message, $status_code);

            case 507:
                if(empty($message))
                {
                    $message = ['message' => 'Insufficient Storage'];
                }
                return Response::json($message, $status_code);

            case 508:
                if(empty($message))
                {
                    $message = ['message' => 'Loop Detected'];
                }
                return Response::json($message, $status_code);

            case 510:
                if(empty($message))
                {
                    $message = ['message' => 'Not Extended'];
                }
                return Response::json($message, $status_code);

            case 511:
                if(empty($message))
                {
                    $message = ['message' => 'Network Authentication Required'];
                }
                return Response::json($message, $status_code);
        }
    }

}
