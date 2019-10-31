<?php
      #$result = $main->personalizeRecom();
      #$winArray = [];
      #$highNum = 0;
      #while($row = mysqli_fetch_assoc($result)){
        #if($row['mc'] == 'movies'){
        #  $data = $main->getFromAPI($row['title']);
        #} else {
        #  $data = $main->getFromAPI_tv($row['title']);
        #}

        #$header = "https://image.tmdb.org/t/p/original".$data['results'][0]['backdrop_path'];
        #var_dump($header);

        #$img = "https://image.tmdb.org/t/p/w185".$row['img'];

        #    $avg = $data['results'][0]['vote_average'];
        #    if($avg > $highNum){
        #      $highNum = $avg;
        #      $winArray = [$row, $header];
        #    }

      #}

      $result = $main->personalizeRecom(1);
      while($row = mysqli_fetch_assoc($result)){
        if($row['mc'] == 'movies'){
          $data = $main->getFromAPI($row['title']);
          $trailerTag = 'movie';
          $atg = 'movie';
        } else {
          $data = $main->getFromAPI_tv($row['title']);
          $trailerTag = 'tv';
          $atg = 'serie';
        }
        $vidID = $data['results'][0]['id'];
        $vidData = "http://api.themoviedb.org/3/".$trailerTag."/".$vidID."/videos?api_key=".$main->key;

        $header = $data['results'][0]['backdrop_path'];
        $vd = json_decode(file_get_contents($vidData),true);
        $genre = $main->compileGenres($row['genre']);

      ?>
      <div class="section recom">
        <div class="overlay" style="background-image: url(<?php echo 'https://image.tmdb.org/t/p/original'.$header; ?>)"></div>

        <div class="recomContent">
          <?php
          if(sizeOf($vd['results']) != 0){
            ?>
            <div class="recVid">
              <div id="playerWrap">
                <iframe
                width="640" height="360"
                src="https://www.youtube.com/embed/<?php echo $vd['results'][0]['key'] ?>?version=3&mute=1&controls=0&rel=0&autoplay=1&enablejsapi=1&showinfo=0"
                frameborder="0"
                allowfullscreen
                muted
                ></iframe>
              </div>
            </div>
            <script>
            var playerFrame = document.currentScript.previousElementSibling.children[0].children[0];

            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            var player;
            function onYouTubeIframeAPIReady() {
              player = new YT.Player(playerFrame, {
                videoId: 'M7lc1UVf-VE',
                events: {
                  'onReady': onPlayerReady,
                  'onStateChange': onPlayerStateChange,
                  'onError': function(errEvent) {
                      var errCode = errEvent.data;
                      console.log(errCode)
                      if(errCode == 100) {
                          //
                          console.log('Show wallpaper instead')
                      } else if (errCode == 150){
                          img = $('.overlay').css('background-image')

                          console.log(img, 'Show wallpaper instead')
                      }
                  }
                }
              });
            }
            function onPlayerReady(){
            }
            var ll = document.getElementById("playerWrap").classList;
            function onPlayerStateChange(event) {
              if (event.data == YT.PlayerState.ENDED) {
                  document.getElementById("playerWrap").classList.add("shown");
              }
            }

            </script>
            <?php
          } else {
            ## Load wallpaper into recvid
            ?>
            <div class="recVid">
              <div id="playerWrap">
                <img src="<?php echo 'https://image.tmdb.org/t/p/w780'.$header; ?>" alt="">
              </div>
            </div>
            <?php
          }

           ?>


        <div class="info">

        <h1><?php echo ucfirst(str_replace("-", " ",$row['title'])) ?></h1>
        <p><?php echo $data['results'][0]['overview'] ?></p>
        <div class="headerbuttons">
          <a href="?<?php echo $atg?>=<?php echo $row['title'] ?>">
          <span class="button play">Spela upp</span>
           </a>
        </div>
        <div class="headerSpecs">
          <span class="avg"><?php echo number_format($row['i_avg'], 1)?></span>
          <i class="fas fa-theater-masks"><?php echo $genre ?></i>
        </div>
      </div>
      </div>
      <?php
      }
  ?>
</div>
