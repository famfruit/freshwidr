<?php
  if(isset($_POST['s']))
    {
      include_once '../../script/func/co_p.php';
      $oldNum = mysqli_real_escape_string($conn, $_POST['oldNum']);
      $sql = "SELECT * FROM orders ORDER BY date DESC";
      $result = mysqli_query($conn, $sql);

      $newCount = mysqli_num_rows($result);


        if($newCount > $oldNum)
          {
            #
            echo $newCount - $oldNum;
          }
          else
          {
            echo 'f';
          }
    }
 ?>
