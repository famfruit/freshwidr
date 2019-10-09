<?php
    $title = $_POST['title'];
    $cat = $_POST['cat'];
    $type = $_POST['type'];
    $text = $_POST['text'];
    $descr = $_POST['desc'];
    $url_tag = $_POST['tag'];
    include_once '../../script/func/co_p.php';
    $conn->set_charset("utf8");
    $sql = "INSERT INTO help VALUES (NULL, '$title', '$cat', 'unset', '$type', '$text', '$descr', '$url_tag')";
    mysqli_query($conn, $sql);
      if(!mysqli_query($conn, $sql))
        {
          echo 0;
        }
        else
        {
          echo 1;
        }
 ?>
