<?php
  if(isset($_POST['s']))
    {
      include_once '../../script/func/co_p.php';
      $oldNum = mysqli_real_escape_string($conn, $_POST['oldNum']);
      $sql = "SELECT * FROM orders ORDER BY date DESC";
      $result = mysqli_query($conn, $sql);

      $newCount = mysqli_num_rows($result);


        if($newCount > $oldNum)
          {
            $limit = $newCount - $oldNum;
            $sql = "SELECT * FROM orders ORDER BY date DESC LIMIT $limit";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result))
                            {
                          $status = $row['completed'];
                          if($status == 0)
                            {$st = 'Pending';}
                          else if
                          ($status == 1)
                            {$st = 'Completed';}
                ?>
                  <div class="orderBar newBar">
                    <span><?php echo $row['v_key'] ?></span>
                    <span><?php echo $row['order'] ?></span>
                    <span><?php echo $row['email'] ?></span>
                    <span><?php echo $row['setPrice'] ?></span>
                    <span>Unset</span>
                    <span>Recurring</span>
                    <span>10 Min ago</span>
                    <span class="stBar <?php echo $st ?>"><?php echo $st ?></span>
                    <div class="clAb"></div>
                    <div class="addInfo hidden">
                        <div class="inputs">
                          <input type="hidden" name="ordid" value="<?php echo $row['v_key'] ?>">
                          <input type="text" name="username" value="<?php echo $row['username'] ?>">
                          <input type="text" name="password" value="" placeholder="Lösenord">
                          <input type="hidden" name="eml" value="<?php echo $row['email'] ?>">
                          <button class="procBtn" type="submit" name="process">Behandla</button>

                        </div>
                    </div>
                  </div>
                  <script src="js/proccOrd.js"></script>
                <?php
              }
          }
          else
          {
            echo 'f';
          }
    }
 ?>
