<?php
if (session_id() == '')
    session_start();

if (isset($_SESSION['receiptFilename'])) {
    $filename = $_SESSION['receiptFilename'];
    if (file_exists($filename))
        unlink($filename);
}

require_once 'emptyCart.php';
require_once "findGoodById.php";
//mb_internal_encoding("UTF-8");

$userData = $_SESSION['usersData'][$_SESSION['user']];
$name = $userData['name'];
$_SESSION['receiptFilename'] = $_SESSION['user'] . "Receipt-" . date("d-m-Y--H.i.s") . '.txt';
$_SESSION['receipt'] = createReceipt($userData['cart']);
emptyCart();

$_SESSION['page'] = 'successful-purchases';

header("location: index.php");


function createReceipt($cart)
{
    if (session_id() == '')
        session_start();

    if (!isset($_SESSION['goods']))
        $_SESSION['goods'] = require_once 'data/goods.php';
    
    $newLine = "\r\n";
    
    $goods = $_SESSION['goods'];

    $result = "";
    $numOfDividers = 40;
    $resultSum = '0';

    $result .= printDividers($numOfDividers);
    $result .= "Goods in the receipt" . $newLine;
    $result .= "ID | Good | Price | Amount | Sum" . $newLine;
    $id = 0;
    foreach ($cart as $item) {
        $idxInGoods = findGoodById($goods, $item['id']);
        if ($idxInGoods !== -1)
            $item['price'] = $goods[$idxInGoods]['price'];

        if (!is_string($item['price']))
            $item['price'] = sprintf("%.2f", $item['price']);
        if (!is_string($item['count']))
            $item['count'] = sprintf("%d", $item['count']);

        $sum = bcmul($item['count'], $item['price'], 2);
        $resultSum = bcadd($resultSum, $sum, 2);
        $id++;
        $result .= $id . " " . $item['name'] . " " .
            $item['price'] . " " . $item['count'] . " " . $sum . $newLine;
    }

    $result .= "Total: " . $resultSum . $newLine;
    $result .= "Thanks for chosing Appol Production. U`r welcome!" . $newLine;

    $result .= printDividers($numOfDividers);

    return $result;
}

function printDividers($numOfDividers)
{
    $newLine = "\r\n";

    $dividers = "";
    for ($i = 1; $i <= $numOfDividers; $i++)
        $dividers .= "-";
    $dividers .= $newLine;
    return $dividers;
}