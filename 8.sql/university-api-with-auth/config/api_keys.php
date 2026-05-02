<?php

/**
 * Daftar API Key yang valid.
 *
 * Format:
 *   'API_KEY_STRING' => [
 *       'name'        => 'Nama pemilik / aplikasi',
 *       'role'        => 'admin' | 'readonly',
 *       'active'      => true | false,
 *   ]
 *
 * Cara generate key baru (jalankan sekali di terminal):
 *   php -r "echo bin2hex(random_bytes(32)) . PHP_EOL;"
 */

return [
    // Admin — akses penuh (GET, POST, PUT, PATCH, DELETE)
    'a3f8c2e1b7d94056f1a2c3e4b5d60789a1b2c3d4e5f6789012345678901234ab' => [
        'name'   => 'Admin App',
        'role'   => 'admin',
        'active' => true,
    ],

    // Read-only — hanya GET
    '1b2c3d4e5f678901234567890abcdef1234567890abcdef1234567890abcdef12' => [
        'name'   => 'Read-Only Client',
        'role'   => 'readonly',
        'active' => true,
    ],
];
