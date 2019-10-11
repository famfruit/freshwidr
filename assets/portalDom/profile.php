<div class="section profile">
  <div class="usertop">
    <div class="profileimg" style="display:none">
      <span><strong></strong></span>
    </div>
    <h1>username</h1>
    <span class="type">premium</span>
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
      <div class="btnh round">
        <span>5<strong>Kvar</strong></span>
      </div>

      <div class="hdnlink">
        <span class="lnk">https://widr.tv/p/<strong>ashdj3984</strong></span>
        <p class="disc">Utgångsdatum: <strong>2019-10-11 22:00</strong></p>
      </div>


      <h2>Bjud in dina vänner</h2>
      <p class="semi">Klicka ovan för att generera en länk du kan bjuda in vem du vill med. Länken förstörs efter att den använts, eller efter en viss tid.</p>
      <div class="refhistory">
        <table class="on">
          <tr>
            <td class="status on">AKTIV</td>
            <td class="key">AJ3D4U0E1H</td>
            <td class="date">2918-10-11 22:00</td>
          </tr>
        </table>
        <table class="off">
          <tr>
            <td class="status off">INAKTIV</td>
            <td class="key">Z11XCC00DA</td>
            <td class="date">2918-10-08 13:22</td>
          </tr>
        </table>
        <table class="off">
          <tr>
            <td class="status off">INAKTIV</td>
            <td class="key">L5E5PD1LE4</td>
            <td class="date">2918-10-07 14:55</td>
          </tr>
        </table>
        <table class="off">
          <tr>
            <td class="status off">INAKTIV</td>
            <td class="key">Q1PE1KD1KL</td>
            <td class="date">2918-09-29 18:58</td>
          </tr>
        </table>
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
            <input class="input usr"  type="text" name="username" value="admin" readonly="readonly">
            <span class="lbl">Användarnamn</span>
          </div>
          <div class="inputwrapper">
            <input class="input eml"  type="text" name="email" value="admin@admin.com" readonly="readonly">
            <span class="lbl">Email</span>
          </div>
          <div class="inputwrapper">
            <span class="showbtn shbtnfpw"></span>
            <input class="input pw"   type="password" name="password" value="admin" readonly="readonly">
            <span class="lbl">Lösenord</span>
          </div>

          <div class="buttons">
            <div class="btnh">
              <span class="button">Verkställ</span>
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
