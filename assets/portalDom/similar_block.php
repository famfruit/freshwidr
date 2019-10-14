<?php
    if(isset($main->latestCookie)){
      ?>
        <div class="section last similar">
          <span class="small"> <strong>Liknar</strong>  <?php echo $main->moviePage ?></span>
          <div class="title-layout">
          <?php
            #$sql = "SELECT * FROM movies WHERE MATCH(genre) AGAINST ('$rawgenre' IN BOOLEAN MODE) LIMIT 20";
            $sql = "SELECT * FROM movies WHERE genre LIKE '%$rawgenre%' AND title NOT LIKE '%$main->moviePage%' ORDER BY views, releasedate DESC LIMIT 20";
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
