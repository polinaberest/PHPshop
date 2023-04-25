<?php
if (session_id() == '')
    session_start();

if (!isset($_SESSION['goods']))
    //$_SESSION['goods'] = require_once 'data/goods.php';
    $_SESSION['goods'] = json_decode(file_get_contents("data\goods.json"), true);
?>


<!-- Тіло сторінки -->

<div class="table-wrapper">
    <?php
        if (isset($_SESSION['buyGoodError'])) {
            echo '<h1 class="error-message">' . $_SESSION['buyGoodError'] . '</h1>';
            unset($_SESSION['buyGoodError']);
        }
    ?>
    <h2 class="table-label">Assortment</h2>
    <form method="post" action="shopHandler.php">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>ID</td>
                <td>Photo</td>
                <td>Good</td>
                <td>Description</td>
                <td>Amount</td>
                <td>Price (UAH)</td>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($_SESSION['goods'] as $item): ?>
                <tr>
                    <th><?php echo $item['id'] ?></td>
                    <th><img src="<?php echo $item['imageSrc']; ?>" width="300" height="300"></td>
                    <th><?php echo $item['name'] ?></td>
                    <td><?php echo $item['description'] ?></td>
                    <td>
                      <input type="number" name="<?php echo $item['id'] ?>" min="0" max="<?php echo $item['quantity']; ?>" value="0">
                    </td>
                    <th><?php echo $item['price']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="d-grid gap-2 col-6 mx-auto">
         <input class="btn btn-outline-success btn-lg btn-block" type="submit" style="margin-left: 20%; margin-right:20%;" value="Add to cart">
        </div>
    </form>
</div>
<div style="padding: 2rem;">
</div>