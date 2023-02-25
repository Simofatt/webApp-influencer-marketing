<?php
session_start();
if (isset($_SESSION['connect'])) {
  header('location: dashboard.php?succes=1');
  exit;
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Square+Peg&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/login.css">
</head>

<body>
  <nav>
    <a href="acceuil.html">
      <h2 class="logo">PAP<span>SI</span></h2>
    </a>
  </nav>

  <div class="title">
    <h2>Log in to PAP<span>SI</span></h2>
  </div>

  <div class="container">

    <a href="login_as_a_brand.php"><input type="button" id="brand" value="BRAND"> </a>
    <a href="login_as_an_influencer.php"><input type="button" class="influencer" value="INFLUENCER"></a>



  </div>

</body>

</html>