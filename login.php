<?php
session_start();

$msg = '';
if(isset($_POST['username']) && isset($_POST['password'])) {
    if($_POST['username'] == 'admin' && $_POST['password'] == 'admin123') {
        $_SESSION['user'] = 'admin';
        header('Location: index.php');
    } else { $msg = 'Username/Password incorrect.'; }
}
else {
    if(isset($_SESSION['user'])) header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP File Browser</title>

    <!-- Styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

  </head>
<body class="text-center">


<div class="container w-50 mt-5">

  <!-- Login -->
  <form action="login.php" method="post">
      <h1 class="h3 mb-3">Please sign in</h1>
      <div class="alert-danger"><?= $msg; ?></div>
      
      <input type="text" name="username" class="form-control" placeholder="admin" value="admin" required>
      <input type="text" name="password" class="form-control" placeholder="admin123" value="admin123" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in <i class="fa fa-sign-in-alt"></i></button>

      <p class="mt-5 mb-3 text-muted">PHP-File-Browser</p>
  </form>

</div>

<!-- JavaScript -->
<script src="https://kit.fontawesome.com/686684acdc.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="javascript.js"></script>

</body>
</html>