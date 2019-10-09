<?php
if(isset($_POST['send']))
  {
    include_once 'script/func/co_p.php';
    $conn->set_charset("utf8");
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    if(empty($name) || empty($email) || empty($comment))
      {
        echo 'E0'; // error 0 = first decline
        exit;
      }
      else
      {
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO support VALUES (NULL, '$name', '$email', '$comment', '$date')";
        mysqli_query($conn, $sql);
        echo 'S1'; // successful
        exit;
      }
  }
