<?php

    include_once '../../script/func/co_p.php';
    $date = date('Y-m-d H:i:s');
    $sql = "UPDATE a SET logdate = '$date' WHERE ID = 1";
    mysqli_query($conn, $sql);
    exit;
  ?>
