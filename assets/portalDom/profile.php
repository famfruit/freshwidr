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
      $admStatus = $row['admin'];
      $badge = json_decode($row['priv'], true);
      ?>

      <div class="section profile">
        <div class="usertop">
          <div class="profileimg" style="display:none">
            <span><strong></strong></span>
          </div>

          <h1><?php echo $name ?></h1>
          <div class="badges">
            <?php

                $badgeArr = [];
                if($badge[0] != 9){
                  foreach($badge as $key => $value){
                    foreach($main->privs as $k => $v){
                      if($value == $k){
                        array_push($badgeArr, $v);
                      }
                    }
                  }
                } else {
                  $tarr = [1, 0, 3];
                  foreach($tarr as $key => $value){
                    foreach($main->privs as $k => $v){
                      if($value == $k){
                        array_push($badgeArr, $v);
                      }
                    }
                  }
                  #array_push($badgeArr, $app);
                }
                foreach($badgeArr as $key => $value){
                  ?>
                  <span class="type <?php echo $value?>"><?php echo $value ?></span>
                  <?php
                }
            ?>
          </div>
        </div>


      <?php
        if($main->profilePage == 'overview'){

          ?>
          <div class="profileCat">
            <a href="?profile=overview">
              <span class="active">Invites</span>
            </a>
            <a href="?profile=news">
              <span>Nyheter</span>
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
                        $r = "AKTIV";
                      } else {
                        $pref = "off";
                        $p = "INAKTIV";
                        $r = $p." (".strtoupper($row['reguser']).")";
                      }

                    ?>
                    <table class="<?php echo $pref ?>">
                      <tr>
                        <td class="status on"><?php echo $r ?></td>
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
            <a href="?profile=news">
              <span>Nyheter</span>
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

              <h2>Rensa cookies</h2>
              <p class="semi">Vi användar oss av cookies för att göra dina rekomendationer personliga och spara din historik.<strong> Genom att rensa våra cookies försvinner all din historik, samt dina  rekomendationer återställs till det vanliga och det går inte att återställa.</strong></p>
              <form method="post">
                <button class="submbtn" type="submit" name="clearCookies">Töm Cookies</button>
              </form>
            </div>
          <?php
        } else if ($main->profilePage == 'news'){
          ?>
          <div class="profileCat">
            <a href="?profile=overview">
              <span class="">Invites</span>
            </a>
            <a href="?profile=news">
              <span class="active">Nyheter</span>
            </a>
            <a href="?profile=settings">
              <span>Inställningar</span>
            </a>
          </div>
          <div class="section prflContent" id="news">
            <div class="newssection">
              <h2>Läs detta, viktigt!</h2>
              <span>2019-10-20 18:10 &#8226; <strong>ADMIN</strong></span>

              <div class="textarea">
                <h2>Telly 0.1.0 är live!</h2>
                <p>Telly är nu live och vi är väldigt glada att presentera alpha versionen! Vi kommer inom kort tid släppa en rad förbättringar. ** är byggt på en rad sofistikerade bottar och serverar som konstant scannar internet för nya filmer och serier samt kvalitesförbättringar på redan stående videos. Detta innebär att inom första tiden kommer vissa saker behövas se över manuellt tills systemet kommer ikapp. </p>

                <h2>Automatiska System</h2>
                <p>Våra system står på 24 timmar om dygnet, 7 dagar i veckan och gör konstant nya uppdateringar i form av förbättrade bilder och filmer samt lägger till allt nytt som läggs upp på internet. Därav kommer du se att det automatiskt läggs till nya filmer och tv-serier, detta är ett direkt resultat och dina rekomendationer kommer ändras därefter.</p>
                <p>I skrivande stund har vi ungefär 29.000 filmer, samt 1.200 serier. Detta kommer graduellt höjas och sänkas. Detta kan bero på korrupta länkar eller bilder, dubletter osv. Våra planer inkluderar en systemöversitk där användarna kommer kunna väga in i besluten för ge automatisk vägledning.</p>

                <h2>Passiv reklamblockering  &#8226; adBlock / uBlock</h2>
                <p>Vi arbetar förbrilt och har som högsta prioritet att automatiskt blockera alla former av popups eller annonser. När videon laddas in på våran hemsida har vi just nu inte kontroll över vad som händer på uppladdarens ände. På grund av detta kommer du se reklam och popups på våran sidan, trots att dessa inte tillhör oss.</p>
                <p>Våran approach är att istället ladda in videolänken via ett filter, som reducerar uppladdarens hemsida till text som automatiskt tar bort samma typ av element som uBlock/adBlock skulle. Därefter laddas det nya innehållet utan reklam och popups in i videoelementet och resultatet blir en reklamfri upplevelse.</p>
                <p>Vi är väldigt nära klara med detta men kräver ytterligare testing då varje host är annorlunda, tillvidare <strong>BER</strong> vi er aktivera <strong>adBlock/uBlock</strong>.</p>

                <h2>Förbättringar</h2>
                <p>Inom kommande månader släpper vi nya designuppdateringar som kommer förbättra och förenka tittarupplevelsen marginellt. En liknande, men helt ny UI är in the works och kommer helt ta över denna version. I de nya uppdateringarna kommer följade att åtgärdas/poleras.<br><br> <strong>&#8226; Sök på skådespelare, direktörer och producenter</strong><br> <strong>&#8226; Avsnitt-väljare</strong><br> <strong>&#8226; A-Z Sortering</strong><br> <strong>&#8226; Universal Navigering</strong><br> <strong>&#8226; Återhämtning av inbjudningar</strong><br> <strong>&#8226; Fler parametrar i rekomendationer</strong><br> <strong>&#8226; Utbyggnad av TMDB's API</strong><br></p>

              <p class="sig">// Admin</p>
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
