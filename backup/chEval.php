<?php
function spamFilterOrd($mail){
  $banlist = [
    "lol",
    "test",
    "asdf",
    "123",
    "swag",
    "aaa",
    "sss",
    "bbb",
    "ccc",
    "qwerty",
    "rofl"
  ];
  $inputMail = $mail;
  $inputMail = explode("@", $inputMail);
  $p1 = $inputMail[0];
  $p2 = explode(".", $inputMail[1])[0];
  $pong = 0;
  foreach($banlist as $key => $value)
  {
    if($value === $p1)
    {
      $pong++;
    }
    if($value === $p2)
    {
      $pong++;
    }
  }
  return $pong;
}
  if(!($_POST['set'])){
    header('Location: ../?504');
    exit;
  } else {
    include_once 'co_p.php';
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    ## run retardscript to keep idiots out
    if(spamFilterOrd($email) != 0){
      header('Location: ../../?305');
      exit;
    }
    ## johan.soderstrom72@gmail.com
    ## johan.soderstrom72@gmail.com
    ## johan.soderstrom72@gmail.com
    //usersql
    $sql = "SELECT * FROM users WHERE user = '$user'";
    $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) > 0)
        {
          //costumer already exists
          $existing = 1;
        }
        else
        {
          //this is a new costumer
          $existing = 0;
          $sql = "INSERT INTO users VALUES (NULL, '$user', '$email', '$country')";
          mysqli_query($conn, $sql);
        }
        //user dealt with - continue
        $product = mysqli_real_escape_string($conn, $_POST['prod']);
        $sql = "SELECT * FROM products WHERE product = '$product'";
        $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) > 0)
            {
              while($row = mysqli_fetch_assoc($result))
                   {
                     if($method === 'swish'){
                       $usql = "SELECT * FROM wallet WHERE used = 0 AND blocked = 0 LIMIT 1";
                     } else if($method === 'bitcoin'){
                       $usql = "SELECT hash, used FROM wallet WHERE used = 0 LIMIT 1";
                     }
                     $res = mysqli_query($conn, $usql);
                     if(mysqli_num_rows($res) == 0)
                      {
                        $btc = '1BSw68muChMNHF8aa7X3FEee64FcmAhfZ8';
                      } else
                        {
                          while($bt = mysqli_fetch_assoc($res))
                          {
                            $btc = $bt['hash'];
                          }
                        }
                     if($row['product'] === 'trial'){
                       $btc = 'none';
                     }
                     $date = date("Y-m-d H:i:s");
                     $vkey = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,10))),1,10);
                     $type = $row['productType'];
                     $prod = $row['product'];
                     $price = $row['productPrice'];
                     $time = $row['productTime'];
                     $sql = "INSERT INTO `orders` (`orderID`, `orderType`, `order`, `referal`, `setPrice`, `time`, `payMethod`, `couponID`, `couponInput`, `couponValue`, `finalValue`, `v_key`, `existingCostumer`, `username`, `email`, `country`, `r_addr`, `address`, `date`, `completed`, `date_completed`) VALUES (NULL, '$type', '$prod', NULL, '$price', '$time', '$method', NULL, NULL, NULL, '$price', '$vkey', '$existing', '$user', '$email', '$country', NULL, '$btc','$date', 0, NULL)";
                     mysqli_query($conn, $sql);
                     if($row['product'] != 'trial'){
                       if($method == 'swish'){
                          $updsql = "UPDATE wallet SET used = 1, blocked = 1 WHERE hash = '$btc'";
                        } else if($method === 'bitcoin'){
                          $updsql = "UPDATE wallet SET used = 1 WHERE hash = '$btc'";
                        }
                       mysqli_query($conn, $updsql);
                     }
                     session_start();
                     $_SESSION['orderStatus'] = true;
                     $_SESSION['type'] = $row['productType'];
                     $_SESSION['order'] = $row['product'];
                     $_SESSION['referal'] = '';
                     $_SESSION['price'] = $row['productPrice'];
                     $_SESSION['time'] = $row['productTime'];
                     $_SESSION['paymethod'] = $method;
                     $_SESSION['couponID'] = '';
                     $_SESSION['couponInput'] = '';
                     $_SESSION['couponValue'] = '';
                     $_SESSION['finalValue'] = '';
                     $_SESSION['v_key'] = $vkey;
                     $_SESSION['e_c'] = '';
                     $_SESSION['username'] = '';
                     $_SESSION['email'] = '';
                     $_SESSION['country'] = '';
                     $_SESSION['r_addr'] = '';
                     $_SESSION['date'] = '';
                     echo $vkey;
                     exit;
                   }
            }
  }
