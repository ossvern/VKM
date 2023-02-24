<?php



if ($_POST['user'] == $a_login and $_POST['password'] == $a_pass) {
  $_SESSION['admin'] = $a_pass;
  echo "<Script>window.location.href = '$url/';</Script>";
}
?>
<div class="container">
    <form name="form" id="form" class="form-horizontal" enctype="multipart/form-data" method="POST">
        <input id="user" type="text" class="form-control" name="user" value="" placeholder="User">
        <input id="password" type="password" class="form-control" name="password"
               placeholder="Password">
        <input name="add" type="submit" value="Log in">
    </form>
</div>