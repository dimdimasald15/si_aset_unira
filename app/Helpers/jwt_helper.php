<?php

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

if (!function_exists('generateJWT')) {
    function generateJWT($payload)
    {
        $key = getenv('JWT_SECRET_KEY');
        return JWT::encode($payload, $key, 'HS256');
    }
}
if (!function_exists('decodeJWT')) {
    function decodeJWT($token)
    {
        $key = getenv('JWT_SECRET_KEY');
        try {
            return JWT::decode($token, new Key($key, 'HS256'));
        } catch (Exception $e) {
            return false;
        }
    }
}
