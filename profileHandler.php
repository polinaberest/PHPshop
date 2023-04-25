<?php
require_once 'saveUserData.php';

if (session_id() == '')
    session_start();

if (!isset($_SESSION['usersData']))
    $_SESSION['usersData'] = require 'data/usersData.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['page'] = 'login';
    header('Location: index.php');
    return;
}

$userData = &$_SESSION['usersData'][$_SESSION['user']];

$name = $userData['name'];
$surname = $userData['surname'];
$dateOfBirth = $userData['dateOfBirth'];
$description = $userData['description'];
$pathToImage = $userData['imagePath'];

$fileFormName = 'userAvatar';

if ($_FILES[$fileFormName]['size'] === 0 && !isset($_POST['name']) && !isset($_POST['surname']) && !isset($_POST['dateOfBirth'])
    && !isset($_POST['description'])) {
    $_SESSION['page'] = 'profile';
    header('Location: index.php');
    return;
}

$newName = trim(htmlspecialchars($_POST['name']));
$newSurname = trim(htmlspecialchars($_POST['surname']));
$newDateOfBirth = htmlspecialchars($_POST['dateOfBirth']);
$newDescription = trim(htmlspecialchars($_POST['description']));
$newDescription = str_replace("'", "`", $newDescription);

$pattern = "/^(([a-zA-z])+([ -]?))+([a-zA-Z])$/";
$validationError = &$_SESSION['profileEditError'];

if (!preg_match($pattern, $newName)) {
    $validationError = "Ім'я повинно складатися лише з літер і мінімум з 2х символів.";
    $newName = $name;
} else
    $newName = nameBeautifyer($newName);

if (!preg_match($pattern, $newSurname)) {
    $validationError = "Прізвище повинно складатися лише з літер і мінімум з 2х символів.";
    $newSurname = $surname;
} else
    $newSurname = nameBeautifyer($newSurname);

if (getAge($newDateOfBirth) < 16) {
    $validationError = "Вік не може бути меншим за 16 років.";
    $newDateOfBirth = $dateOfBirth;
}

if (strlen($newDescription) < 50) {
    $validationError = "Коротка інформація повинна містити не менше 50 символів.";
    $newDescription = $description;
}


$imageName = session_id() . '_' . $_SESSION['user'] . 'Avatar';

$userData['name'] = $newName;
$userData['surname'] = $newSurname;
$userData['dateOfBirth'] = $newDateOfBirth;
$userData['description'] = $newDescription;

if ($_FILES[$fileFormName]['size'] !== 0) {
    $error = isFileCorrect($fileFormName);
    if ($error !== "") {
        $validationError = $error;
    } else {
        $oldImage = $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . "/" . $userData['imagePath'];

        if (file_exists($oldImage))
            unlink($oldImage);

        $target_dir = "images/usersAvatars/";
        if (isset($_FILES[$fileFormName]['type'])) {
            preg_match("/([a-zA-Z])+$/", $_FILES[$fileFormName]["type"], $matches);
            $imageName = $imageName . '.' . $matches[0];
            $userData['imagePath'] =
                $target_dir . $imageName;
        }
        $target_file = $target_dir . $imageName;
        move_uploaded_file($_FILES[$fileFormName]["tmp_name"],
            $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . "/" . $target_file);
    }
}

saveUserData();
header('Location: index.php');
return;

function getAge($dateOfBirth)
{
    return date_diff(date_create($dateOfBirth), date_create('now'))->y;
}

function isFileCorrect($fileFormName)
{
    if (isset($_FILES[$fileFormName]['tmp_name'])) {
        $check = getimagesize($_FILES[$fileFormName]["tmp_name"]);
        if ($check === false) {
            return "File is not an image.";
        }
    }

    $maxFileSize = 3000000;
    if ($_FILES[$fileFormName]["size"] > $maxFileSize) {
        return "Вибачте, але ваш файл занадто великий. Максимальний розмір $maxFileSize, ваш розмір "
            . $_FILES[$fileFormName]["size"] . ".";
    }
    preg_match("/([a-zA-Z])+$/", $_FILES[$fileFormName]["type"], $matches);
    $imageFileType = $matches[0];
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
    return "";
}

function nameBeautifyer($name)
{
    # Замінюємо усі дефіси на пробіли.
    $name = str_replace("-", " ", $name);

    # Разбиваємо рядок по словах.
    $nameArr = explode(" ", $name);

    $name = "";
    foreach ($nameArr as $namePart)
        $name .= strtoupper(substr($namePart, 0, 1)) . strtolower(substr($namePart, 1)) . " ";

    return trim($name);
}