<?php

namespace App\Http\Helpers;

class ResponseHelper
{

    /**
     * Response for Created resource
     */
    public static function created($data, $message = 'Resource created successfully')
    {
        return response()->json([
            'meta_data' => [
                'success' => true,
                'message' => $message,
                'status_code' => 201
            ],
            'data' => $data
        ], 201);
    }
    /**
     * Success response
     */
    public static function success($data = null, $message = 'Request was successful', $statusCode = 200)
    {
        return response()->json([
            'meta_data' => [
                'success' => true,
                'message' => $message,
                'status_code' => $statusCode
            ],
            'data' => $data
        ], $statusCode);
    }

     /**
     * Success response with pagination
     */
    public static function successWithPagination($data, $pagination, $message = 'Data retrieved successfully', $statusCode = 200)
    {
        return response()->json([
            'meta_data' => [
                'success' => true,
                'message' => $message,
                'status_code' => $statusCode,
                'pagination' => [
                    'total_count' => $pagination->total(),
                    'limit' => $pagination->perPage(),
                    'current_page' => $pagination->currentPage(),
                    'total_pages' => $pagination->lastPage(),
                    'next_page_url' => $pagination->nextPageUrl(),
                    'prev_page_url' => $pagination->previousPageUrl(),
                ]
            ],
            'data' => $data
        ], $statusCode);
    }

      /**
     * Response for Resource Not Found
     */
    public static function notFound($message = 'Resource not found')
    {
        return response()->json([
            'meta_data' => [
                'success' => true,
                'message' => $message,
                'status_code' => 404
            ],
            'data' => null
        ], 404);
    }

    /**
     * Error response
     */
    public static function error($message, $statusCode = 400, $errors = [])
    {
        return response()->json([
            'meta_data' => [
                'success' => false,
                'message' => $message,
                'status_code' => $statusCode,
                'errors' => $errors
            ],
            'data' => null
        ], $statusCode);
    }

      /**
     * Unauthorized access response (401)
     */
    public static function unauthorized($message = 'Unauthorized access')
    {
        return response()->json([
            'meta_data' => [
                'success' => false,
                'message' => $message,
                'status_code' => 401
            ],
            'data' => null
        ], 401);
    }

    /**
     * Forbidden access response (403)
     */
    public static function forbidden($message = 'Access forbidden')
    {
        return response()->json([
            'meta_data' => [
                'success' => false,
                'message' => $message,
                'status_code' => 403
            ],
            'data' => null
        ], 403);
    }

 

   
}
