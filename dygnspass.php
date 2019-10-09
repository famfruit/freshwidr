<?php
  session_start();
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <base href="/">
    <meta charset="utf-8">
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script/js/preload.js?<?php echo date('hi') ?>"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/fav/favicon-16x16.png">
    <link rel="mask-icon" href="assets/img/fav/safari-pinned-tab.svg" color="#5bbad5">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/styles.css?<?php echo date('hi') ?>">
    <script src="script/js/daypass.js"></script>
    <script src="script/js/pln.js"></script>
    <title>24h Gratis Dygnspass - Sveriges bredaste & billigaste IPTV | Widr.tv</title>
  </head>
  <body>
    <?php include_once 'assets/dom/mnav.php'; ?>
    <div class="navigation">
      <img src="assets/img/logowh.svg" id="mlogo" alt="">
      <div class="menu">
        <?php include_once 'assets/dom/nav.php'; ?>
      </div>
    </div>
    <div class="header">
      <?php
          if(!isset($_SESSION['hp_visisted']))
            {
              $decider = '';
            }
              else
                {
                  $decider = 'disabled';
                }
       ?>
      <div class="curve full <?php echo $decider ?>">
        <div class="section pp incurve free">
          <h1 class="prodtitle">Ansök om 24 timmars GRATIS IPTV</h1>
          <span class="prodspan">Är du osäker om IPTV är något att ha? Vi ger dig gratis testperioder utan några direkta restriktioner!</span>

          <div class="pricePlan">


                                <div class="pp_block" id="">
                                  <div class="confmsg">
                                    <i class="far fa-envelope"></i>
                                    <h1>Ansökan skickad!</h1>
                                    <span>Var noga att kolla i skräpposten om du inte fått svar.</span>
                                  </div>
                                  <span class="title"></span>
                                  <h1>Dygnspass</h1>
                                  <span class="time">24 Timmars Gratis IPTV</span>
                                    <ul>
                                      <li>6000+ Kanaler</li>
                                      <li>1080p VODs</li>
                                      <li>Premium Kanaler</li>
                                    </ul>
                                    <div class="forms">

                                    <input class="mrgn dpu" type="text" name="username" value="" placeholder="Önskat användarnamn">
                                    <input type="text" class="epu" name="email" value="" placeholder="Din email">
                                    </div>
                                    <a href="#"></a>
                                    <div class="button dpass" onclick="dpclick()">
                                      <span class="">Ansök</span>
                                    </div>
                                </div>
                                <div class="pp_block info" id="">
                                  <span class="title">Intallationsguide</span>
                                  <p>Efter att du ansökt och fått ditt lösenord på din email följer du guiden nedan för att snabbt komma igång med tittandet! Du kan även hitta guiden i <a href="https://widr.tv/help">hjälpcentret</a></p>
                                  <div class="guideWindow">
                                    <h1 class="step">Konfigurera & Ladda ner M3U</h1>
                                    <span>Gå till <a href="https://widr.tv/login" target="_blank">widr.tv/login</a> och logga in med dina uppgifter.</span>
                                    <img src="assets/guides/login1.png" alt="">

                                    <h1 class="step">Ladda ner M3U-länk</h1>
                                    <span>Klicka på downloads i menyn till vänster.</span>
                                    <img src="assets/guides/login2.png" alt="">


                                    <h1 class="step">Välj M3U och filformat.</h1>
                                    <span>Klicka på MPEGTS för att se din M3U länk ovan.</span>
                                    <img src="assets/guides/login3.png" alt="">

                                    <h1 class="step">Ladda ner och spara filen lokalt</h1>
                                    <span>Kopiera din M3U adress som finns i fältet ovan.</span>
                                    <img src="assets/guides/login4.png" alt="">


                                  </div>
                                </div>
             </div>
           </div>
      </div>
    </div>
  </body>
</html>

<?php
    $_SESSION['hp_visisted'] = true;

 ?>
