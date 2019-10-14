<?php
  $profile = json_decode($main->loginCookie, true);
  $ecpw = $profile['ecpw'];
  $id = (int)$profile['id'];
  $sql = "SELECT * FROM clients WHERE id = $id";
  $result = $main->getFromMysql($sql);
  if(mysqli_num_rows($result) == 0){
    # Send to hell
  } else {
    while($row = mysqli_fetch_assoc($result)){
      $invites = (int)$row['invites']; // Cast to int for later
      $name = $row['name'];
      ?>

      <div class="section profile">
        <div class="usertop">
          <div class="profileimg" style="display:none">
            <span><strong></strong></span>
          </div>
          <h1><?php echo $name ?></h1>
          <span class="type">Lifetime</span>
        </div>


      <?php
        if($main->profilePage == 'overview'){


          ?>
          <div class="profileCat">
            <a href="?profile=overview">
              <span class="active">Invites</span>
            </a>
            <a href="?profile=settings">
              <span>Inställningar</span>
            </a>
          </div>
          <div class="section prflContent" id="overview">
            <?php
            if($invites != 0){
                ?>
                <div class="btnhloader">
                  <div class="lpos">
                    <span>Skapar nyckel<div id="d1">.</div><div id="d2">.</div><div id="d3">.</div></span></div>
                  </div>
                  <div class="btnh round">
                    <span class="remaind"><?php echo $invites ?><strong>Kvar</strong></span>
                  </div>

                  <div class="hdnlink">
                    <span class="lnk">https://widr.tv/p/<strong class="invdata"></strong></span>
                    <p class="disc">Utgångsdatum: <strong  class="invdata"></strong></p>
                  </div>


                  <h2>Bjud in dina vänner</h2>
                  <p class="semi">Klicka ovan för att generera en länk du kan bjuda in vem du vill med. Länken förstörs efter att den använts, eller efter en viss tid.</p>

                <?php

            } else {
              ?>
              <h2>Bjud in dina vänner</h2>
              <p class="semi">Du har tyvärr inga invites kvar. Kolla nedan om du har någon länk som fortfarande är aktiv.</p>

              <?php
            }
            ?>
            <div class="refhistory">
                <?php

                  $sql = "SELECT * FROM invites WHERE ref = '$name'";
                  $result = $main->getFromMysql($sql);
                  while($row = mysqli_fetch_assoc($result)){
                      if($row['status'] == 0){
                        $pref = "on";
                        $p = "AKTIV";
                      } else {
                        $pref = "off";
                        $p = "INAKTIV";
                      }

                    ?>
                    <table class="<?php echo $pref ?>">
                      <tr>
                        <td class="status on"><?php echo $p ?></td>
                        <td class="key"><?php echo $row['vkey'] ?></td>
                        <td class="date"><?php echo $row['date']?></td>
                      </tr>
                    </table>
                    <?php
                  }

                ?>
            </div>
          </div>
          <?php


        } else if ($main->profilePage == 'settings'){
          ?>
          <div class="profileCat">
            <a href="?profile=overview">
              <span class="">Invites</span>
            </a>
            <a href="?profile=settings">
              <span class="active">Inställningar</span>
            </a>
          </div>
            <div class="section prflContent" id="settings">
              <h2>Användarinställningar</h2>
              <div class="inputContainer static">
                <span class="unlockinput uilocked">Lås upp</span>
                <div class="inputwrapper">
                  <input class="input usr" id="keepthis" type="text" name="username" value="<?php echo $name ?>" readonly="readonly">
                  <span class="lbl">Användarnamn</span>
                </div>
                <div class="inputwrapper">
                  <input class="input eml"  type="text" name="email" value="<?php echo $row['email'] ?>" readonly="readonly">
                  <span class="lbl">Email</span>
                </div>
                <div class="inputwrapper">
                  <span class="showbtn shbtnfpw"></span>
                  <input class="input pw"   type="password" name="password" value="<?php echo $ecpw ?>" readonly="readonly">
                  <span class="lbl">Nytt Lösenord</span>
                </div>

                <div class="buttons">
                  <div class="btnh">
                    <span class="button cnfChanges" data-userid="<?php echo $row['id'] ?>">Verkställ</span>
                  </div>
                  <div class="btnh">
                    <span class="button res">Avbryt</span>
                  </div>
                </div>
              </div>
            </div>
          <?php
        }
      ?>

      </div>


      <?php
    }
  }
?>
