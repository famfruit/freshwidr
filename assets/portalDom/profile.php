<div class="section profile">
  <div class="usertop">
    <div class="profileimg">
      <span><strong></strong></span>
    </div>
    <h1>username</h1>
    <span class="type">premium</span>
  </div>
  <div class="profileCat">
    <span class="active">Invites</span>
    <span>Historik</span>
    <span>Inställningar</span>
  </div>

<?php
  if($main->profilePage == 'overview'){

    ?>
    <div class="section prflContent" id="overview">

    </div>
    <?php


  } else if ($main->profilePage == 'settings'){
    ?>
      <div class="section prflContent" id="settings">
        <div class="inputContainer static">
          <div class="inputwrapper">
            <input class="input" type="text" name="username" value="" required>
            <span class="lbl">Användarnamn</span>
          </div>
      </div>
      </div>
    <?php
  }
?>

</div>
