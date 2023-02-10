<?php
require("connexion.php");
if (!empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['phone_number']) && !empty($_POST['instagram_account']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])) {
  $full_name          = $_POST['full_name'];
  $email              = $_POST['email'];
  $phone_number       = $_POST['phone_number'];
  $instagram_account  = $_POST['instagram_account'];
  $password           = $_POST['password'];
  $password_confirm   = $_POST['password_confirm'];

  if ($password != $password_confirm) {
    header('Location: join_as_an_influencer.php?error=1&pass=1');
    exit();
  }


  //CHECK IF THE EMAIL IS ALREADY USED 
  $requete = $db->prepare("SELECT count(*) as number_email from influencer where  email=?  ");
  $requete->execute(array($email));

  while ($result = $requete->fetch()) {
    if ($result['number_email'] != 0) {
      header('Location: join_as_an_influencer.php?error=1&email=1');
      exit();
    }
  }

  //HASH PSSWD 
  $password = "aq1" . sha1($password . "1234") . "25";    //aq1 et 1234 25 sont des grain de sels



  //HASH 
  $secret = sha1($email) . time();
  $secret = sha1($secret) . time() . time();

  //SENT DATA
  $requete = $db->prepare('INSERT INTO influencer(full_name, email, phone_number, instagram_account, password, secret) VALUES(?,?,?,?,?,?)');
  $requete->execute(array($full_name, $email, $phone_number, $instagram_account, $password, $secret));

  header('location: dashboard.php?success=1');
  exit();
}


?>




<!DOCTYPE html>
<html lang="en" dir="ltr">
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>JOIN_AS_AN_INFLUENCER</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Square+Peg&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/join_as_an_influencer.css">
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

    <form method="post" action="join_as_an_influencer.php">
      <div class="txt-field">
        <input class="txt-css" type="text" name="full_name" required>
        <label>Full name</label>
      </div>
      <div class="txt-field">
        <input class="txt-css" type="email" name="email" required>
        <label for="">Email</label>
      </div>
      <div class="txt-field">
        <input class="txt-css" type="text" name="phone_number" required>
        <label for="">Phone number</label>
      </div>
      <div class="txt-field">
        <input class="txt-css" type="text" name="instagram_account" required>
        <label for=""> Instagram </label>
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