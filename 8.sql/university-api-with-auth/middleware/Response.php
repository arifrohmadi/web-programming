<?php

class Response {
    public static function json(mixed $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function success(mixed $data, string $message = 'Success', int $statusCode = 200): void {
        self::json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ], $statusCode);
    }

    public static function error(string $message, int $statusCode = 400): void {
        self::json([
            'status'  => 'error',
            'message' => $message,
            'data'    => null,
        ], $statusCode);
    }

    public static function notFound(string $message = 'Resource not found'): void {
        self::error($message, 404);
    }

    public static function created(mixed $data, string $message = 'Resource created successfully'): void {
        self::success($data, $message, 201);
    }
}
