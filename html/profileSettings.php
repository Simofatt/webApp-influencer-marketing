<?php
session_start();
require("connexion.php");

if ($_SESSION['connect']) {
  $id_influencer      = $_SESSION['id_influencer'];
  $full_name          = $_SESSION['full_name'];
  $email              = $_SESSION['email'];
  $phone_number       = $_SESSION['phone_number'];
  $instagram_account  = $_SESSION['instagram_account'];
} else if (!isset($_SESSION['connect'])) {
  header('location: login_as_an_influencer.php');
}
$requete  = $db->prepare('SELECT password FROM influencer where id = ?');
$requete->execute(array($id_influencer));
while ($result = $requete->fetch()) {
  $password  = $result['password'];
}

if (!empty($_POST['submit'])) {
  if (!empty($_POST['full_name'])) {
    $full_name          = $_POST['full_name'];
    $requete = $db->prepare('UPDATE influencer SET full_name = ? WHERE id = ?');
    $requete->execute(array($full_name, $id_influencer));
  }
  if (!empty($_POST['email'])) {
    $email              = $_POST['email'];
    $stmt = $db->prepare("SELECT count(*) as number_email from influencer where  email=?  ");
    $stmt->execute(array($email));

    while ($result = $stmt->fetch()) {
      if ($result['number_email'] != 0) {
        header('Location: login_as_an_influencer.php?error=1');
        exit();
      } else {
        $requete = $db->prepare('UPDATE influencer SET email = ? WHERE id = ?');
        $requete->execute(array($email, $id_influencer));
      }
    }
  }
  if (!empty($_POST['phone_number'])) {
    $phone_number       = $_POST['phone_number'];
    $requete = $db->prepare('UPDATE influencer SET phone_number = ? WHERE id = ?');
    $requete->execute(array($phone_number, $id_influencer));
  }
  if (!empty($_POST['instagram_account'])) {
    $instagram_account    =   $_POST['instagram_account'];
    $requete = $db->prepare('UPDATE influencer SET instagram_account = ? WHERE id = ?');
    $requete->execute(array($instagram_account, $id_influencer));
  }
  if (!empty($_POST['password'])) {
    $password           = "aq1" . sha1($password . "1234") . "25";
    $requete = $db->prepare('UPDATE influencer SET password = ? WHERE id = ?');
    $requete->execute(array($password, $id_influencer));
  }



  $_SESSION['full_name'] = $full_name;
  $_SESSION['email'] = $email;
  $_SESSION['phone_number'] = $phone_number;
  $_SESSION['instagram_account'] = $instagram_account;


  header('location: profileSettings.php?success=1');
  exit();
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/settings.css" />
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <title>Settings</title>
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

    <form class="form" method="post" action="profileSettings.php">
      <div class="txt-field">
        <label for="firstName">Full name</label>
        <input class="txt-css" type="text" id="firstName" name="full_name" placeholder="<?php echo  $full_name; ?>">
      </div>
      <div class="txt-field">
        <label for="email">Email</label>
        <input class="txt-css" type="email" id="email" name="email" placeholder=" <?php echo $email; ?>">
      </div>
      <div class="txt-field">
        <label for="phoneNumber">Phone number</label>
        <input class="txt-css" type="text" id="phoneNumber" name="phone_number" placeholder=" <?php echo  $phone_number; ?>">
      </div>
      <div class="txt-field">
        <label for="instagramAccount">Instagram account</label>
        <input class="txt-css" type="text" id="instagramAccount" name="instagram_account" placeholder="<?php echo $instagram_account; ?>">
        <div class="txt-field">
          <label for="password">Modify Password</label>
          <input class="txt-css" type="password" id="password" name="password" placeholder="**********">
        </div>
      </div>
      <div class="txt-field">
        <label for="file">Sélectionnez une image :</label>
        <input class="txt" type="file" id="file" name="file" accept="image/*">
      </div>
      <?php
      if (isset($_GET['error'])) { ?>
        <div>
          <p>Email Existe deja!</p>
        </div>
      <?php
      }
      ?>
      <div>
        <input type="submit" name="submit" value="Enregistrer">
      </div>
    </form>

    <script>
      function uploadImage() {
        var file = document.getElementById("file").files[0];
        var preview = document.getElementById("preview");
        var form = new FormData();
        form.append("file", file);

        // Envoyer la requête pour télécharger l'image sur le serveur
        // Utilisez XMLHttpRequest ou Fetch API ici
        // ...

        // Afficher l'image téléchargée dans la section de prévisualisation
        var img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        preview.appendChild(img);

        // Afficher le bouton "Mettre à jour" pour permettre à l'utilisateur de remplacer l'image
        document.getElementsByTagName("input")[1].style.display = "inline-block";
      }

      function updateImage() {
        var file = document.getElementById("file").files[0];
        var preview = document.getElementById("preview");
        var form = new FormData();
        form.append("file", file);

        // Envoyer la requête pour mettre à jour l'image sur le serveur
        // Utilisez XMLHttpRequest ou Fetch API ici
        // ...

        // Remplacer l'image existante dans la section de prévisualisation
        preview.innerHTML = "";
        var img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        preview.appendChild(img);
      }

      function saveProfile() {
        var firstName = document.getElementById("firstName").value;
        var lastName = document.getElementById("lastName").value;
        var email = document.getElementById("email").value;
        var phoneNumber = document.getElementById("phoneNumber").value;
        var instagramAccount = document.getElementById("instagramAccount").value;
        var file = document.getElementById("file").files[0];
        var formData = new FormData();
        formData.append("firstName", firstName);
        formData.append("lastName", lastName);
        formData.append("email", email);
        formData.append("phoneNumber", phoneNumber);
        formData.append("instagramAccount", instagramAccount);
        formData.append("file", file);

        // Envoyer les données au serveur pour mettre à jour le profil de l'utilisateur
        // Utilisez XMLHttpRequest ou Fetch API ici
        // ...
      }


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