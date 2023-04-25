<?php
require_once 'findGoodById.php';
require_once 'saveUserData.php';
if (session_id() == '')
    session_start();

if (!isset($_POST['id']))
    return;

if (!isset($_SESSION['user'])) {
    $_SESSION['page'] = '404';
    header('Location: index.php');
}

if (!isset($_SESSION['usersData']))
    $_SESSION['usersData'] = require_once 'data/usersData.php';

$currentUserData = &$_SESSION['usersData'][$_SESSION['user']];

if (!isset($currentUserData['cart'])) {
    $currentUserData['cart'] = array();
    return;
}



$goodIndex = findGoodById($currentUserData['cart'], $_POST['id']);
if ($goodIndex !== -1)
{
    unset($currentUserData['cart'][$goodIndex]);
    saveUserData();
}

