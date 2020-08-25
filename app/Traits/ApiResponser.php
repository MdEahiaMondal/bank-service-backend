<?php


namespace App\Traits;


trait ApiResponser
{
    protected function successResponse($data, $code = 200){
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code){
        return response()->json([
            'success' => false,
            'message' => $message
        ], $code);
    }

}
