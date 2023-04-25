<?php
    if (session_id() == '')
        session_start();

    $id = $_POST['id'];
    $count = $_POST['count'];
    $currentUserData = &$_SESSION['usersData'][$_SESSION['user']];

    echo 'OK';

    foreach ($currentUserData['cart'] as &$item) {
        if ($item['id'] == $id) {
            echo 'OK';
            $item['count'] = $count;
            break;
        }
    }

echo 'OK';