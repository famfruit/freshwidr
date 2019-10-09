  <?php
      if(isset($main->latestCookie)){
        ?>
          <div class="section last">
            <span class="small">Titta igen</span>
            <div class="title-layout">
            <?php
              $data = json_decode($main->latestCookie, true);
              $globalarray = array();
              # Stack each category as one array instead of seperate
              foreach($data as $i => $ii){
                foreach($ii as $x => $xx){
                  array_push($globalarray, $xx);
                }
              }

              # Sort them by amount of clicks
              ## Sort the arrays by highest clicks
              usort($globalarray, function($a, $b) {
                  return $a['clicks'] <=> $b['clicks'];
              });
              $globalarray = array_reverse($globalarray);

              # Now render the titles
              foreach($globalarray as $k => $v){
                $imgstring = "https://image.tmdb.org/t/p/w185".$v['img'];
                ?>
                    <a href="?<?php echo $v['type']?>=<?php echo $v['title'] ?>">
                      <div class="block" style="background-image: url(<?php echo $imgstring ?>)">
                        <h1 class="small"><?php echo ucfirst(str_replace("-", " ",$v['title']))?></h1>
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
