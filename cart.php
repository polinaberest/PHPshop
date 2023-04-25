<?php
require_once 'findGoodById.php';

if (session_id() == '')
    session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['page'] = '404';
    header('Location: index.php');
}

if (!isset($_SESSION['usersData']))
    $_SESSION['usersData'] = require_once 'data/usersData.php';

if (!isset($_SESSION['goods']))
    $_SESSION['goods'] = require_once 'data/goods.php';

$goods = $_SESSION['goods'];

$currentUserData = &$_SESSION['usersData'][$_SESSION['user']];
if (!isset($currentUserData['cart']))
    $currentUserData['cart'] = array();

$resultSum = '0';
?>
<?php if (!empty($currentUserData['cart'])) : ?>
<div class="table-wrapper">
    <h1 class="table-label">Your cart contains:</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>ID</td>
                <td>Good name</td>
                <td>Amount</td>
                <td>Price (UAH)</td>
                <td>Total (UAH)</td>
                <td>Delete product</td>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($currentUserData['cart'] as &$item): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['name'] ?></td>
                <td>
                    <?php
                    $idxInGoods = findGoodById($goods, $item['id']);
                    // if (!is_string($item['count']))
                    //     $item['count'] = sprintf("%d", $item['count']);

                    // echo $item['count'];
                    
                    ?>
                    <input type="number" min="1" max="<?php echo $goods[$idxInGoods]['quantity']; ?>"
                    value="<?php echo $item['count'] ?>"
                    onchange="updateCart(this, <?php echo $item['id'] ?>);">
                </td>
                <td>
                    <?php
                    $idxInGoods = findGoodById($goods, $item['id']);

                    if ($idxInGoods !== -1)
                        $item['price'] = $goods[$idxInGoods]['price'];

                    if (!is_string($item['price']))
                        $item['price'] = sprintf("%.2f", $item['price']);

                    echo $item['price'];
                    ?>
                </td>

                <td class="break-all sum">
                    <?php
                    $sum = bcmul($item['count'], $item['price'], 2);
                    $resultSum = bcadd($resultSum, $sum, 2);
                    echo $sum;
                    ?>
                </td>
                <td>
                    <button onclick="deleteGoodById(this, true);"
                            data-id="<?php echo $item['id'] ?>">&#10060;</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div id="result-sum-block">Total: <strong> <span id="result-sum"><?php echo $resultSum; ?></span></strong></div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end" style="margin-right:45%;">
        <form method="post" action="resetCart.php" class="pay-block">
            <input class="btn btn-danger btn-lg" type="submit" value="Clear cart">
        </form>
        <form method="post" action="pay.php" class="pay-block">
            <input type="text" name="isPayConfirm" value="true" hidden="hidden">
            <input class="btn btn-success btn-lg" type="submit" value="Pay!" >
        </form>


        
    </div>


</div>
<?php else: ?>
    <h1 class="table-label">Your cart is currently empty!</h1><br>
    <h2>Please go to the
        <span class="link"
              onclick="onclickMenu(this.dataset.page)"
              data-page="goods"
              style="font-size: 1.2em;text-decoration: none;border-bottom: 1px solid darkgrey;"> assortment page </span></h2>
<?php endif; ?>

<script>
            function updateCart(input, id) {
                let newCount = input.value;
                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Обновляем страницу, чтобы отобразить изменения
                        window.location.reload();
                    }
                }
                xhr.open('POST', 'update_cart.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send('id=' + id + '&count=' + newCount);
            }
</script>