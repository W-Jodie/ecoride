<?php if (isset($_GET['message'])): ?>
    <p style="color: green;"><?= htmlspecialchars($_GET['message']) ?></p>
<?php endif; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Détail du trajet – EcoRide</title>
  <link rel="stylesheet" href="../CSS/details.css">
</head>
<body>

    <header>
      <div class="header-container">
        <h1 class="logo-title">
          <span class="eco">Ec
          </span>
          <a href="../index.html">
          <img src="../Image/terre.webp" alt="EcoRide Logo">
          </a>
          <span class="ride">Ride
          </span>
        </h1>
        <div class="icone">
          <a href="../inscription.html">
          <svg xmlns="http://www.w3.org/2000/svg" width="83" height="83" fill="none">
          <g clip-path="url(#clip0_91_22)">
          <path d="M57.0625 31.125C57.0625 35.2524 55.4229 39.2108 52.5044 42.1294C49.5858 45.0479 45.6274 46.6875 41.5 46.6875C37.3726 46.6875 33.4142 45.0479 30.4957 42.1294C27.5771 39.2108 25.9375 35.2524 25.9375 31.125C25.9375 26.9976 27.5771 23.0392 30.4957 20.1207C33.4142 17.2021 37.3726 15.5625 41.5 15.5625C45.6274 15.5625 49.5858 17.2021 52.5044 20.1207C55.4229 23.0392 57.0625 26.9976 57.0625 31.125Z" fill="#01D758"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M0 41.5C0 30.4935 4.37231 19.9378 12.1551 12.1551C19.9378 4.37231 30.4935 0 41.5 0C52.5065 0 63.0622 4.37231 70.8449 12.1551C78.6277 19.9378 83 30.4935 83 41.5C83 52.5065 78.6277 63.0622 70.8449 70.8449C63.0622 78.6277 52.5065 83 41.5 83C30.4935 83 19.9378 78.6277 12.1551 70.8449C4.37231 63.0622 0 52.5065 0 41.5ZM41.5 5.1875C34.6617 5.18786 27.9625 7.11913 22.1735 10.759C16.3844 14.3989 11.7408 19.5995 8.77706 25.7621C5.81335 31.9248 4.65 38.7991 5.42093 45.5938C6.19185 52.3884 8.86571 58.8273 13.1348 64.1694C16.8179 58.2349 24.9259 51.875 41.5 51.875C58.0741 51.875 66.1769 58.2297 69.8652 64.1694C74.1343 58.8273 76.8082 52.3884 77.5791 45.5938C78.35 38.7991 77.1867 31.9248 74.2229 25.7621C71.2592 19.5995 66.6156 14.3989 60.8265 10.759C55.0375 7.11913 48.3383 5.18786 41.5 5.1875Z" fill="#01D758"/>
          </g>
          </svg>
          </a>
        </div>
      </div>
    </header>

    <main>
        <section>
            <div class="head">
                <div class="big-image">
                    <img src="../Image/route.jpg" alt="route">
                </div>
                <div class="overlay-1">
                    <h2 class="titre-trajet">Détails du trajet</h2>
                </div>
                <div class="search-box">
                    <div class="trajet">
                        <img src="../Image/trajet.webp" alt="voiture avec localisation">
                    </div>
                </div> 
            </div>
        </section>

        <section class="infos-conducteur">
            <div class="driver-photo">
                <img src="../Image/marie.jpg" alt="Photo de Marie">
            </div>
    
            <div class="info-wrapper">
                <div class="name">
                    <h3>Marie</h3>
                </div>
                <div class="driver-info">
                    <div class="vehicle-info">
                        <p>Nissan ARIYA 100% électrique</p>
                            <ul>
                            <li>Accepte les animaux</li>
                            <li>Véhicule non-fumeur</li>
                            </ul>
                    </div>
                </div>
            </div>
        </section>

  <section class="depart-arrivee">
    <p>Départ : Place Général de Gaulle, 59800 Lille</p>
    <p>Arrivée : La Croix-Rousse, 69004 Lyon</p>
  </section>

  <section class="avis-container">
    <div class="avis">
      <div class="avis-content">
        <div class="stars">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="31" viewBox="0 0 32 31" fill="none">
                <path d="M7.50995 30.3659C6.76103 30.7561 5.91121 30.0722 6.06255 29.1991L7.67293 19.8765L0.837561 13.262C0.199231 12.6431 0.531007 11.5118 1.38664 11.3896L10.8898 10.0178L15.1272 1.48953C15.5094 0.720857 16.5436 0.720857 16.9258 1.48953L21.1632 10.0178L30.6664 11.3896C31.522 11.5118 31.8538 12.6431 31.2135 13.262L24.3801 19.8765L25.9905 29.1991C26.1418 30.0722 25.292 30.7561 24.5431 30.3659L16.0236 25.9194L7.50995 30.3659Z" fill="black"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="31" viewBox="0 0 32 31" fill="none">
                <path d="M7.50995 30.3659C6.76103 30.7561 5.91121 30.0722 6.06255 29.1991L7.67293 19.8765L0.837561 13.262C0.199231 12.6431 0.531007 11.5118 1.38664 11.3896L10.8898 10.0178L15.1272 1.48953C15.5094 0.720857 16.5436 0.720857 16.9258 1.48953L21.1632 10.0178L30.6664 11.3896C31.522 11.5118 31.8538 12.6431 31.2135 13.262L24.3801 19.8765L25.9905 29.1991C26.1418 30.0722 25.292 30.7561 24.5431 30.3659L16.0236 25.9194L7.50995 30.3659Z" fill="black"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="31" viewBox="0 0 32 31" fill="none">
                <path d="M7.50995 30.3659C6.76103 30.7561 5.91121 30.0722 6.06255 29.1991L7.67293 19.8765L0.837561 13.262C0.199231 12.6431 0.531007 11.5118 1.38664 11.3896L10.8898 10.0178L15.1272 1.48953C15.5094 0.720857 16.5436 0.720857 16.9258 1.48953L21.1632 10.0178L30.6664 11.3896C31.522 11.5118 31.8538 12.6431 31.2135 13.262L24.3801 19.8765L25.9905 29.1991C26.1418 30.0722 25.292 30.7561 24.5431 30.3659L16.0236 25.9194L7.50995 30.3659Z" fill="black"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="31" viewBox="0 0 32 31" fill="none">
                <path d="M7.50995 30.3659C6.76103 30.7561 5.91121 30.0722 6.06255 29.1991L7.67293 19.8765L0.837561 13.262C0.199231 12.6431 0.531007 11.5118 1.38664 11.3896L10.8898 10.0178L15.1272 1.48953C15.5094 0.720857 16.5436 0.720857 16.9258 1.48953L21.1632 10.0178L30.6664 11.3896C31.522 11.5118 31.8538 12.6431 31.2135 13.262L24.3801 19.8765L25.9905 29.1991C26.1418 30.0722 25.292 30.7561 24.5431 30.3659L16.0236 25.9194L7.50995 30.3659Z" fill="black"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="31" viewBox="0 0 35 31" fill="none">
                <path d="M12.1631 10.0169L16.824 1.48855C16.9143 1.31755 17.0544 1.17315 17.2285 1.07151C17.4027 0.969863 17.604 0.914987 17.81 0.913025C18.2005 0.913025 18.5911 1.10421 18.8023 1.48855L23.4633 10.0169L33.9162 11.3887C34.1762 11.4276 34.414 11.5476 34.5899 11.7287C34.7658 11.9098 34.8692 12.1411 34.8829 12.384C34.8975 12.546 34.8725 12.7089 34.8097 12.8607C34.7469 13.0126 34.6479 13.1494 34.5201 13.2611L27.0016 19.8757L28.7729 29.1983C28.9394 30.0715 28.0047 30.7554 27.1809 30.3651L17.81 25.9186L8.44333 30.3651C8.34561 30.4127 8.2405 30.4459 8.13175 30.4637C7.40188 30.582 6.70615 29.9631 6.85127 29.1983L8.62259 19.8757L1.10623 13.2611C0.989375 13.159 0.896494 13.0358 0.833349 12.8992C0.770204 12.7625 0.738144 12.6154 0.739159 12.4668C0.741394 12.2571 0.804001 12.0516 0.920559 11.8716C1.00428 11.7414 1.11879 11.6303 1.25552 11.5467C1.39225 11.4631 1.54768 11.409 1.71018 11.3887L12.1631 10.0169ZM17.81 23.6323C17.9822 23.6317 18.1521 23.6695 18.3051 23.7427L26.1715 27.4757L24.6904 19.6766C24.6545 19.4972 24.6672 19.3124 24.7276 19.1387C24.7879 18.965 24.8939 18.8079 25.0361 18.6813L31.24 13.2217L22.5925 12.0864C22.4138 12.0607 22.2443 11.9957 22.0984 11.8969C21.9524 11.7981 21.8343 11.6685 21.7538 11.5188L17.8121 4.309L17.81 4.31491V23.6323Z" fill="black"/>
            </svg>
        </div>
        <p>💬 <em>Claire :</em> très bonne conduite, je recommande.</p>
            <p>💬 <em>Paul :</em> Conduite très douce, agréable compagnie.</p>
      </div>
    </div>
</section>

<section class="container-image">
  <div class="image-container">
    <img src="../Image/natural.webp" alt="photo planete dans une main">
  </div>
  <div class="overlay-2">
    <form method="POST" action="../BACK/participer.php">
      <input type="hidden" name="trajet_id" value="<?= $trajet['id'] ?>">
      <button type="submit" class="participer-btn">Participer</button>
    </form>
  </div>
</section>

    </main>

    <footer>
      <div class="footer-content">
        <p class="email">adresse@ecoride.com</p>
        <h1 class="footer-container">
          <span class="eco">Ec
            <img src="../Image/terre.webp" alt="EcoRide Logo">
          </span>
          <span class="ride">Ride
          </span>
        </h1>
        <p class="mentions"><a href="#"><u>Mentions légales</u></a></p>
      </div>
    </footer>

    </body>
</html>