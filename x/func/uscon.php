<?php
   include_once '../../script/func/co_p.php';
   $sql = "SELECT * FROM connections WHERE DATE(pdate) = CURDATE() ORDER BY pdate ASC";
   $result = mysqli_query($conn, $sql);
   while($row = mysqli_fetch_assoc($result))
     {

       $then = strtotime(date('Y-m-d H:i:s'));
       $now = strtotime($row['pdate']);
       $tdif = round(abs($now - $then) / 60,2);
       $sta = '';
       if($tdif > 1)
       {
         $sta = 'offline';
       } else if ($tdif < 1)
       {
         $sta = 'online';
       }
       $p = $row['page'];
       ?>
         <div class="ocBar <?php echo $sta ?>">
           <span class="fst"><?php echo $p ?></span>

           <span><?php echo $tdif. " m";?></span>
         </div>
       <?php
     }

 ?>
