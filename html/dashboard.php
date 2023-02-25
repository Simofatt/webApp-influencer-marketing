<?php
session_start();
require("connexion.php");
if (empty($_SESSION['connect'])) {
  header('location: login_as_an_influencer.php');
  exit;
}
if (isset($_SESSION['id_influencer'])) {
  $id_influencer  = $_SESSION['id_influencer'];
}
$requete = $db->prepare('SELECT count(*) as count, (SELECT id FROM deals ) as last_id FROM deals');
$requete->execute();
while ($result = $requete->fetch()) {
  $count = $result['count'];
  $last_id = $result['last_id'];
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <title> DASHBOARD </title>
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../css/dashboard.css" />
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
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Deals</div>
            <div class="number">40,876</div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Up from yesterday</span>
            </div>
          </div>
          <i class='bx bx-cart-alt cart'></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Brands</div>
            <div class="number">38,876</div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Up from yesterday</span>
            </div>
          </div>
          <i class='bx bxs-cart-add cart two'></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Profit</div>
            <div class="number">$12,876</div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Up from yesterday</span>
            </div>
          </div>
          <i class='bx bx-cart cart three'></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Return</div>
            <div class="number">11,086</div>
            <div class="indicator">
              <i class='bx bx-down-arrow-alt down'></i>
              <span class="text">Down From Today</span>
            </div>
          </div>
          <i class='bx bxs-cart-download cart four'></i>
        </div>
      </div>

      <div class="sales-boxes">
        <div class="recent-sales box">
          <div class="title">Recent Deals</div>
          <div class="sales-details">
            <ul class="details">
              <li class="topic">Brands</li>
              <?php
              for ($i = 1; $i <= $count; $i++) {
                $requete = $db->prepare('SELECT b.name_brand, d.id_brand, b.id FROM brands as b INNER JOIN deals as d ON b.id = d.id_brand WHERE d.id_influencer = ?');
                $requete->execute(array($id_influencer));
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
              <li class="topic">Amout</li>
              <?php
              for ($i = 1; $i <= $last_id; $i++) {
                $requete = $db->prepare('SELECT montant FROM deals WHERE id = ?');
                $requete->execute(array($i));
                while ($result = $requete->fetch()) {
                  $amount   = $result['montant'];
              ?>
                  <li><?php echo $amount; ?></li>
              <?php }
              }
              ?>



            </ul>
            <ul class="details">
              <li class="topic">Duration</li>
              <?php
              for ($i = 1; $i <= $last_id; $i++) {
                $requete = $db->prepare('SELECT duree_contrat as duration FROM deals WHERE id = ?');
                $requete->execute(array($i));
                while ($result = $requete->fetch()) {
                  $duration   = $result['duration'];
              ?>
                  <li><?php echo $duration; ?></li>
              <?php }
              }
              ?>

            </ul>

            <ul class="details">
              <li class="topic">Date expiration</li>
              <?php
              for ($i = 1; $i <= $last_id; $i++) {
                $requete = $db->prepare('SELECT date_expiration FROM deals WHERE id = ?');
                $requete->execute(array($i));
                while ($result = $requete->fetch()) {
                  $date_expiration   = $result['date_expiration'];
              ?>
                  <li><?php echo $date_expiration; ?></li>
              <?php }
              }
              ?>



            </ul>
          </div>
          <div class="button">
            <a href="seePartenariat.html">See All</a>
          </div>
        </div>
        <div class="top-sales box">
          <div class="title">Top Deals</div>
          <ul class="top-sales-details">
            <li>
              <a href="#">
                <!--<img src="images/sunglasses.jpg" alt="">-->
                <span class="product">Vuitton Sunglasses</span>
              </a>
              <span class="price">$1107</span>
            </li>
            <li>
              <a href="#">
                <!--<img src="images/jeans.jpg" alt="">-->
                <span class="product">Hourglass Jeans </span>
              </a>
              <span class="price">$1567</span>
            </li>
            <li>
              <a href="#">
                <!-- <img src="images/nike.jpg" alt="">-->
                <span class="product">Nike Sport Shoe</span>
              </a>
              <span class="price">$1234</span>
            </li>
            <li>
              <a href="#">
                <!--<img src="images/scarves.jpg" alt="">-->
                <span class="product">Hermes Silk Scarves.</span>
              </a>
              <span class="price">$2312</span>
            </li>
            <li>
              <a href="#">
                <!--<img src="images/blueBag.jpg" alt="">-->
                <span class="product">Succi Ladies Bag</span>
              </a>
              <span class="price">$1456</span>
            </li>
            <li>
              <a href="#">
                <!--<img src="images/bag.jpg" alt="">-->
                <span class="product">Gucci Womens's Bags</span>
              </a>
              <span class="price">$2345</span>
            <li>
              <a href="#">
                <!--<img src="images/addidas.jpg" alt="">-->
                <span class="product">Addidas Running Shoe</span>
              </a>
              <span class="price">$2345</span>
            </li>
            <li>
              <a href="#">
                <!--<img src="images/shirt.jpg" alt="">-->
                <span class="product">Bilack Wear's Shirt</span>
              </a>
              <span class="price">$1245</span>
            </li>
          </ul>
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