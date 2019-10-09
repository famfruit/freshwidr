<?php
  $folderPrefix = "movtrue";
  $sqlPrefix = "movies_test";

  $con = mysqli_connect('localhost', 'root', '', 'media');
  $files = glob('../../../netflix/'.$folderPrefix.'/*.{json}', GLOB_BRACE);
  foreach($files as $file) {
    //do your work here
    $f = file_get_contents($file);
    $file = str_replace("../../../netflix/".$folderPrefix."/", "", $file);
    $file = str_replace(".json", "", $file);

    #$sql = "SELECT title FROM $sqlPrefix WHERE match(title) AGAINST ('$file' IN BOOLEAN MODE)";

    $sql = "SELECT title FROM $sqlPrefix WHERE title = '$file'";
    $result = mysqli_query($con, $sql);
      if(mysqli_num_rows($result) != 0){
        return false;
    } else {
      $sql = "INSERT INTO $sqlPrefix (title, source, img, genre, views, likes, releasedate) VALUES ('$file', '$f', '', '', 0, 0, '')";

      mysqli_query($con, $sql);

    }


  }
?>
