<?php

namespace App\Http\Traits;

Trait sendMessage
{
    // This response function send the data if request has been successful
    public function sendResponse($result, $message)
    {
        $response = [
            'status' => true,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    // This response function send a success message if the request has been successful
    public function sendMessageResponse($message)
    {
        $response = [
            'status' => true,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    // This response function send an error or more message if the request has been failed
    public function sendError($error, $errorMessage = [], $code = 500)
    {
        $response = [
            'status' => false,
            'message' => $error,
        ];

        if(!empty($errorMessage))
            $response['message'] = $errorMessage;

        return response()->json($response, $code);
    }
}
