<?php
session_start();
require("connexion.php");
if ($_SESSION['connect']) {
  $id_influencer = $_SESSION['id_influencer'];
} else if (!$_SESSION['connect']) {
  header('location: login_as_an_influencer.php');
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <title>profile</title>
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus'></i>
      <span class="logo_name">PAPSI</span>
    </div>

    <ul class="nav-links">
      <li>
        <a href="dashboard.php" class="active">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="acceuil.html">
          <i class='bx bx-box'></i>
          <span class="links_name">Home</span>
        </a>
      </li>
      <li>
        <a href="profile.php">
          <i class='bx bx-list-ul'></i>
          <span class="links_name">Profil</span>
        </a>
      </li>

      <li>
        <a href="seeMessages.php">
          <i class='bx bx-coin-stack'></i>
          <span class="links_name">Messages</span>
        </a>
      </li>
      <li>
        <a href="sentMessage.php">
          <i class='bx bx-book-alt'></i>
          <span class="links_name">Sent a message</span>
        </a>
      </li>
      <li>
        <a href="seePartenariat.php">
          <i class='bx bx-book-alt'></i>
          <span class="links_name">Mes partenariats</span>
        </a>
      </li>
      <li>
        <a href="createPartenariat.php">
          <i class='bx bx-heart'></i>
          <span class="links_name">Creer une partenariat</span>
        </a>
      </li>
      <li>
        <a href="profileSettings.php">
          <i class='bx bx-cog'></i>
          <span class="links_name">Setting</span>
        </a>
      </li>
      <li class="log_out">
        <a href="log_out.php">
          <i class='bx bx-log-out'></i>
          <span class="links_name">Log out</span>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Dashboard</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search'></i>
      </div>
      <div class="profile-details">
        <a href="profile.php"> <span class="admin_name">Mohamed Fatehi</span> </a>
        <img src="../images/img4.png" alt="Simo" style="width:100%">
      </div>
    </nav>

    <div class="card">
      <?php
      $requete = $db->prepare('SELECT full_name, email, phone_number, instagram_account FROM influencer  where id =?');
      $requete->execute(array($id_influencer));
      while ($result = $requete->fetch()) {
        $full_name          = $_SESSION['full_name'];
        $email              = $_SESSION['email'];
        $phone_number       = $_SESSION['phone_number'];
        $instagram_account  = $_SESSION['instagram_account'];

        echo '<img src="../images/img4.png" alt="John" style="width:100%">  ';
        echo '<h1>' . $full_name . '</h1>';
        echo '<p class="title">' . $email . '</p>';
        echo '<p>' . $phone_number . '</p>';
        echo '<a href="wwww.instagram.com/' . $instagram_account . '/"><i class="fa fa-instagram"></i></a>';
      }
      ?>
      <a href="profileSettings.php">
        <p><button>Modify</button></p>
      </a>
    </div>


    <script>
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function() {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else
          sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      }
    </script>
</body>

</html>