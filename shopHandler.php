<?php
require_once 'findGoodById.php';
require_once 'saveUserData.php';

if (session_id() == '')
    session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['page'] = 'login';
    header('Location: index.php');
    return;
}

if (!isset($_SESSION['usersData'])){
    $_SESSION['usersData'] = require_once 'data/usersData.php';
    
}

if (!isset($_SESSION['goods'])){
    //$_SESSION['goods'] = require_once 'data/goods.php';
    $_SESSION['goods'] = json_decode(file_get_contents("data\goods.json"), true);
}

$currentUserData = &$_SESSION['usersData'][$_SESSION['user']];
if (!isset($currentUserData['cart']))
    $currentUserData['cart'] = array();

$cart = &$currentUserData['cart'];
$goods = $_SESSION['goods'];


foreach ($goods as $item) {
    if (isset($_POST[$item['id']])) {
        $numOfGoods = trim(htmlspecialchars($_POST[$item['id']]));
        if ($numOfGoods === "")
            $numOfGoods = 0;
        if (!preg_match("/^^[0-9]+$/", $numOfGoods) || $numOfGoods < 0) {
            $_SESSION['buyGoodError'] = "The amount is wrong for " . '"' .
                $item['name'] . '". ' . "The amount of good should be a positive integer value";
            header('Location: index.php');
            return;
        }
    }
}

foreach ($goods as $item)
    if (isset($_POST[$item['id']])) {
        addGoodAmount($cart, $item, $_POST[$item['id']]);
        asort($cart);

    }

saveUserData();
$_SESSION['page'] = 'cart';
header('Location: index.php');
return;


function addGoodAmount(&$cart, $good, $amount)
{
    if ($amount <= 0)
        return false;

    if (!is_string($amount))
        $amount = sprintf("%d", $cart[$good]['count']);

    $goodIndexInCart = findGoodById($cart, $good['id']);
    if ($goodIndexInCart === -1) {
        $cart[] = $good;
        $cart[findGoodById($cart, $good['id'])]['count'] = $amount;
        return true;
    }

    if (!is_string($cart[$goodIndexInCart]['count']))
        $cart[$goodIndexInCart]['count'] = sprintf("%d", $cart[$goodIndexInCart]['count']);


    $cart[$goodIndexInCart]['count'] = bcadd($cart[$goodIndexInCart]['count'], $amount);
    return true;
}