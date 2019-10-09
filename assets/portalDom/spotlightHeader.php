<div class="section header">
  <?php
     $esql = "SELECT title FROM spotlight WHERE prio = 1";
     $res = $main->getFromMysql($esql);
     $stitle = "";
     while($spot = mysqli_fetch_assoc($res)){
       $stitle = $spot['title'];
     }
       $sqlPrefix = "series";
       $result = $main->getFromMysql("SELECT * FROM $sqlPrefix WHERE title = '$stitle'");
       while($row = mysqli_fetch_assoc($result)){
         $api = $main->getFromAPI_tv($row['title'])['results'][0];
         $genre = $main->compileGenres($row['genre']);
         $release = $api['first_air_date'];
         $imdbID = $api['id'];
         $img_1 = $api['backdrop_path'];
         $img_2 = $api['poster_path'];
         $out = strlen($api['overview']) > 220 ? substr($api['overview'],0,220)."..." : $api['overview'];

         $trailerPrefix = "";
         if($sqlPrefix == 'series'){
           $trailerPrefix = 'tv';
         } else if ($sqlPrefix == 'movies'){
           $trailerPrefix = 'movie';
         }
         $trailerUrl = "http://api.themoviedb.org/3/".$trailerPrefix."/".$imdbID."/videos?api_key=".$main->key;
         $trailerData =  json_decode(file_get_contents($trailerUrl), true);

         $videolink = "https://www.youtube.com/embed/".$trailerData['results'][0]['key']."/?autoplay=1&mute=0&controls=0&showinfo=0&autohide=1&rel=0";
         ?>
         <div class="header">
           <span class="vidtoggle button pause"></span>
           <div class="trailer_video">

            <video class="trvid_src" src="" data-trailersrc="assets/spotlight/<?php echo $stitle ?>.mp4" autoplay muted>

             </video>

             </video>
           </div>
           <div class="headercontents">
             <img class="spotlog" src="assets/spotlight/<?php echo $stitle ?>.webp" alt="">
             <h1><?php echo ucfirst(str_replace("-", " ",$row['title'])) ?></h1>
             <p><?php echo $out ?></p>
             <div class="headerbuttons">
               <a href="?serie=<?php echo $row['title'] ?>">
               <span class="button play">Spela upp</span>
                </a>
               <span class="button info">Mer info</span>
             </div>
             <div class="headerSpecs">
               <i class="fas fa-theater-masks"><?php echo $genre ?></i>
             </div>
           </div>



           <div class="overlay"></div>
           <img src="https://image.tmdb.org/t/p/original<?php echo $img_1?>" alt="">
         </div>
         <?php
       }
  ?>
</div>
