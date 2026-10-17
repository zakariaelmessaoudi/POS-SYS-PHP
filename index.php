<?php
require_once __DIR__ . '/core/bootstrap.php';
if (Auth::check()) Helper::redirect('modules/dashboard/index.php');
Helper::redirect('login.php');
