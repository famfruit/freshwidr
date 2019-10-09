<?php

  if(isset($_GET['ajg'])){
      session_start();
      include_once 'script/func/co_p.php';
      $v = mysqli_real_escape_string($conn, $_GET['v']);
      $sql = "SELECT * FROM orders WHERE v_key = '$v' AND completed = 0";
      $result = mysqli_query($conn, $sql);
        if($v != $_SESSION['v_key'])
          {
            //header('Location: ?v='.$_SESSION['v_key']);
            echo 0;
            exit;
          } else {
            if(mysqli_num_rows($result) < 0)
            {
              echo 'Finns ej';
            } else
            {
              while($row = mysqli_fetch_assoc($result))
              { ?>
                <div class="orInput">



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


                            <span class="disclaimer">* Converter is built and based on Blockchain's API</span>
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
                      <span>Behöver du hjälp? kontakta <strong><a href="https://widr.tv/support/">kundtjänst!</a></strong></span><br>
                      <span>Skynda på din behandling på <a href="https://widr.tv/support/">Discord</a></span>
                    </div>
                </div>
                <div class="prodInfo">
                  <div class="block top">
                    <span class="title">OrderID</span>
                    <span class="data"><?php echo $v ?></span>
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
                    <?php if($row['setPrice'] == 'free') { ?>
                        <span>Summa</span>
                        <span class="sum"><strong>Gratis</strong></span>
                  <?php  } else {?>
                      <span>Summa</span>
                      <span class="sum"><?php echo $row['setPrice'] ?> <strong>SEK</strong></span>
                    <?php } ?>
                </div>
                  <?php
                //  echo 'Orderkey:'.$v.'<br><br>'.'SESH KEY: '.$_SESSION['v_key'].'<br>';
                //  echo $row['order'];
                //  echo $row['setPrice'];
                //  echo $row['payMethod'];
                //  echo $row['username'];
                  ?>
                </div>
            <?php  }
            }
          }

  }
 ?>
