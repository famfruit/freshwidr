<?php

  if($main->moviePage != 'alla'){
      #$result = $main->getFromMysql("SELECT * FROM movies WHERE MATCH(title) AGAINST ('$main->moviePage' IN NATURAL LANGUAGE MODE) LIMIT 1");
      $result = $main->getFromMysql("SELECT * FROM movies_test WHERE title LIKE '%$main->moviePage%' LIMIT 1");
      if($result->num_rows > 0){
        while($row = mysqli_fetch_assoc($result)){
          $vidId = $row['id'];
          if(!$main->getFromAPI($row['title'])['results']){

            ?>
              <span class="queryError">Vi kunde tyvärr inte ladda videon.</span>

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
            $sqlpointer = "movies";
            ?>
            <div class="section player">
              <div class="videopl">
                <div class="lds-ellipsis hidden orange"><div></div><div></div><div></div><div></div></div>

                <iframe id="ifrmsrc" data-ifrmsrc="<?php echo $source ?>" frameborder='0' allowfullscreen src=""></iframe>
              </div>
              <div class="mediainformation">
                <h1><?php echo ucfirst(str_replace("-", " ", $row['title'])) ?> <strong><?php echo number_format($data['popularity'], 1) ?></strong>  </h1>
                <span class="genre"><i class="fas fa-theater-masks"><?php echo $genreString; ?></i></span>

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
            ?>

              <div class="reportContent">
                <span class="reportBtn" data-usr="<?php echo $main->decodedUser['username'];?>">Rapportera fel</span>
              </div>
              <div class="reportContentOptions" id="movies" data-vlid="<?php echo $vidId ?>">
                <span data-vl="0" class="specRepBtn"><i class="fas fa-meh"></i>Dålig Kvalité</span>
                <span data-vl="1" class="specRepBtn skip"><i class="fas fa-unlink"></i>Trasig videolänk</span>
                <span data-vl="2" class="specRepBtn"><i class="fas fa-align-left"></i>Felaktig beskrivning </span>
                <span data-vl="3" class="specRepBtn skip"><i class="fas fa-image"></i>Bild saknas</span>
                <span data-vl="4" class="specRepBtn mid"><i class="fas fa-dumpster-fire"></i>Allt är åt helvete</span>
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

      if(empty($main->typeCat)){
        $main->typeCat = 'alla';
      }

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
            ?>
            <a href="?movie=alla&c=alla">
              <span data-cat="<?php echo "alla" ?>"><?php echo "alla"?></span>
            </a>
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
          <?php
          $alph = range("A", "Z");
          foreach($alph as $key => $value){
            ?>
            <a href="?movie=alla&c=<?php echo $main->typeCat ?>&l=<?php echo strtolower($value); ?>&p=0"><?php echo $value?></a>
            <?php
          }
          ?>
        </div>
        <div class="pageselect">



        <a class="left" href="?movie=alla&c=<?php echo $main->typeCat ?>&l=<?php echo $main->letterCat ?>&p=<?php echo $main->typeCurPage + -1 ?>"></a>
            <h1><?php
                if(!isset($_GET['c'])){
                  $sql = "SELECT * FROM movies_test WHERE status = 0";
                } else if(empty($_GET['l'])){
                  # See if CAT == alla
                  if($main->typeCat == 'alla'){
                    $sql = "SELECT * FROM movies_test WHERE status = 0";
                  } else {
                    $sql = "SELECT * FROM movies_test WHERE genre LIKE '%$main->typeCat%' AND status = 0";
                  }
                } else {
                  if($main->typeCat == 'alla'){
                    $sql = "SELECT * FROM movies_test WHERE status = 0";
                  } else {
                    $sql = "SELECT * FROM movies_test WHERE genre LIKE '%$main->typeCat%' AND title LIKE '$main->letterCat%' AND status = 0";
                  }
                }
                $result = $main->getFromMysql($sql);
                if(isset($main->typeCurPage)){
                  echo $main->typeCurPage;
                } else {
                  echo "0";
                }

             ?></h1>
             <span class="disclaimer">av <?php echo number_format($result->num_rows / 40, 0); ?></span>
            <a class="right" href="?movie=alla&c=<?php echo $main->typeCat ?>&l=<?php echo $main->letterCat ?>&p=<?php echo $main->typeCurPage + 1 ?>"></a>
        </div>
      </div>

    <?php
    if(isset($main->typeCat) && isset($main->letterCat)) {
      # Pages

      #
      if(isset($main->typeCurPage)){
        $offset = $main->typeCurPage * 40;
      } else {
        $offset = 0;
      }
      if($main->typeCat == 'alla'){
        $sql = "SELECT * FROM movies_test WHERE title LIKE '$main->letterCat%' AND status = 0 LIMIT 40 OFFSET $offset";
      } else {

        $sql = "SELECT * FROM movies_test WHERE genre LIKE '%$main->typeCat%' AND title LIKE '$main->letterCat%' AND status = 0 LIMIT 40 OFFSET $offset";
      }
      #$sql = "SELECT * FROM movies WHERE MATCH(title) AGAINST('$main->letterCat%' IN BOOLEAN MODE) LIMIT 20";
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

      } else if(isset($main->typeCat)){
        ## REPLACE MOVIE_TEST
        if($main->typeCat == 'alla'){
          $sql = "SELECT * FROM movies_test WHERE status = 0 ORDER BY title ASC LIMIT 40";
        } else {
          $sql = "SELECT * FROM movies_test WHERE genre LIKE '%$main->typeCat%' AND status = 0 ORDER BY title ASC LIMIT 40";
        }
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
    }  else if(!isset($main->typeCat)) {
      ?>
      <span class="small" style="display: block; width: 100%; margin: 5px 0 10px 0">Alla filmer</span>
      <?php
      $result = $main->getFromMysql("SELECT * FROM movies_test WHERE status = 0 ORDER BY releasedate DESC LIMIT 40");
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
    } else {
      ?>
      <span class="queryError">Vi kunde tyvärr inte hitta det du letade efter :( </span>
      <?php
    } ?>
  </div>
    <?php
  }
