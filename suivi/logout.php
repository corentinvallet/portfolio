<?php
require __DIR__ . '/../../suivi/lib/auth.php';
start_session();
$_SESSION = [];
session_destroy();
header('Location: /login.php');
exit;