<?php
  function humanTiming ($time) {
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
  if(isset($_POST['set'])){
    include_once '../../script/func/co_p.php';
    $key = $_POST['v_key'];
    $sql = "SELECT * FROM orders WHERE v_key = '$key'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) != 0) {
      while($row = mysqli_fetch_assoc($result)){

        ?>
          <h1><?php echo $row['v_key'] ?></h1>
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
          <div class="remove">
            <form method="post">
              <input type="hidden" name="key" value="<?php echo $row['v_key'] ?>">
            <button class="rmv" type="submit" name="remove">
              Remove</button>
          </form>
          </div>
          <div class="actions">

              <div class="completeOrder">
                <input class="inputUsername" type="text" name="username" value="" placeholder="användarnamn.."><br>
                <input class="inputPassword" type="text" name="password" value="" placeholder="lösenord.."><br>
                <button type="submit" name="button" class="processOrderButton">Godkänn</button>
              </div>
              <div class="lds-ellipsis hidden"><div></div><div></div><div></div><div></div></div>
            </div>
          </div>
        <?php
      }
    }
  }

?>
<script>
$('.processOrderButton').click(function(){

  items = $(this).parent().parent().parent().find('.data')
  console.log(items)

  vkey = items[1].innerText
  email = items[4].innerText
  pw = $('.inputPassword').val()
  user = $('.inputUsername').val()
  mat = 'process'
  console.log(vkey, email, pw, user, mat)
  $('.lds-ellipsis').removeClass('hidden')
  $.ajax({
    type: "POST",
    url: "../script/mail/confirm_purchase/confirm.php",
    data: {sndml:true, orderID:vkey, username:user, email:email, password:pw, mailtype:mat},
    success: function(data){
      $('.lds-ellipsis').addClass('hidden')
      $('.actions').append('<span>Mail skickat!</span>')
      location.reload()
    }
  })
})

</script>
