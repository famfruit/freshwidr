<?php
   include_once 'co_p.php';
   $user = mysqli_real_escape_string($conn, $_POST['user']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);

   if(!isset($_POST['s'])){
     header('Location: https://www.widr.tv?');
     return false;
     exit;
   } else {

     $vkey = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,10))),1,10);
     $btc = 'none';
     $date = date("Y-m-d H:i:s");

     $sql = "INSERT INTO `orders` (`orderID`, `orderType`, `order`, `referal`, `setPrice`, `time`, `payMethod`, `couponID`, `couponInput`, `couponValue`, `finalValue`, `v_key`, `existingCostumer`, `username`, `email`, `country`, `r_addr`, `address`, `date`, `completed`, `date_completed`) VALUES (NULL, 'pta', 'trial', NULL, 'free', '1 dag', 'free', NULL, NULL, NULL, 'free', '$vkey', '0', '$user', '$email', 'Sweden', NULL, '$btc','$date', 0, NULL)";
     mysqli_query($conn, $sql);

     echo 'stru';

   }
