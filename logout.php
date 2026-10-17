<?php
require_once __DIR__ . '/core/bootstrap.php';
Auth::logout();
Helper::redirect('login.php');
