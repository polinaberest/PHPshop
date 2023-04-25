<?php
if (session_id() == '')
    session_start();

require_once 'emptyCart.php';
emptyCart();
header('location: index.php');