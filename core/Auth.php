<?php
class Auth
{
    public static function user() { return isset($_SESSION['user']) ? $_SESSION['user'] : null; }
    public static function check() { return self::user() !== null; }
    public static function requireLogin() { if (!self::check()) Helper::redirect('login.php'); }
    public static function requireAdmin() { self::requireLogin(); if (self::user()['role'] !== 'admin') { http_response_code(403); exit('ليس لديك صلاحية للوصول إلى هذه الصفحة.'); } }
    public static function login($username, $password)
    {
        $stmt = Database::getInstance()->query('SELECT id, username, password, full_name, role FROM users WHERE username = ? AND active = 1 LIMIT 1', array($username));
        $user = $stmt->fetch();
        if (!$user || !password_verify($password, $user['password'])) return false;
        session_regenerate_id(true); unset($user['password']); $_SESSION['user'] = $user; return true;
    }
    public static function logout() { unset($_SESSION['user']); session_regenerate_id(true); }
}
