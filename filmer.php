<?php

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
    <script src="script/js/preload.js?<?php echo date('hi') ?>"></script>
    <script src="script/js/sortMain.js?<?php echo date('hi') ?>"></script>
    <script src="script/js/slideShow.js?<?php echo date('hi') ?>"></script>
    <script src="script/js/pln.js"></script>
    <title>Se våra filmer & VOD's | Widr.tv</title>
  </head>
  <body>
    <?php include_once 'assets/dom/mnav.php'; ?>
    <div class="navigation fsz">


      <img src="assets/img/logo.svg" id="mlogo" alt="">
      <div class="menu">
        <?php include_once 'assets/dom/nav.php'; ?>
      </div>
    </div>
    <div class="header chn">

      <div class="curve mini">


      </div>
    </div>

    <div class="loader"></div>
  <div class="section fsVod hid_def">

  </div>
  <div class="section fsz chn">

    <?php



      $fg = file_get_contents('assets/localDb.json');
      $data = json_decode($fg, true);

          function cmp($a, $b){
              $key = 'Title';
              if($a[$key] < $b[$key]){
                  return -1;
              } else if($a[$key] > $b[$key]){
                  return 1;
              }
              return 0;
          }
          usort($data, 'cmp');




          foreach($data as $key => $vods){
                    //fixa score
                    if(isset($vods['imdbRating']))
                    {
                      //rotten score finns, priritera
                      $rating = round($vods['imdbRating']);
                    } else {
                      $rating = '';
                    }

            //remove space + min
            $vods['Runtime'] = str_replace(' ', '', substr($vods['Runtime'], 0, -2));
            $vods['Genre'] = explode(',', $vods['Genre']);
            ?>
            <div class="posterBlock visible" id="<?php echo $key ?>" style="background-image: url(<?php echo $vods['Poster'] ?>)">
                  <span class="runtime"><?php echo $vods['Runtime'] ?></span>
                  <h1><?php echo $vods['Title'] ?></h1>
                  <span class="genre"><?php echo $vods['Genre'][0] ?></span>
                  <span class="year"><?php echo $vods['Year'] ?></span>
                  <div class="rating">
                    <div class="bar">
                      <?php

                              foreach(range(1, $rating) as $items)
                              {
                                ?>
                                <i class="fas fa-star"></i>
                                <?php
                              }

                       ?>
                    </div>
                  </div>
            </div>
            <?php
          }




     ?>

  </div>
  </body>
</html>
