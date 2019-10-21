<div class="section carousel">
  <div class="scroll scrolleft hidden"></div>
  <div class="scroll scrollright"></div>
      <span class="small xxl">NYA SERIER & FILMER</span>
      <div class="realwindow title-layout">

      <?php
        #$sql = "SELECT * FROM movies WHERE MATCH(genre) AGAINST ('$rawgenre' IN BOOLEAN MODE) LIMIT 20";
        $sql = "SELECT *, 'movie' as moviedb FROM movies ORDER BY views, releasedate DESC LIMIT 20";
        $result = $main->getFromMysql($sql);
        while($row = mysqli_fetch_assoc($result)){
          if($row['genre'] == 'null' || $row['genre'] == "[]"){
            $genre = "";
          } else {
            $genre =  $main->compileGenres($row['genre']);
          }
          $imgstring = "https://image.tmdb.org/t/p/w185".$row['img'];
          ?>
          <a href="?<?php echo $row['moviedb']?>=<?php echo $row['title'] ?>">
            <div class="block" style="background-image: url(<?php echo $imgstring ?>)">
              <h1 class="small"><?php echo ucfirst(str_replace("-", " ",$row['title']))?></h1>
              <div class="headerSpecs">
                <i class="fas fa-theater-masks"><?php echo $genre ?></i>
              </div>
            </div>
          </a>
          <?php
        }


      ?>

  </div>
</div>
