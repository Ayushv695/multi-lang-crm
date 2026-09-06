<?php

if (!function_exists('successResponse')) {
    function successResponse($data = null, $message = 'Success', $status = 200) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse($message = 'Something went wrong.', $status = 400, $errors = null) {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}

if (!function_exists('errorJWTTokenResponse')) {
    function errorJWTTokenResponse($message = 'Something went wrong.', $code = "", $status = 401,$data = null) {
        $response = [
            'success' => false,
            'message' => $message,
            'code' => $code,
            'data' => $data,
        ];

        return response()->json($response, $status);
    }
}

if (!function_exists('successJWTTokenResponse')) {
    function successJWTTokenResponse($message = '', $code = "", $data = null, $status = 200 ) {
        $response = [
            'success' => false,
            'message' => $message,
            'code' => $code,
            'data' => $data
        ];

        return response()->json($response, $status);
    }
}