<?php
require_once __DIR__ . '/core/bootstrap.php';
if (Auth::check()) Helper::redirect('modules/dashboard/index.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::verify(isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '');
    if (Auth::login(trim($_POST['username']), $_POST['password'])) Helper::redirect('modules/dashboard/index.php');
    $error = 'اسم المستخدم أو كلمة المرور غير صحيحة.';
}
?><!doctype html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>تسجيل الدخول - <?= Helper::e(APP_NAME) ?></title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet"><link href="assets/css/app.css" rel="stylesheet"></head><body class="login-page"><main class="login-card"><div class="brand-mark">☕</div><h1><?= Helper::e(APP_NAME) ?></h1><p class="muted">نظام إدارة المقهى</p><?php if ($error): ?><div class="alert alert-danger"><?= Helper::e($error) ?></div><?php endif; ?><form method="post"><?= Helper::csrfField() ?><div class="mb-3"><label class="form-label">اسم المستخدم</label><input class="form-control" name="username" required autofocus autocomplete="username"></div><div class="mb-4"><label class="form-label">كلمة المرور</label><input class="form-control" type="password" name="password" required autocomplete="current-password"></div><button class="btn btn-coffee w-100">دخول للنظام</button></form><small class="d-block mt-4 muted">للتثبيت الأولي: admin / password</small></main></body></html>
