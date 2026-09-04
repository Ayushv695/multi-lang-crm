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