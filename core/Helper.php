<?php
class Helper
{
    public static function e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
    public static function money($amount) { return number_format((float)$amount, 2) . ' ' . APP_CURRENCY; }
    public static function redirect($path) { header('Location: ' . APP_URL . '/' . ltrim($path, '/')); exit; }
    public static function flash($message, $type) { $_SESSION['flash'] = array('message' => $message, 'type' => $type); }
    public static function takeFlash() { $flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null; unset($_SESSION['flash']); return $flash; }
    public static function csrfField() { return '<input type="hidden" name="csrf_token" value="' . self::e(Csrf::token()) . '">'; }
}
