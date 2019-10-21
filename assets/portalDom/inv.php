<?php
  $key = $main->refPage;
  $sql = "SELECT * FROM invites WHERE vkey = '$key' AND completed = 0";
  $result = $main->getFromMysql($sql);
  if($result->num_rows == 0){
    # No key found
    ?>
    <div class="section login dspin">
      <div class="loginContainer">

      <h1>Denna inbjudan har tyvärr redan använts.</h1>
      </div>
    </div>
    <?php
  } else {
    while($row = mysqli_fetch_assoc($result)){
        $by = $row['ref'];

      ?>
      <div class="section login dspin">

        <div class="loginContainer">
          <h1><?php echo ucfirst($by) ?> har bjudit in dig!</h1>
          <p>Registrera dig nedan för att konsumera denna inbjudan.</p>
          <div class="inputContainer">
            <input class="input iusr" type="text" name="username" value="" required>
            <span class="lbl">Användarnamn</span>
          </div>
          <div class="inputContainer">
            <input class="input ieml" type="text" name="email" value="" required>
            <span class="lbl">Email</span>
          </div>
          <div class="inputContainer">
            <input class="input ipw" type="password" name="password" value="" required>
            <span class="lbl">Lösenord</span>
          </div>
          <div class="inputContainer submit toreg">
            <button class="login getvlkey" type="submit" name="reguser" value="<?php echo $key ?>">Registrera</button>
          </div>

        </div>
        <img class="logoimg reg" src="assets/img/widrblack.png" alt="">
      </div>


      <?php
    }
  }
  ?>
