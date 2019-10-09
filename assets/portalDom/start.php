<div class="section">
  <span class="small xxl">Nya Serier & Filmer</span>
  <div class="title-layout">
    <?php
    $result = $main->getFromMysql("SELECT * FROM series ORDER BY releasedate DESC LIMIT 10");
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
  </div>
</div>
<div class="section">
  <span class="small xxl">Populäraste Filmer & Serier</span>
  <div class="title-layout">
    <?php
    $result = $main->getFromMysql("SELECT * FROM series ORDER BY views DESC LIMIT 10");
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
</div>
