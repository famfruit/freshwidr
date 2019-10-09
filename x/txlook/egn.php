<?php
  #get all orders, put in array with id, hash,
  session_start();
if(isset($_COOKIE['admLogin']) && $_COOKIE['admLogin'] == 1) {
  if(isset($_POST['evalArray'])){
    # get new array
      include_once '../../script/func/co_p.php';
      $sql = "SELECT * FROM orders WHERE completed = 0";
      $res = mysqli_query($conn, $sql);
      $arr = array("lastUpdate" => date("Y-m-d H:i:s"), "data" => []);
      while($row = mysqli_fetch_assoc($res)){
        if($row['order'] != 'trial'){
          #var_dump($row);
          $url = "https://blockchain.info/q/addressbalance/".$row['address'];
          $get = JSON_decode(file_get_contents($url));
          $lcArr = array(
            "hash" => $row['address'],
            "id" => $row['v_key'],
            "value" => $get
          );
          array_push($arr['data'], $lcArr);
        }
      }
      echo JSON_encode($arr, true);
    }
    ###
} else {
  header('Location: ../../?gtfo');
  exit;
}
