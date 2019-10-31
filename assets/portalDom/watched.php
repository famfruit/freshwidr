<?php
  if(isset($main->latestCookie)){
    $data = json_decode($main->latestCookie, true);

    if(sizeOf($data['movie']) != 0){

    }
    ?>
        <?php
        foreach($data as $key => $type){
          $tag = '';
          if($key == 'movie') { $tag = 'filmer'; } else if ($key == 'serie') { $tag = 'serier'; }
          if(!empty($type)){

          ?>
            <div class="section carousel">
            <div class="scroll scrolleft hidden"></div>
            <div class="scroll scrollright"></div>
            <span class="small xxl">tidigare <?php echo $tag ?></span>
            <div class="realwindow title-layout">
             <?php
               ## Sort the arrays by highest clicks
               usort($type, function($a, $b) {
                   return $a['clicks'] <=> $b['clicks'];
               });
               $type = array_reverse($type);
               foreach($type as $k => $v){
                 if($v['type'] == 'serie'){
                   $urlExtras = "&se=".$v['Spointer']."&ep=".$v['Epointer'];
                 } else {
                   $urlExtras = "";
                 }
                ?>
                <a href="<?php echo "?".$key."=".$v['title'].$urlExtras ?>">
                  <div class="block" style="background-image: url(<?php echo 'https://image.tmdb.org/t/p/w185'.$v['img'] ?>)">
                    <h1 class="small"><?php echo ucfirst(str_replace("-", " ", $v['title'])) ?></h1>
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

    <?php
  } else {
    return false;
  }
?>
