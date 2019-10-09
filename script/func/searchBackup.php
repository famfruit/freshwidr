<?php
  if(isset($_GET['data'])){
    include_once 'co_p.php';
    $conn->set_charset("utf8");
    $q = $_GET["data"];
    if(strlen($q) > 0){
      $sql = "SELECT * FROM help WHERE tags LIKE '%".$_GET["data"]."%' OR title LIKE '%".$_GET["data"]."%' ORDER BY title";
      $result = mysqli_query($conn, $sql);
      while($row = mysqli_fetch_array($result)){



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
               <form method="get">
                 <button type="submit" name="g" value="<?php echo $row['ID'] ?>"><?php echo ucfirst($row['title']) ?></button>
               </form>
               <span><?php echo $row['descr'] ?></span>
             </div>


        </div>
      <?php }
    }
  } ?>
