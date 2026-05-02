<?php

class AuthMiddleware {
    private static array $keys = [];

    /** Muat API key dari config dan validasi request masuk. */
    public static function handle(): void {
        self::$keys = require __DIR__ . '/../config/api_keys.php';

        $key = self::extractKey();

        if ($key === null) {
            Response::error(
                'API key missing. Provide it via header: X-API-Key or Authorization: Bearer <key>',
                401
            );
        }

        if (!array_key_exists($key, self::$keys)) {
            Response::error('Invalid API key.', 401);
        }

        $client = self::$keys[$key];

        if (!$client['active']) {
            Response::error('This API key has been deactivated.', 403);
        }

        // Readonly hanya boleh GET
        if ($client['role'] === 'readonly' && $_SERVER['REQUEST_METHOD'] !== 'GET') {
            Response::error(
                "Your API key '{$client['name']}' only has read-only access.",
                403
            );
        }

        // Simpan info client ke superglobal agar bisa diakses controller jika perlu
        $_SERVER['API_CLIENT_NAME'] = $client['name'];
        $_SERVER['API_CLIENT_ROLE'] = $client['role'];
    }

    /** Ambil key dari header X-API-Key atau Authorization: Bearer <token>. */
    private static function extractKey(): ?string {
        $headers = self::getHeaders();

        // Prioritas 1: X-API-Key header
        if (!empty($headers['X-Api-Key'])) {
            return trim($headers['X-Api-Key']);
        }

        // Prioritas 2: Authorization: Bearer <token>
        if (!empty($headers['Authorization'])) {
            $parts = explode(' ', $headers['Authorization'], 2);
            if (strtolower($parts[0]) === 'bearer' && !empty($parts[1])) {
                return trim($parts[1]);
            }
        }

        return null;
    }

    /** Ambil semua header secara cross-platform (Apache & nginx). */
    private static function getHeaders(): array {
        if (function_exists('getallheaders')) {
            return getallheaders();
        }

        // Fallback untuk nginx
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (str_starts_with($name, 'HTTP_')) {
                $key           = str_replace('_', '-', ucwords(strtolower(substr($name, 5)), '_'));
                $headers[$key] = $value;
            }
        }
        return $headers;
    }
}
