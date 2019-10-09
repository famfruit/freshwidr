<?php
    if(isset($_POST['dst']))
      {
        include_once 'co_p.php';
        $path = mysqli_real_escape_string($conn, $_POST['path']);
        $addr = $_SERVER['REMOTE_ADDR'];

        echo $addr;
        $date = date('Y-m-d H:i:s');



          $sql = "SELECT * FROM connections WHERE addr = '$addr'";
          $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) > 0)
            {
              //update the row
              $sql = "UPDATE connections SET page = '$path', addr = '$addr', pdate = '$date' WHERE addr = '$addr'";
              mysqli_query($conn, $sql);
              exit;
            } else
            {
              // insert new connection
              $sql = "INSERT INTO connections VALUES (NULL, '$path', '$addr', '$date')";
              mysqli_query($conn, $sql);
              exit;
            }
      }

 ?>
