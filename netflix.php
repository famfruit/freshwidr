<?php
session_start();
spl_autoload_register('autoLoadClasses');
function autoLoadClasses($className){
  $path = "classes/";
  $ext = ".class.php";
  $fullP = $path . $className . $ext;
  include_once $fullP;
}
  $main = new netflix();
  if(isset($main->searchBarKey)){
    return $main->search($main->searchValue);
    exit;
  }
  if(!isset($main->latestCookie)){
    $newArray = array(
      "movie" => array(),
      "serie" => array(),
    );
    $encodedCookie = json_encode($newArray);
    setcookie('latest', $encodedCookie, time() + (86400 * 30), "/"); // 86400 = 1 day
  }
  if(isset($main->clearCookies)){
    setcookie('latest', '{"movie":[],"serie":[]}', time() + (86400 * 30), "/"); // 86400 = 1 day
    header('Location: ?cookiesCleared');
  }
  if(isset($main->regSet)){
    $main->registerUser();
    exit;
  }
  if(isset($main->loginSet)){
    $main->authenticate();
    exit;
  }
  if(isset($main->logout)){
    if($main->logout == 't'){
      setcookie('sessionSettings', "", time() - (86400 * 30), "/"); // 86400 = 1 day
      header('location: ?logout=s');
      exit;
    }
  }
  if(isset($main->userChangeSet)){
    $main->changeUser();
    exit;
  }
  if(isset($main->generateInvite)){
    $main->generateKey();
    exit;
  }

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/fav/favicon-16x16.png">
    <link rel="mask-icon" href="assets/img/fav/safari-pinned-tab.svg" color="#5bbad5">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/styles.css?">

    <script src="script/portal/global.js"></script>
  <title>Se våra filmer & VOD's | Widr.tv</title>
  </head>


  <body class="flx notready">
    <div class="wall"></div>
    <div class="wrapper notready">

    <div class="searchBar hidden">
      <div class="searchInput">
        <input type="text" name="search" value="" placeholder="Titlar, Filmer, Serier..">
      </div>
    </div>
    <div class="searchResults hidden">
      <!--<div class="bar">
        <div class="imgBlock"></div>
        <h1>title</h1>
        <span>genres</span>-->
      </div>

    </div>

    <?php
      if(isset($main->refPage)){
        include_once "assets/portalDom/inv.php";
      } else {
        if(!isset($main->loginCookie)){
          # Run isLoggedIn() instead of 1 != 0
          # Did not authenticate, prompt login
          include_once "assets/portalDom/auth.php";
        } else {
          if(isset($main->moviePage)){
            include_once "assets/portalDom/movies.php";

          } else if(isset($main->seriesPage)){

            include_once "assets/portalDom/series.php";

          } else if(isset($main->historyPage)){
            include_once "assets/portalDom/spotlightHeader.php";
            include_once "assets/portalDom/watched.php";
          } else if(isset($main->profilePage)) {
            include_once "assets/portalDom/profile.php";
          } else {
            include_once "assets/portalDom/spotlightHeader.php";
            include_once "assets/portalDom/carousel.php";
            include_once "assets/portalDom/midRecom.php";
            include_once "assets/portalDom/widerecom.php";
            include_once "assets/portalDom/watched_onerow.php";
          }
          # User is logged in, inport footer + nav
          include_once 'assets/portalDom/footer.php';
          include_once 'assets/portalDom/portalNav.php';
        }
      }


     ?>

   </div>
  </body>
</html>
