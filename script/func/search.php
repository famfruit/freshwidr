<?php
  if(isset($_GET['data'])){
    include_once 'co_p.php';
    $conn->set_charset("utf8");
    $q = $_GET["data"];
    if(strlen($q) > 0){
      $sql = "SELECT * FROM help WHERE tags LIKE '%".$_GET["data"]."%' OR title LIKE '%".$_GET["data"]."%' ORDER BY views DESC";
      $result = mysqli_query($conn, $sql);
      while($row = mysqli_fetch_array($result)){

        $comCount = sizeOf(json_decode($row['usercontent'], true)['comments']);
        $viewCount = $row['views'];

        $type = $row['type'];
        ?>
        <div class="resBar">
            <?php
              if($type == 'guide')
              {
                $i = 'fas fa-book';
              } else if ($type == 'faq')
              {
                $i = 'far fa-comments';
              } else if ($type == 'issue')
              {
                $i = 'fas fa-screwdriver';
              }
             ?>
             <div class="icon">
               <i class="<?php echo $i ?>"></i>
             </div>
             <div class="info">
               <a href="<?php echo $type ?>/<?php echo $row['url_tag'] ?>"><?php echo ucfirst($row['title']) ?></a>

               <span><?php echo $row['descr'] ?></span>
               <div class="contentInfo">
                   <span id="c"><?php echo $comCount ?></span>
                   <span id="v"><?php echo $viewCount?></span>
               </div>
             </div>


        </div>
      <?php }
    }
  } ?>
