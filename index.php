<?php
//echo session_id();
if (session_id() == ''){
    session_start();
}

if (!isset($_SESSION['page']))
    $_SESSION['page'] = isset($_SESSION['user']) ? 'shop' : 'login';

if (!isset($_SESSION['goods']))
    $_SESSION['goods'] = require_once 'data/goods.php';

unset($_SESSION['usersData']);
if (!isset($_SESSION['usersData']))
    $_SESSION['usersData'] = require_once 'data/usersData.php';

?>

<!DOCTYPE html>
<html>

<head>
    <title>AppolShop</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <?php include 'header.php'; ?>
    <main style="margin:2rem; margin-left:4rem">

        <?php
        $isUserAuthorized = isset($_SESSION['user']);
        switch ($_SESSION['page']) {
            case 'home' :
            case 'goods':
            case 'shop':
                if ($isUserAuthorized)
                    require_once "shop.php";
                else
                    require_once "page404.php";
                    break;
                case 'login':
                    if ($isUserAuthorized) {
                    $_SESSION['page'] = 'profile';
                        header('Location: index.php');
                        return;
                    } else
                        require_once 'login.php';
                        break;
                case 'profile':
                    if ($isUserAuthorized)
                        require_once 'profile.php';
                    else
                        require_once "page404.php";
                        break;
                case 'cart':
                    if ($isUserAuthorized)
                        require_once 'cart.php';
                    else
                        require_once 'page404.php';
                        break;
                case 'successful-purchases':
                    require_once 'successful_purchases.php';
                    break;
                case '404':
                    require_once 'page404.php';
                    break;
        }
        ?>
        
    </main>
    <?php include 'footer.php'; ?>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</html>