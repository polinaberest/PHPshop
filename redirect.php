<?php
if (session_id() == '')
    session_start();
$_SESSION['page'] = $_POST['page'];
?>