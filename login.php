<?php
if (isset($_SESSION['loginError'])) {
    echo '<h1 class="error-message">' . $_SESSION['loginError'] . '</h1>';
    unset($_SESSION['loginError']);
}
?>
<div id="login" style="margin-right:25%; margin-left:25%">
    <div style="text-align: center;">
        <img src="images/puth.png" width="600" height="200"></br>
        <h2 id="header">Please, log in to proceed</h2>
    </div>
    <br>
    
    <form method="post" action="loginHandler.php">
    
        <input type="text" placeholder="User name" id="username" class="form-control form-control"
               name="username" pattern="\w{2,}" required="required"
               onblur="this.value = this.value.trim();"><br/>
        <input type="password" class="form-control" name="password" placeholder="Password" required="required"><br/>
        <input class = "btn btn-primary" type="submit" value="Log in" id="button" style="margin-right:40%; margin-left:45%">
    </form>
</div>
<div style="margin-bottom:7rem;">
    
</div>
<!--<form method="post" action="index.php" class="login-form">-->
<!--    <input type="text" name="username" placeholder="Enter your login"-->
<!--    pattern="\w{3,}"  required="required">-->
<!--    <input type="password" name="password" placeholder="Enter your password" required="required">-->
<!--    <input type="submit" value="Sign In">-->
<!--</form>-->
