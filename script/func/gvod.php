<?php
    $vod = $_GET['vod'];
    $import = file_get_contents('../../assets/localDb.json');
    $data = json_decode($import, true);
    foreach($data as $key => $value)
    {
      $s = array_search($vod, $value);
      if($s != false)
      {
          $apk = '5bea29aec07ce4f0a098fd3f9f460e4a';
          $ttId = $value['imdbID'];


        $getImages = file_get_contents('https://api.themoviedb.org/3/movie/'.$ttId.'/images?api_key='.$apk);
        $getVid = file_get_contents('https://api.themoviedb.org/3/movie/'.$ttId.'/videos?api_key='.$apk);
        $imgData = json_decode($getImages, true);
        $imgData = array_slice($imgData['backdrops'], 0, 3);
        $vidData = json_decode($getVid, true);

        $key = $vidData['results'][0]['key'];
          ?>
            <div class="targetSlide">
              <div class="videoPlayer">
                  <iframe id="ytv" frameborder="0" height="100%" width="100%"
                    src="https://youtube.com/embed/<?php echo $key ?>?autoplay=1&mute=1&controls=0&showinfo=0&autohide=1&rel=0&loop=1&playlist=<?php echo $key ?>">
                  </iframe>

              </div>
          <?php
          foreach($imgData as $k => $v)


                  {
                    $imurl = 'https://image.tmdb.org/t/p/original'.$v['file_path'];
                    if(count($imgData) > 2){
                      $m = 'class="posterImg-'.$k.'"';
                    } else {
                      $m = 'class="alone"';
                    }
                    ?>
                        <img src="<?php echo $imurl ?>" <?php echo $m ?> alt="">

                    <?php
                  }

          ?>
            <div class="topContent">
              <div class="left_tc">
                <?php
                echo '<h1>'.$value['Title'].' ('.$value['Year'].')</h1>';
                ?>
                <span><?php echo $value['Genre'] ?> | <strong><?php echo $value['Production'] ?></strong></span>
                <p><?php echo $value['Plot'] ?></p>
                <a class="button" href="https://widr.tv/produkter/ultimate">Beställ nu</a>
                <?php

                 ?>
              </div>
                <?php


                 ?>
            </div>
            </div>
          <?php

        // img url
        //

      }
    }
    
