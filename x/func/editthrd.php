<?php
    $text = $_POST['text'];
    $title = $_POST['title'];
    $cat = $_POST['cat'];
    $tag = $_POST['tag'];
    $desc = $_POST['desc'];
    $type = $_POST['type'];
    $url = $_POST['url'];
    $id = $_POST['id'];

    include_once '../../script/func/co_p.php';
    $conn->set_charset("utf8");
    $sql = "UPDATE help SET title = '$title', cat = '$cat', tags = '$tag', type = '$type', `text` = '$text', descr = '$desc', url_tag = '$url'  WHERE ID = '$id'";

    if(mysqli_query($conn, $sql) != 0 || false)
      {
        mysqli_query($conn, $sql);
      } else {
        echo 0;
      }
 ?>
