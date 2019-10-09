<?php
    if(!isset($_POST['auth']))
      {
        header('Location: index.php?dafuqyoudoin');
      } else
      {
        //auth is set
        session_start();
        include_once '../script/func/co_p.php';
        $user = mysqli_real_escape_string($conn, $_POST['user']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);
        $key = mysqli_real_escape_string($conn, $_POST['key']);

        $sql = "SELECT * FROM a";
        $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) < 0)
            {
              echo 'No entries in DB';
            } else
            {
              while($adm = mysqli_fetch_assoc($result))
                {
                  $au = password_verify($user, $adm['user']);
                  $ap = password_verify($pass, $adm['password']);
                  $ak = password_verify($key, $adm['authkey']);
                  if($au == true && $ap == true && $ak == true) {
                    echo 1;
                    $date = date('Y-m-d H:i:s');
                    $sql = "UPDATE a SET logdate = '$date' WHERE ID = 1";
                    mysqli_query($conn, $sql);
                    $_SESSION['admAuth'] = true;
                    $cookie_name = "admLogin";
                    $cookie_value = 1;
                    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
                  } else {
                    $_SESSION['admAuth'] = false;
                    echo 0;
                  }
                }
            }

      }
 ?>
