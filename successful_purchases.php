<h1 class="table-label" align="center">The purchase is successful!<br/>Come again, you are welcome!</h1>
<form method="post" action="giveReceipt.php" class="pay-block">
    <input type="submit" value="Get receipt!">
</form>
<h2>Go to
    <span class="link"
          onclick="onclickMenu(this.dataset.page)"
          data-page="goods"
          style="font-size: 1.2em;text-decoration: none;border-bottom: 1px solid darkgrey;"> to the shopping assortment
        </span>
</h2>
<?php $_SESSION['page'] = 'home' ?>