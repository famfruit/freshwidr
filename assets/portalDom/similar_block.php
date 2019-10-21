<?php
    if(isset($main->latestCookie)){
      ?>
        <div class="section last carousel similar">
          <div class="scroll scrolleft hidden"></div>
          <div class="scroll scrollright"></div>
          <span class="small xxl"> <strong>Liknar</strong>  <?php if(isset($main->moviePage)){ echo $main->moviePage; } else if (isset($main->seriesPage)) { echo $main->seriesPage; } ?></span>
          <div class="realwindow title-layout">
          <?php
            #$sql = "SELECT * FROM movies WHERE MATCH(genre) AGAINST ('$rawgenre' IN BOOLEAN MODE) LIMIT 20";
            if($sqlpointer == 'movies'){
              $like = $main->moviePage;
            } else {
              $like = $main->seriesPage;
            }
            $sql = "SELECT * FROM $sqlpointer WHERE genre LIKE '%$rawgenre%' AND title NOT LIKE '%$like%' ORDER BY views, releasedate DESC LIMIT 20";
            $result = $main->getFromMysql($sql);
            while($row = mysqli_fetch_assoc($result)){
              $imgstring = "https://image.tmdb.org/t/p/w185".$row['img'];
              ?>
              <a href="?<?php echo $rawtype?>=<?php echo $row['title'] ?>">
                <div class="block" style="background-image: url(<?php echo $imgstring ?>)">
                  <h1 class="small"><?php echo ucfirst(str_replace("-", " ",$row['title']))?></h1>
                </div>
              </a>
              <?php
            }


          ?>
          </div>
        </div>
      <?php
    }
 ?>
