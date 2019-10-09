<?php
  $main->con->set_charset("utf8");


  if($main->seriesPage != 'alla'){
    $result = $main->getFromMysql("SELECT * FROM series WHERE title = '$main->seriesPage'");
    if($result->num_rows > 0){
      while($row = mysqli_fetch_assoc($result)){

        $sources = json_decode($row['source'], true);
        if(!$main->getFromAPI_tv($row['title'])['results'] || !$sources['1'] || $sources['1'][0] == '404'){

          ?>
            <span class="queryError">Vi kunde tyvärr inte ladda videon.</span>
            <div class="centerDiv customPos">
              <span class="qe report">Rapportera felmeddelande</span>
            </div>
          <?php
        } else {
          $data = $main->getFromAPI_tv($row['title'])['results'][0];
          $genreString = $main->compileGenres($row['genre']);
          $desc = explode(".",$data['overview']);
          $main->setLatestId($row, "serie");
          $start = 0;
          ?>
          <div class="section player">

            <div class="videopl">
              <div class="lds-ellipsis hidden orange"><div></div><div></div><div></div><div></div></div>
              <iframe id="ifrmsrc" data-ifrmsrc="<?php echo $sources['1'][$start]  ?>" frameborder='0' allowfullscreen src=""></iframe>
            </div>
            <div class="mediainformation">
              <h1><?php echo ucfirst(str_replace("-", " ", $row['title'])) ?> <strong><?php echo number_format($data['popularity'], 1) ?></strong>  </h1>
              <span class="genre"><i class="fas fa-theater-masks"><?php echo $genreString; ?></i></span>

              <div class="seasons">

                <?php
                foreach($sources as $key => $value){
                  if(!empty($value)){
                    if($key == 1){ $akt = "default"; } else { $akt = ""; }
                    echo "<h1 class=".$akt." >Säsong ".ucfirst(str_replace("_", " ", $key))."</h1>";

                  }

                  foreach($value as $k => $v){
                    $active = "";
                    if($k == 0 && $key == 1){
                      $active = "active";
                    }
                  #  $k = $k + 1;
                    $k++;
                    ?>
                    <span data-lnk="<?php echo $v ?>" class="epsd <?php echo $active ?>"><?php echo "episode <strong>".$k."</strong>"  ?></span>
                    <?php
                  }
                }
                ?>
              </div>

              <div class="desc">
                <h2>Beskrivning</h2>
                <?php
                foreach($desc as $key => $value){
                  ?>
                  <p><?php echo $value ?></p>
                  <?php
                }
                ?>
              </div>
            </div>
          </div>

          <?php

        }
      }
    } else {
      ?>
      <span class="queryError">Vi kunde tyvärr inte hitta det du letade efter :( </span>
      <?php
    }

  } else {
    include_once "assets/portalDom/spotlightHeader.php";
    ?>
    <div class="section all fixedcat">
      <div class="catselect">
        <h1>Serier</h1>
        <div class="catselecth">

          <span class="genreselect">
              <?php
                if(isset($main->typeCat)){
                  echo ucfirst($main->getSingleGenre());
                } else {
                  echo "Alla";
                }
              ?>
          </span>
          <div class="genreholder">
            <?php
            foreach($main->genres as $key => $value){
              ?>
              <a href="?serie=alla&c=<?php echo $value ?>">
                <span data-cat="<?php echo $value ?>"><?php echo ucfirst($key) ?></span>
              </a>
              <?php
            }

            ?>

          </div>
        </div>
      </div>

    <?php
    if(isset($main->typeCat)){
        $sql = "SELECT * FROM series WHERE genre LIKE '%$main->typeCat%' ORDER BY title ASC";
        $result = $main->getFromMysql($sql);
        while($row = mysqli_fetch_assoc($result)){
          $imgstring = "https://image.tmdb.org/t/p/w185".$row['img'];
          ?>
          <a href="?serie=<?php echo $row['title'] ?>">
            <div class="block" style="background-image: url(<?php echo $imgstring ?>)">
              <h1 class="small"><?php echo ucfirst(str_replace("-", " ",$row['title']))?></h1>
            </div>
          </a>
          <?php
        }
        #var_dump($result);
      ?>
      <?php
    } else if(!isset($main->typeCat)) {
      ?>
      <span class="small" style="display: block; width: 100%; margin: 5px 0 10px 0">Alla Serier</span>
      <?php
      $result = $main->getFromMysql("SELECT * FROM series");
      if($result->num_rows > 0){
        while($row = mysqli_fetch_assoc($result)){
          $imgstring = "https://image.tmdb.org/t/p/w185".$row['img'];
          ?>
          <a href="?serie=<?php echo $row['title'] ?>">
            <div class="block" style="background-image: url(<?php echo $imgstring ?>)">
              <h1 class="small"><?php echo ucfirst(str_replace("-", " ",$row['title']))?></h1>
            </div>
          </a>
          <?php
        }
        ?>

      <?php

    }
      # Inkludera utanför loop
      #include_once 'assets/portalDom/watched.php';
    } else {
      ?>
      <span class="queryError">Vi kunde tyvärr inte hitta det du letade efter :( </span>
      <img class="qe" src="assets/img/error.png" alt="">
      <?php
    } ?>
  </div>
    <?php
  }
