<?php
    //pta = pay to access
    //trial

    include_once 'script/func/co_p.php';
    if(isset($_GET['key'])){
      $key = mysqli_real_escape_string($conn, $_GET['key']);
    } else {
      $key = '';
    }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <base href="/">
  <meta charset="utf-8">
  <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/fav/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/img/fav/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/img/fav/favicon-16x16.png">
  <link rel="mask-icon" href="assets/img/fav/safari-pinned-tab.svg" color="#5bbad5">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/styles/styles.css?<?php echo date('hi') ?>">
  <title>Betala eller se din order | Widr.tv</title>
</head>
<body>
  <?php include_once 'assets/dom/mnav.php'; ?>
  <div class="navigation mini">


    <img src="assets/img/logo.svg" id="mlogo" alt="">
    <div class="menu">
      <?php include_once 'assets/dom/nav.php'; ?>
    </div>
  </div>
  <div class="header">

    <div class="curve mini">

    </div>
  </div>
  <?php
  if(isset($key)){
 ?>

    <div class="connecting_block finalstep visible">
     <?php
      $sql = "SELECT * FROM orders WHERE v_key = '$key'";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) == 0)
      {
        echo '<h3>404</h3><h4>Vi kunde tyvärr inte hitta det du letade efter.</h4>';
      } else
        {
          while($row = mysqli_fetch_assoc($result))
            {
              $status = '';
              if($row['completed'] == 0){
                $status = 'Obetald';
              } else if ($row['completed'] == 1){
                $status = 'Betald';
              }
              ?>

              <div class="orInput">
                <span id="ost">Orderstatus</span>
                <h3 id="stu"><?php echo $status ?></h3>


                <?php

                  if($row['orderType'] == 'pta' && $row['payMethod'] == 'bitcoin')
                  //converter
                    {

                      $url = 'https://blockchain.info/ticker';
                      $js = file_get_contents($url);
                      $valuta = json_decode($js, true);
                      $set = round($valuta['SEK']['last'], 2);

                      $curprice = $row['setPrice'];
                      $toSEK = 'https://blockchain.info/tobtc?currency=SEK&value='.$curprice;
                      $get = file_get_contents($toSEK);
                      $val = json_decode($get, true);
                        ?>

                        <div class="block">
                          <h1>1. Konvertera SEK till Bitcoin</h1>

                          <div class="conv">
                            <span>SEK</span>
                            <input type="text" class="sek" name="" value="<?php echo $row['setPrice'] ?> KR">
                            <i class="fas fa-exchange-alt"></i>
                          </div>
                          <div class="conv last">
                            <span>Bitcoin</span>
                            <input type="text" class="btc" name="" value="<?php echo $val ?> BTC">
                          </div>


                          <span class="disclaimer">* Denna konverterare är byggd med hjälp av Blockchain's API</span>
                        </div>


                        <div class="block top">
                          <h1>2. Din personliga adress</h1>

                          <div class="sum">
                            <?php echo $val ?> <strong>BTC</strong>
                          </div>
                          <div class="adress">
                            <?php echo $row['address'] ?>
                          </div>
                          <p>* Din adress är knuten till din order och när den korrekta summan finns på kontot, behandlas din order.</p>

                        </div>
                  <?php  } else if ($row['orderType'] == 'pta' && $row['payMethod'] == 'swish')
                        { ?>
                          <div class="block bot">
                            <span>* Din adress är knuten till din order och när den korrekta summan finns på kontot, behandlas din order.</span>
                          </div>
                          <div styles="width: 100%" class="safello-quickbuy" data-address="<?php echo $row['address'] ?>" data-app-id="e9a2249c-d3d9-4a92-bdd5-5993eecc1101" data-border="false" data-address-helper="true" data-crypto="btc" data-country="se" data-lang="sv"></div>
                          <?php
                              $script = '<script src="https://app.safello.com/sdk.js"></script>';
                              if($script = '{"error":"Invalid appId!"}'){
                                echo "<p class='notis'>Vänligen besök <a href='https://safello.com/sv/' target='_BKANK'>Safello</a> för att betala din order.</p><p class='notis a'><strong>Var noga att du skriver in korrekt adress, som du hittar nedan.</strong></p>";
                                ?>
                                <div class="block top" style="margin-top: 10px; padding-top: 20px">
                                  <div class="adress">
                                    <?php echo $row['address'] ?>
                                  </div>
                                </div>
                                <?php
                              } else {
                                echo $script;
                              }

                          ?>
                    <?php  } else if($row['orderType'] == 'free')
                              { ?>
                                <div class="block">

                                <img src="assets/img/letter.svg" alt="">
                                <div class="textH">

                                <span class="spfre">Så fort vi ser att din ansökan, granskar vi och <strong>godkänner</strong> din ansökan.</span>
                                <span class="spfre">Ditt konto aktiveras från dess att vårat automatiska svar skickats ut.</span>
                              </div>
                              </div>

                            <?php  }

                ?>
                  <div class="needHelp">
                    <span>Behöver du hjälp? kontakta <strong>kundtjänst!</strong></span>
                  </div>
              </div>
                     <div class="prodInfo">
                       <div class="block top">
                         <span class="title">OrderID</span>
                         <span class="data"><?php echo $row['v_key'] ?></span>
                         <span class="title">Datum</span>
                         <span class="data"><?php echo $row['date'] ?></span>
                         <span class="title">Produkt</span>
                         <span class="data"><?php echo ucfirst($row['order']) ?></span>


                         <span class="title">Användarnamn</span>
                         <span class="data"><?php echo $row['username'] ?></span>

                         <span class="title">Mottagare</span>
                         <span class="data"><?php echo $row['email'] ?></span>

                       </div>
                       <div class="block tot">
                                               <span>Summa</span>
                           <span class="sum"><?php echo $row['setPrice'] ?><strong>SEK</strong></span>
                                         </div>
                                       </div>




          <?php  }
        }


     ?>
    </div>
  <?php
  }
  ?>




     <?php include_once 'assets/dom/footer.php' ?>
   </body>
 </html>
