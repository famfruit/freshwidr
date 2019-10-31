  <?php
      if(isset($main->latestCookie)){
        $data = json_decode($main->latestCookie, true);
        if(sizeOf($data['movie']) == 0 && sizeOf($data['serie']) == 0){

        } else {

        ?>
          <div class="section carousel">
            <div class="scroll scrolleft hidden"></div>
            <div class="scroll scrollright"></div>
            <span class="small xxl">Titta igen</span>
            <div class="realwindow title-layout">
            <?php
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

                if($v['type'] == 'serie'){
                  $urlExtras = "&se=".$v['Spointer']."&ep=".$v['Epointer'];
                } else {
                  $urlExtras = "";
                }
                ?>
                    <a href="?<?php echo $v['type']?>=<?php echo $v['title'].$urlExtras ?>">
                      <div class="block" style="background-image: url(<?php echo $imgstring ?>)">
                        <h1 class="small"><?php echo ucfirst(str_replace("-", " ",$v['title']))?></h1>
                        <div class="headerSpecs">
                          <i class="fas famasks"><?php echo $genre ?></i>
                        </div>
                      </div>
                    </a>
                <?php
              }
            ?>
            </div>
          </div>
        <?php
      }
      }
   ?>
