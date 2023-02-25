<?php
session_start();
if (isset($_SESSION['connect'])) {
    header('location: dashboard.php?succes=1');
    exit;
}
require("connexion.php");
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email    =  $_POST['email'];
    $password =  $_POST['password'];
    $error = 1;
    //HASH PASSWORD 
    $password = "aq1" . sha1($password . "1234") . "25";

    $stmt = $db->prepare("SELECT * FROM influencer WHERE email=?");
    $stmt->execute(array($email));
    while ($user = $stmt->fetch()) {
        if ($password == $user['password']) {
            $error = 0;
            $_SESSION['connect']           = 1;
            $_SESSION['full_name']         = $user['full_name']; // c'est pour ca quand a fetch tout
            $_SESSION['id_influencer']     = $user['id'];
            $_SESSION['email']             = $user['email'];
            $_SESSION['phone_number']      = $user['phone_number'];
            $_SESSION['instagram_account'] = $user['instagram_account'];

            if (isset($_POST['connect'])) {
                setcookie('connect', $user['secret'], time() + 365 * 24 * 3600, '/', null, false, true);
            }
            header('location: dashboard.php?success=1');
            exit();
        }
    }
    if ($error == 1) {
        header('location: login_as_an_influencer.php?error=1');
        exit();
    }
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
        <form method="post" action="login_as_an_influencer.php">
            <?php
            if (isset($_GET['error'])) { ?>
                <div>
                    <p>Email ou mot de passe incorrect!</p>
                </div>
            <?php
            }
            ?>
            <div class="txt-field">
                <input type="email" name="email" class="txt-css" required>
                <label>Email</label>
            </div>

            <div class="txt-field">
                <input type="password" name="password" class="txt-css" required>
                <label>Password</label>
            </div>
            <div>
                <label><input id="checkbox" type="checkbox" name="connect">Auto login </label>
            </div>

            <div>
                <input class="login-btn" type="submit" value="Log in">
            </div>

            <div class="P1">
                <p>Don't you have an account? <a href="join_as_a_brand.php" class="sign-in"> Sign in </a> </p>
            </div>

        </form>
    </div>

</body>

</html>