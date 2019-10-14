<?php

  if($main->moviePage != 'alla'){
      $result = $main->getFromMysql("SELECT * FROM movies WHERE MATCH(title) AGAINST ('$main->moviePage' IN NATURAL LANGUAGE MODE) LIMIT 1");
      if($result->num_rows > 0){
        while($row = mysqli_fetch_assoc($result)){
          if(!$main->getFromAPI($row['title'])['results']){

            ?>
              <span class="queryError">Vi kunde tyvärr inte ladda videon.</span>
              <div class="centerDiv customPos">
                <span class="qe report">Rapportera felmeddelande</span>
              </div>
            <?php
          } else {
            $data = $main->getFromAPI($row['title'])['results'][0];
            $genreString = $main->compileGenres($row['genre']);
            $desc = explode(".",$data['overview']);
            $main->setLatestId($row, "movie");
            $main->increaseView($row['id'], "movies");
            $source = json_decode($row['source'], true)['source'];
            $rawgenre = $row['genre'];
            $rawtype = "movie";
            ?>
            <div class="section player">
              <div class="videopl">
                <div class="lds-ellipsis hidden orange"><div></div><div></div><div></div><div></div></div>
                <iframe id="ifrmsrc" data-ifrmsrc="<?php echo $source ?>" frameborder='0' allowfullscreen src=""></iframe>
              </div>
              <div class="mediainformation">
                <h1><?php echo ucfirst(str_replace("-", " ", $row['title'])) ?> <strong><?php echo number_format($data['popularity'], 1) ?></strong>  </h1>
                <span class="genre"><?php echo $genreString; ?></span>
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
            include_once 'assets/portalDom/similar_block.php';
          }

        }
      } else {
        ?>
        <span class="queryError">Vi kunde tyvärr inte hitta det du letade efter :( </span>
        <img class="qe" src="assets/img/error.png" alt="">
        <?php
      }
  } else {
    include_once "assets/portalDom/spotlightHeader.php";
    ?>
    <div class="section all fixedcat">
      <div class="catselect">
        <h1></h1>
        <div class="catselecth">

          <span class="genreselect">
              <?php
                if(isset($main->typeCat)){
                  echo ucfirst($main->getSingleGenre());
                } else {
                  echo "Välj kategori";
                }
              ?>
          </span>
          <div class="genreholder">
            <?php
            foreach($main->genres as $key => $value){
              ?>
              <a href="?movie=alla&c=<?php echo $value ?>">
                <span data-cat="<?php echo $value ?>"><?php echo ucfirst($key) ?></span>
              </a>
              <?php
            }

            ?>

          </div>
        </div>
        <div class="letters">
          <span>A</span>
          <span>B</span>
          <span>C</span>
          <span>D</span>
          <span>E</span>
          <span>F</span>
          <span>G</span>
          <span>H</span>
          <span>I</span>
          <span>J</span>
          <span>K</span>
          <span>L</span>
          <span>M</span>
          <span>N</span>
          <span>O</span>
        </div>
      </div>

    <?php
    if(isset($main->typeCat)){
        ## REPLACE MOVIE_TEST
        $sql = "SELECT * FROM movies_test WHERE genre LIKE '%$main->typeCat%' ORDER BY title ASC LIMIT 20";
        $result = $main->getFromMysql($sql);
        while($row = mysqli_fetch_assoc($result)){
          $imgstring = "https://image.tmdb.org/t/p/w185".$row['img'];
          ?>
          <a href="?movie=<?php echo $row['title'] ?>">
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
      <span class="small" style="display: block; width: 100%; margin: 5px 0 10px 0">Alla filmer</span>
      <?php
      $result = $main->getFromMysql("SELECT * FROM movies ORDER BY releasedate DESC LIMIT 16");
      if($result->num_rows > 0){
        while($row = mysqli_fetch_assoc($result)){
          $imgstring = "https://image.tmdb.org/t/p/w185".$row['img'];
          ?>
          <a href="?movie=<?php echo $row['title'] ?>">
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
