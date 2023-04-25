<?php

if (session_id() == '')
    session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['page'] = '404';
    header('Location: index.php');
}

unset($_SESSION['user']);
$_SESSION['page'] = 'login';
