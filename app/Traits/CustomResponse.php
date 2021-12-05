<?php
namespace App\Traits;
use App\Models\Activity;
use carbon\carbon;
use Illuminate\Http\Response;

trait CustomResponse {

    protected function successResponse($message = null, $code = 200)
    {
        return response()->json([
            'status'=> 'Success',
            'message' => $message
        ], $code);
    }

    protected function successResponseData($message = null, $data, $code = 200)
    {
        return response()->json([
            'status'=> 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message = null, $code)
    {
        return response()->json([
            'status'=>'Error',
            'message' => $message
        ], $code);
    }

    protected function errorResponseData($message = null, $data = null, $code)
    {
        return response()->json([
            'status'=>'Error',
            'message' => $message,
            'data' => $data
        ], $code);
    }



    public function HttpOk($error, $msg)
    {
        return response()->json([
            'error' => $error,
            'msg' => $msg,
        ])->setStatusCode(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK]);
    }

    public function HttpOkWithData($error, $msg, $data)
    {
        return response()->json([
            'error' => $error,
            'msg' => $msg,
            'data' => $data,
        ])->setStatusCode(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK]);
    }

    public function HttpBadRequest($error, $msg)
    {
        return response()->json([
            'error' => $error,
            'msg' => $msg,
        ])->setStatusCode(Response::HTTP_BAD_REQUEST, Response::$statusTexts[Response::HTTP_BAD_REQUEST]);
    }

    public function HttpCreated($error, $msg)
    {
        return response()->json([
            'error' => $error,
            'msg' => $msg,
        ])->setStatusCode(Response::HTTP_CREATED, Response::$statusTexts[Response::HTTP_CREATED]);
    }


}
