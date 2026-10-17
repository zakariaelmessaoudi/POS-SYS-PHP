<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/database.php';
session_name('elfirdaous_session');
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once APP_ROOT . '/core/Database.php';
require_once APP_ROOT . '/core/Helper.php';
require_once APP_ROOT . '/core/Csrf.php';
require_once APP_ROOT . '/core/Auth.php';
