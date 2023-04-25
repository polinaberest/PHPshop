<?php

function saveUserData() {
    $serializedData = "<?php return '" . serialize($_SESSION['usersData']) . "';";
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . "/" . '/data/serializedUsersData.php', $serializedData);
}