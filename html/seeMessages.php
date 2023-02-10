<?php
session_start();
require("connexion.php");
if (empty($_SESSION['connect'])) {
  header('location: login_as_an_influencer.php');
}

$requete = $db->prepare('SELECT count(*) as count , (SELECT id FROM message_brands ) as last_id FROM message_brands');
$requete->execute();
while ($result = $requete->fetch()) {
  $count = $result['count'];
  $nbre_messages = $result['last_id'];
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> SEE MESSAGES </title>
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="..\css\sentMessage.css" />
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


    <div class="home-content">
      <div class="sales-boxes">
        <div class="recent-sales box">
          <div class="title">Communicate with a Brand</div>
          <div class="sales-details">

            <ul class="details">
              <li class="topic">Brands</li>
              <?php
              for ($i = 1; $i <= $count; $i++) {
                $requete = $db->prepare('SELECT b.name_brand, m.id_brand, b.id FROM brands as b INNER JOIN message_brands as m ON b.id = m.id_brand');
                $requete->execute();
                while ($result = $requete->fetch()) {
                  $name_brand  = $result['name_brand'];
              ?>
                  <li><?php echo $name_brand; ?> </li>
              <?php
                }
              }
              ?>

            </ul>
            <ul class="details">
              <li class="topic">Object of the message</li>
              <?php
              for ($i = 1; $i <= $nbre_messages; $i++) {
                $requete = $db->prepare('SELECT subject FROM message_brands WHERE id = ?');
                $requete->execute(array($i));
                while ($result = $requete->fetch()) {
                  $subject   = $result['subject'];
              ?>
                  <li><?php echo $subject; ?></li>
              <?php }
              }
              ?>
            </ul>
            <ul class="details">
              <li class="topic">Action</li>
              <?php
              for ($i = 1; $i <= $nbre_messages; $i++) {
                $requete = $db->prepare('SELECT id_brand FROM message_brands WHERE id = ?');
                $requete->execute(array($i));
                while ($result = $requete->fetch()) {
                  $id_brand   = $result['id_brand'];

                  echo '<li><a href="msg.php?id_brand=' . $id_brand . '">Reply</a></li>';
                }
              }
              ?>

            </ul>
          </div>

        </div>

      </div>
    </div>
  </section>

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