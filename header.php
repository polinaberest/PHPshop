<?php $isUserAuthorized = isset($_SESSION['user']);?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid" style="margin-left:60px; margin-right:100px">
    <a class="navbar-brand" href="#">&#128293; Appol Production &#128293;</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item" onclick="onclickMenu(this.dataset.page)" data-page="goods">
          <a class="nav-link" aria-current="#" href="#">Assortment</a>
        </li>

        <?php
            if ($isUserAuthorized) {
                echo '<li class="nav-item" onclick="onclickMenu(this.dataset.page)" data-page="profile"><a class="nav-link" href="#">Account</a></li>';
                echo '<li class="nav-item" onclick="logout()"><a class="nav-link" href="#">Log out</a></li>';
            }
            else
                echo '<li class="nav-item" onclick="onclickMenu(this.dataset.page)" data-page="login"><a class="nav-link" href="#">Login</a></li>';
        ?>
        <li class="nav-item">
          <a class="nav-link" href="#"></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"></a>
        </li>
      </ul>

      <?php if ($isUserAuthorized) : ?>
        <span onclick="onclickMenu(this.dataset.page)" data-page="cart">
        <!-- <a class="nav-link" href="index.php?page=cart">&#128722; Cart</a> -->
          <a class="nav-link" href="#" >&#128722; Cart</a>
        </span>
      <?php endif; ?>

    </div>
  </div>
  </nav>
