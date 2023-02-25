<?php

require("connexion.php");
if (!empty($_POST['name_brand']) && !empty($_POST['email'])  && !empty($_POST['instagram_account']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])) {
  $name_brand         = $_POST['name_brand'];
  $email              = $_POST['email'];
  $instagram_account  = $_POST['instagram_account'];
  $password           = $_POST['password'];
  $password_confirm   = $_POST['password_confirm'];

  if ($password != $password_confirm) {
    header('Location: join_as_a_brand.php?error=1&pass=1');
    exit();
  }
  //CHECK IF THE EMAIL IS ALREADY USED 
  $stmt = $db->prepare("SELECT count(*) AS number_email FROM brands WHERE email=?");
  $stmt->execute(array($email));
  while ($user = $stmt->fetch()) {
    if ($user['number_email'] != 0) {
      header('Location: join_as_a_brand.php?error=1&email=1');
      exit();
    }
  }

  //HASH PSSWD 
  $password = "aq1" . sha1($password . "1234") . "25";    //aq1 et 1234 25 sont des grain de sels

  //HASH 
  $secret = sha1($email) . time();
  $secret = sha1($secret) . time() . time();

  //SENT DATA
  $stmt = $db->prepare('INSERT INTO brands(name_brand, email, instagram_account, password, secret) VALUES(?,?,?,?,?)') or die(print_r($db->errorInfo()));
  $stmt->execute(array($name_brand, $email, $instagram_account, $password, $secret));

  header('location: dashboard.php?success=1');
  exit();
}


?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>join_as_a_brand</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Square+Peg&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/join_as_a_brand.css">
</head>

<body>
  <nav>
    <a href="acceuil.html">
      <h2 class="logo">PAP<span>SI</span></h2>
    </a>
  </nav>
  <div class="title">
    <h2>Sign in to PAP<span>SI</span> </h2>
  </div>
  <div class="container">
    <form method="post" action="join_as_a_brand.php">
      <div class="txt-field">
        <input class="txt-css" type="text" name="name_brand" required>
        <label>Name of the brand</label>
      </div>
      <div class="txt-field">
        <input class="txt-css" type="email" name="email" required>
        <label for=""> Email</label>
      </div>
      <div class="txt-field">
        <input class="txt-css" type="text" name="instagram_account" required>
        <label for="">Instagram account</label>
      </div>
      <div class="txt-field">
        <input class="txt-css" type="password" name="password" required>
        <label for="">Password</label>
      </div>
      <div class="txt-field">
        <input class="txt-css" type="password" name="password_confirm" required>
        <label for="">Re-enter Password</label>
      </div>
      <?php
      if (isset($_GET['error'])) {
        if (isset($_GET['pass'])) { ?>
          <div id="error">
            <p>Les mots de passe ne sont pas identiques!</p>
          </div>
        <?php
        }
        if (isset($_GET['email'])) {
        ?>
          <div id="error">
            <p>L'email deja utilises!</p>
          </div>
      <?php }
      } ?>

      <div>
        <input class="sign-in-btn" type="submit" name="" value="Sign in">
      </div>

    </form>
  </div>
</body>

</html>