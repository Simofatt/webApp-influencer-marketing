<?php
session_start();
require("connexion.php");
if (empty($_SESSION['connect'])) {
  header('location: login_as_an_influencer.php');
}
if ($_SESSION['connect']) {
  $id_influencer  =  $_SESSION['id_influencer'];
}
if (!empty($_POST['montant']) && !empty($_POST['duree_contrat']) && !empty($_POST['date_expiration']) && isset($_GET['id_brand'])) {

  $montant          = $_POST['montant'];
  $duree_contat     = $_POST['duree_contrat'];
  $date_expiration  = $_POST['date_expiration'];
  $id_brand         = $_GET['id_brand'];

  $requete  = $db->prepare('INSERT INTO create_deal_influencer(id_brand, id_influencer, montant, duree_contrat, date_expiration) VALUES (?,?,?,?,?)');
  $requete->execute(array($id_brand, $id_influencer, $montant, $duree_contat, $date_expiration));
  header('location: createDeal.php?success=1');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> Create Deal </title>

  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../css/createDeal.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
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

    <?php echo '<form method="POST" action="createDeal.php?id_brand=' . $_GET['id_brand'] . '">'; ?>
    <label for="montant">Montant:</label>
    <input type="text" id="montant" name="montant"><br>

    <label for="duree_contrat">Durée du contrat (en mois):</label>
    <input type="text" id="duree_contrat" name="duree_contrat"><br>

    <label for="date_expiration">Date d'expiration du contrat:</label>
    <input type="date" id="date_expiration" name="date_expiration"><br>

    <input type="submit" value="Envoyer">
    </form>





    <style>

    </style>



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