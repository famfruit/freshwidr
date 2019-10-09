<?php
  if(isset($_GET['data'])){
    include_once '../../script/func/co_p.php';
    $conn->set_charset("utf8");
    $q = $_GET["data"];
    if(strlen($q) > 0){
      $oc = 0;
      $sql = "SELECT * FROM orders WHERE username LIKE '%".$_GET["data"]."%' OR date LIKE '%".$_GET["data"]."%' OR email LIKE '%".$_GET["data"]."%' or orderID like '%".$_GET["data"]."%'";
      //$sql = "SELECT * FROM help WHERE tags LIKE '%".$_GET["data"]."%' OR title LIKE '%".$_GET["data"]."%' ORDER BY title";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) > 0)
        {
          echo '<div class="break">'.mysqli_num_rows($result).' <strong>Orders Matched</strong></div>';
        }
      while($row = mysqli_fetch_array($result)){

        $oc++;

        ?>
        <div class="resBar" id="rsb_order">
            <input type="hidden" value="orders">
            <span class="first"><?php echo '#'.$row['v_key'] ?></span>
            <span class="sec"><?php echo ucfirst($row['order']) ?></span>
            <span><?php echo $row['email'] ?></span>
            <span><?php echo $row['date'] ?></span>
            <span><?php

                if($row['completed'] == 0){
                  echo 'Pending';
                } else {
                  echo 'Completed';
                }

             ?></span>
            <span><?php echo $row['setPrice'] ?>kr</span>


        </div>
      <?php

      }

      $ec = 0;
      $sql = "SELECT * FROM users WHERE user LIKE '%".$_GET["data"]."%' OR email LIKE '%".$_GET["data"]."%'";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) > 0)
        {
          echo '<div class="break">'.mysqli_num_rows($result).' <strong>Users Matched</strong></div>';
        }
      while($row = mysqli_fetch_array($result)){
        $ec++;
        ?>
        <div class="resBar" id="rsb_order">
            <input type="hidden" value="users">
            <span class="first"><?php echo '#'.$row['ID'] ?></span>
            <span><?php echo ucfirst($row['user']) ?></span>
            <span><?php echo $row['email'] ?></span>
            <span><?php echo $row['country'] ?></span>
            <span>N/A</span>
            <span>N/A</span>


        </div>
      <?php }

      $sc = 0;
      $sql = "SELECT * FROM support WHERE name LIKE '%".$_GET["data"]."%' OR email LIKE '%".$_GET["data"]."%'";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) > 0)
        {
          echo '<div class="break">'.mysqli_num_rows($result).' <strong>Tickets Matched</strong></div>';
        }
      while($row = mysqli_fetch_array($result)){
        $sc++;
        $string = $row['comment'];
        $string = (strlen($string) > 40) ? substr($string,0,40).'...' : $string;
        ?>
        <div class="resBar" id="rsb_order">
            <input type="hidden" value="support">
            <span class="first"><?php echo '#'.$row['id'] ?></span>
            <span><?php echo ucfirst($row['name']) ?></span>
            <span><?php echo $row['email'] ?></span>
            <span><?php echo $string ?></span>
            <span><?php echo $row['date'] ?></span>
            <span>N/A</span>


        </div>

      <?php }
      ?>

      <?php
    }
  } ?>
