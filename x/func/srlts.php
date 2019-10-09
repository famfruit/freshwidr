<?php
function humanTiming ($time)
        {
            $time = time() - $time; // to get the time since that moment
            $time = ($time<1)? 1 : $time;
            $tokens = array (
                31536000 => 'y',
                2592000 => 'mo',
                604800 => 'w',
                86400 => 'd',
                3600 => 'h',
                60 => 'm',
                1 => 's'
            );

            foreach ($tokens as $unit => $text) {
                if ($time < $unit) continue;
                $numberOfUnits = floor($time / $unit);
                return $numberOfUnits.''.$text.(($numberOfUnits>1)?'':'');
            }
        }

  include_once '../../script/func/co_p.php';
  $conn->set_charset("UTF8");
  $table = $_POST['table'];
  $id = $_POST['id'];

   ?>
   <span class="goback">Search | <?php echo ucfirst($table) ?> | <strong><?php echo $id ?></strong></span>

   <?php
    if($table == 'orders'){
      $sql = "SELECT * FROM orders WHERE v_key = '$id'";
    } else if ($table == 'support'){
      $sql = "SELECT * FROM support WHERE id = '$id'";
    }
    $result = mysqli_query($conn, $sql);
      while($row = mysqli_fetch_assoc($result))
        {
          //predefine shit
          if($table == 'orders')
          {
            ?>
            <div class="userInfo">
              <div class="prodBig" id="<?php echo $row['order'] ?>">

              </div>

              <table id="f">
                <tr>
                  <td class="first">id</td>
                  <td class="data"><?php echo $row['orderID']?></td>
                </tr>
                <tr>
                  <td class="first">referns</td>
                  <td class="data"><?php echo $row['v_key'] ?></td>
                </tr>
                <tr>
                  <td class="first">datum</td>
                  <td class="data"><?php echo $row['date'] ?></td>
                </tr>
                <tr>
                  <td class="first">användare</td>
                  <td class="data"><?php echo $row['username'] ?></td>
                </tr>
                <tr>
                  <td class="first">email</td>
                  <td class="data"><?php echo $row['email'] ?></td>
                </tr>
                <tr>
                  <td class="first">land</td>
                  <td class="data"><?php echo $row['country'] ?></td>
                </tr>
              </table>
              <table>
                <tr>
                  <td class="first">IP</td>
                  <td class="data"><?php echo $row['r_addr'] ?></td>
                </tr>
                <tr>
                  <td class="first">time</td>
                  <td class="data"><?php echo $row['orderID']?></td>
                </tr>
                <tr>
                  <td class="first">produkt</td>
                  <td class="data"><?php echo $row['orderType'] ?></td>
                </tr>
                <tr>
                  <td class="first">pris</td>
                  <td class="data"><?php echo $row['setPrice'] ?></td>
                </tr>
                <tr>
                  <td class="first">adress</td>
                  <td class="data"><?php echo $row['address'] ?></td>
                </tr>
                <tr>
                  <td class="first">betalningsmetod</td>
                  <td class="data"><?php echo $row['payMethod'] ?></td>
                </tr>
              </table>
            </div>
            <?php

          } else {
            ?>
              <div class="msgcontent">
                <span class="time"><?php echo humanTiming(strtotime($row['date']))?></span>
                <span class="name"><?php echo $row['name'] ?></span>
                <span class="email"><?php echo $row['email'] ?></span>
                <div class="textcontent">
                    <?php echo $row['comment'] ?>
                </div>
              </div>
            <?php
          }

        }
        die;
    ?>


    <!-- keep bot -->
    <script src="js/gbk.js"></script>
    <?php

?>
