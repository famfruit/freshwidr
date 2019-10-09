<?php
  $main->con->set_charset("utf8");


  if($main->seriesPage != 'alla'){
    $result = $main->getFromMysql("SELECT * FROM series WHERE title = '$main->seriesPage'");
    if($result->num_rows > 0){
      while($row = mysqli_fetch_assoc($result)){
        if(!$main->getFromAPI_tv($row['title'])['results']){

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

          $sources = json_decode($row['source'], true);
          $start = 0;
          ?>
          <div class="section player">
            <iframe src="<?php echo $sources['säsong_1'][$start]  ?>" frameborder='0' allowfullscreen></iframe>
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

        }
      }
    } else {
      ?>
      <span class="queryError">Vi kunde tyvärr inte hitta det du letade efter :( </span>
      <?php
    }

  } else {
    ?>
    <div class="section all">
      <span class="small" style="display: block; width: 100%; margin: 5px 0 10px 0">Alla tv-serier</span>
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
      </div>

      <?php
      # Inkludera utanför loop
      include_once 'assets/portalDom/watched.php';
    } else {
      ?>
      <span class="queryError">Vi kunde tyvärr inte hitta det du letade efter :( </span>
      <img class="qe" src="assets/img/error.png" alt="">
      <?php
    }
  }
