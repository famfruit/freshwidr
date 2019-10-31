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
  if(isset($main->reportSet)){
    $main->sendErrorReport();
    exit;
  }

  if(isset($main->moviePage) || isset($main->seriesPage)){
    if(isset($main->moviePage)){
      $newTitle = ucwords(str_replace("-", " ", $main->moviePage));
    } else if(isset($main->seriesPage)){
      $newTitle = ucwords(str_replace("-", " ", $main->seriesPage)). " | Avsnitt ".$main->episodePick. " - Säsong ".$main->seasonPick;
    }
  } else if(isset($main->refPage)){
    $newTitle = "Telly - Registrera dig nu!";
  } else if(!isset($main->loginCookie)){
    $newTitle = "Telly - Logga in!";
  } else if(isset($main->profilePage)){
    $newTitle = "Telly - ".ucfirst($main->decodedUser['username']);
  } else {
    $newTitle = "Telly";
  }
  #var_dump(json_decode($main->latestCookie, true));
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
    <link rel="stylesheet" href="assets/styles/fa/all.css">
    <link rel="stylesheet" href="assets/styles/styles.css?">

    <script src="script/portal/global.js"></script>
  <title><?php echo $newTitle ?></title>
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
            include_once "assets/portalDom/watched_onerow.php";
            include_once "assets/portalDom/carousel.php";
            include_once "assets/portalDom/midRecom.php";
            include_once "assets/portalDom/widerecom.php";
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
