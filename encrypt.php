<?php
session_start();
spl_autoload_register('autoLoadClasses');
function autoLoadClasses($className){
  $path = "classes/";
  $ext = ".class.php";
  $fullP = $path . $className . $ext;
  include_once $fullP;
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
      $hash = new hash();
      echo "Original String: ".$hash->inputString."<br><br>";
      echo $hash->encrypt($hash->inputString);
    ?>
  </body>
</html>
