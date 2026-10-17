<?php
class Csrf
{
    public static function token()
    {
        if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }
    public static function verify($token)
    {
        if (empty($_SESSION['csrf_token']) || !is_string($token) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403); exit('طلب غير صالح (CSRF).');
        }
    }
}
