<?php
    include_once 'co_p.php';
    $sql = "SELECT logdate FROM a";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result))
      {
        $start_date = $row['logdate'];
        $to_time = strtotime($row['logdate']);
        $from_time = strtotime(date('Y-m-d H:i:s'));
        $etaTimer = round(abs($to_time - $from_time) / 60,2);
      }
