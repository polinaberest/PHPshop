<?php
function emptyCart()
{
    require_once 'saveUserData.php';

    if (session_id() == '')
        session_start();

    if (!isset($_SESSION['usersData'][$_SESSION['user']]))
        return;

    $currentUserData = &$_SESSION['usersData'][$_SESSION['user']];
    $currentUserData['cart'] = array();
    saveUserData();
}