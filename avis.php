<?php
// Connexion à la base de données
// À modifier si besoin 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cret"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier si le formulaire est soumis
if (isset($_POST["submit"])) {
    // Récupérer les données du formulaire
    $name = $_POST["name"];
    $message = $_POST["message"];
    $timestamp = date("Y-m-d H:i:s");

    // Préparer la requête SQL avec des paramètres
    $sql = "INSERT INTO comments (name, message, timestamp) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $name, $message, $timestamp);
   
    
    if ($stmt->execute()) {
        echo "Avis ajouté avec succès.";
        header("Location: avis.php");
        exit();
    } else {
        echo "Erreur lors de l'ajout de l'avis : " . $stmt->error;
    }
    $stmt->close();
}

// Récupérer les avis à partir de la base de données
$sql = "SELECT * FROM comments ORDER BY timestamp DESC LIMIT 4";
$result = $conn->query($sql);

if (isset($_POST["delete"])) {
  // Récupérer l'ID du commentaire à supprimer
  $commentId = $_POST["comment_id"];

  // Préparer la requête SQL
  $deleteSql = "DELETE FROM comments WHERE id = ?";
  $deleteStmt = $conn->prepare($deleteSql);
  $deleteStmt->bind_param('i', $commentId);

  // Exécuter la requête de suppression
  if ($deleteStmt->execute()) {
      echo "Commentaire supprimé avec succès.";
      // Rediriger vers la page des avis
      header("Location: avis.php");
      exit();
  } else {
      echo "Erreur lors de la suppression du commentaire : " . $deleteStmt->error;
  }
  $deleteStmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Groupe SCE</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Arsha
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->


  <style>
    body {
        font-family: "Open Sans", sans-serif;
        /*margin: 20px;*/
    }
    h1 {
        text-align: center;
    }
    form {
        margin-bottom: 20px;
    }
    label {
        font-weight: bold;
    }
    textarea {
        width: 100%;
        height: 150px;
        resize: vertical;
        border-radius: 12px;
    }

    .comment {
        margin-bottom: 20px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
        width: 760px;
        border-color: rgb(0, 119, 255);
    }
    .comment p {
        margin-bottom: 5px;
        font-size: 15px;
    }
    .comment span {
        font-weight: bold;
    }
    .comment .timestamp {
        margin-top: 30px;
        font-size: 0.8em;
        color: #fff;
        background : rgb(0, 119, 255);
        text-align: center;
        max-width: 140px;
        border-radius: 10px;
    }
    
    #submit{
      background: #ffaa00;
      border: 0;
      padding: 12px 34px;
      color: #fff;
      transition: 0.4s;
      border-radius: 50px;
    }

    #submit:hover{
      background: #fac34b;
    }

    .inner-page{
      background: #f3f5fa;
    }

    .btn {
      float: right;
      margin-top: -38px;
      margin-right: 20px;
      background-color: transparent; /* Blue background */
      border: none; /* Remove borders */
      color: black; /* White text */
      padding: 12px 16px; /* Some padding */
      font-size: 0.8em; /* Set a font size */
      cursor: pointer; /* Mouse pointer on hover */
    }

    /* Darker background on mouse-over */
    .btn:hover {
      background-color: transparent;
      color: #ffaa00; 
    }

    .message {
        max-width: 710px;
        word-wrap: break-word;
        font-size: 9px;
    }

    #formulaire {
      position: relative; 
      margin-left: 50px; 
      width: 1000px;
    }

    #comments {
      margin-top: -445px; 
      margin-left: 650px;
    }

    @media (max-width: 992px) {
      #formulaire { 
      margin-top: -70px;
      margin-left: 0; 
      width: 400px;
      }

      #comments {
      margin-left: 0;
      margin-top: 50px;
      }

      .comment {
        margin-bottom: 20px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
        width: 380px;
        border-color: rgb(0, 119, 255);
      }
      .comment p {
        margin-bottom: 5px;
        font-size: 13px;
      }
      .comment span {
        font-weight: bold;
      }
      .comment .timestamp {
        margin-top: 30px;
        font-size: 0.7em;
        color: #fff;
        background : rgb(0, 119, 255);
        text-align: center;
        max-width: 120px;
        border-radius: 10px;
      }
    }


</style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top header-inner-pages">
    <div class="container d-flex align-items-center">

      <!--<h1 class="logo me-auto"><a href="index.html">C.R.E.T</a></h1>-->
      <!-- Uncomment below if you prefer to use an image logo -->
      <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="index.html">Accueil</a></li>
          <li><a class="nav-link scrollto" href="index.html#about">À propos</a></li>
          <li class="dropdown"><a><span>TP & BTP</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a class="nav-link scrollto" href="locationbennes.html">Location de bennes</a></li>
              <li><a class="nav-link scrollto" href="terrassement.html">Terrassement</a></li>
              <li><a class="nav-link scrollto" href="transport.html">Transport</a></li>
              <li><a class="nav-link scrollto" href="parcmachines.html">Parc Machines</a></li>
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="telecom.html">Télécom</a></li>
          <li><a class="nav-link scrollto active" href="avis.php">Avis</a></li>
          <li><a class="nav-link scrollto" href="index.html#contact" >Nous contacter</a></li>
          <li><a class="getstarted scrollto" href="index.html#about">C'est parti</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.html">Accueil</a></li>
          <li>Avis</li>
        </ol>
        <h2>Avis</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <section id="avis" class="avis">
    <div class="container" data-aos="fade-up" id="formulaire">
    <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
            <form action="avis.php" method="post" class="php-email-form">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="name">Votre Nom</label>
                  <input type="text" name="name" class="form-control" id="name" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name">Message</label>
                <textarea class="form-control" name="message" maxlength="450" rows="10" required></textarea>
              </div>
              <div class="text-center"><input type="submit" name="submit" value="Envoyer avis"></div>
            </form>
          </div> 

    <div id="comments">
        <?php

        setlocale(LC_TIME, 'fr_FR'); // Définit le locale en français
        // Afficher les avis
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="comment">';
                echo "<p><span>" . $row["name"] . "</span> a donné un avis. </p>";
                echo '<form action="avis.php" method="post">';
                echo '<input type="hidden" name="comment_id" value="' . $row["id"] . '">';
                //echo '<button class="btn" type="submit" name="delete" value="delete"><i class="fa fa-trash"></i></button>'; // Bouton Supprimer
                echo '</form>';
                echo '<p class="message">' . $row["message"] . '</p>';
                echo '<p class="timestamp">' . strftime("%d/%m/%Y à %H:%M", strtotime($row["timestamp"])) . '</p>';
                echo '</div>';
            }
        } else {
            echo 'Aucun avis pour le moment.';
        }
        ?>
      </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

   

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6 footer-contact">
            <h3>GROUPE SCE</h3>
            <p>
              2-4 rue Frédéric Joliot Curie <br>
              93270 SEVRAN <br>
              France <br><br>
              <strong>Tél:</strong> +33 1 43 83 12 10<br>
              <strong>Email:</strong> cret@cretreseaux.com<br>
            </p>
          </div>

          <div class="col-lg-4 col-md-6 footer-links">
            <h4>Liens utiles</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="index.html#home">Accueil</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="index.html#about">À propos</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="telecom.html">Télécom</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="avis.php">Avis</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="index.html#contact">Nous contacter</a></li>
            </ul>
          </div>

          <!--<div class="col-lg-3 col-md-6 footer-links">
            <h4>Nos Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>-->

          <div class="col-lg-4 col-md-6 footer-links">
            <h4>Notre instagram</h4>
            <div class="social-links mt-3">
              <!--<a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>-->
              <a href="https://www.instagram.com/cret_reseaux" class="instagram" target="_blank"><i class="bx bxl-instagram" style="padding: 2px;"></i></a>
              <!--<a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>-->
            </div>
          </div>
          

        </div>
      </div>
    </div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
         Copyright &copy; <strong><span>2023</span></strong>. Tous droits réservés. | <a href="mentionslegales.html" style="color: #fff;">Mentions légales</a>
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->


  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
