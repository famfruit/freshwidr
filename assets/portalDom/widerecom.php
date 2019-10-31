<?php

$cookie = json_decode($main->loginCookie, true);
$result = $main->personalizeRecom(10);
 ?>
 <div class="section widerecom carousel">
   <div class="scroll scrolleft hidden"></div>
   <div class="scroll scrollright"></div>
   <span class="small xxl">Rekommenderat för <strong><?php echo $cookie['username']?></strong></span>
   <div class="realwindow title-layout">
    <?php
      while($row = mysqli_fetch_assoc($result)){
        #var_dump($row);
        $genre = $main->compileGenres($row['genre']);
        $type = substr($row['mc'], 0, -1);
        $imgstring = "https://image.tmdb.org/t/p/w400".$row['img'];
        ?>
        <a href="?<?php echo $type ?>=<?php echo $row['title'] ?>">
          <div class="block" style="background-image: url(<?php echo $imgstring ?>)">
            <h1 class="small"><?php echo ucfirst(str_replace("-", " ",$row['title']))?></h1>
            <div class="headerSpecs">
              <span class="avg"><?php echo number_format($row['i_avg'], 1)?></span>
              <i class="fas fa-"><?php echo $genre ?></i>

            </div>
          </div>
        </a>
        <?php
      }
    ?>
  </div>
 </div>
