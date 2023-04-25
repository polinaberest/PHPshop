<?php

if (session_id() == '')
    session_start();

if (!isset($_SESSION['receiptFilename']) || !isset($_SESSION['receipt']))
    return;
$filename = $_SESSION['receiptFilename'];
$receipt = $_SESSION['receipt'];

file_put_contents($filename, $receipt);
header('Content-Disposition: attachment; filename="'. basename($filename) . '";');
readfile($filename);


