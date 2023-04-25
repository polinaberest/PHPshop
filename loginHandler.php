<?php
if (session_id() == '')
    session_start();

loginHandler();
header('Location: index.php');
return;

function loginHandler()
{
    if (!isset($_POST['username']) || !isset($_POST['password']))
        return;

    $_SESSION['users'] = require_once 'data/users.php';

    $users = $_SESSION['users'];
    $loginUsername = trim(htmlspecialchars($_POST['username']));
    $loginPassword = trim(htmlspecialchars($_POST['password']));
    foreach ($users as $username => $password) {
        if ($username == $loginUsername) {
            if ($password == $loginPassword) {
                $_SESSION['user'] = $loginUsername;
                $_SESSION['loginDate'] = date("d-m-Y H:i:s");
                $_SESSION['page'] = 'goods';
            } else {
                $_SESSION['loginError'] = "Невірний пароль.";
                $_SESSION['page'] = 'login';
            }
            return;
        }
    }


    $_SESSION['loginError'] = "Користувача з такими данними не існує.";
    $_SESSION['page'] = 'login';
}