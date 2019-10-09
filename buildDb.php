<?php
  session_start();
  spl_autoload_register('autoLoadClasses');
  function autoLoadClasses($className){
    $path = "classes/";
    $ext = ".class.php";
    $fullP = $path . $className . $ext;
    include_once $fullP;
  }
  $sqlPrefix = "movies_test";
  $main = new netflix();
  $sql = "SELECT * FROM $sqlPrefix WHERE releasedate IS NULL OR releasedate = ''";
  $result = mysqli_query($main->con, $sql);
  var_dump($result->num_rows);
  if($result->num_rows > 0){
    while($row = mysqli_fetch_assoc($result)){
      if($main->buildDatabase($row['title']) != null){
        $array = $main->buildDatabase($row['title']);
        $img = $array['poster_path'];
        $reldate = $array['release_date'];
        $genres = json_encode($array['genre_ids']);
      } else {
        $img = 'null';
        $genres = 'null';
      }

      $id = $row['id'];
      $sql = "UPDATE $sqlPrefix SET img = '$img', genre = '$genres', releasedate = '$reldate' WHERE id = $id";
      mysqli_query($main->con, $sql);
    }
  } else {
    echo "Didnt find anything";
  }
