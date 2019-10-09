<?php
  session_start();
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="canonical" href="https://widr.tv/" />
    <meta charset="utf-8">
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/fav/favicon-16x16.png">
    <link rel="mask-icon" href="assets/img/fav/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="script/js/preload.js?<?php echo date('hi') ?>"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/styles.css?<?php echo date('hi')?>">
    <script src="script/js/pln.js"></script>
    <script src="script/js/daypass.js"></script>
    <title>Sveriges Bredaste & Billigaste IPTV | Widr.tv - Gratis 24H Test</title>
  </head>
  <body>
    <?php include_once 'assets/dom/mnav.php'; ?>
    <div class="navigation">

      <a href="https://widr.tv">
      <img src="assets/img/logowh.svg" id="mlogo" alt="Widr TV Logo">
    </a>
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
      <div class="curve <?php echo $decider ?>">
        <div class="assistCurve">

          <video autoplay muted loop>
            <source src="assets/done.webm">
          </video>
        </div>
        <div class="mtn">


        </div>
          <div class="ld-p sz">


            <div class="ld-p_left <?php echo $decider ?>">
              <h1><strong>Sveriges billigaste</strong> och bästa IPTV!</h1>
              <span>Vi erbjuder alla våra kunder över 6000 av de absolut bästa kanaler från hela världen.
Filmer, Sport, Serier, XXX, On-Demand och mycket mer.</span><br><br>
<span>Widr.tv finns nu på <strong>Discord</strong>, det firar vi med att öppna <strong>dygnspassen</strong> igen! </span><br>
<span style="font-size: 13px; opacity: 0.8; font-weight: 300">Discord ger oss möjligheten att ge våra kunder <strong style="font-weight: 400; text-decoration: underline">ultrasnabb kundservice</strong> och förskyndar behandlingsprocessen marginellt.</span>
              <div class="btn_push">
                <div class="button toProd" id="ld-p_more">
                  <a href="https://widr.tv/produkter/ultimate">Beställ nu<i class="fas fa-heart" style="color: "></i></a>
                </div>
                
              </div>

            </div>
            <div class="ld-p_right <?php echo $decider ?>">

            </div>


          </div>
      </div>


      <!-- NOTIS -->

      <div class="warning">
        <div class="wbox">

          <p><i class="fas fa-exclamation-triangle"></i>
          <span class="date">2019-09-18</span><br><br>Vi upplever för tillfället driftstörningar på många av våra kanaler.</p>
          <span class="button wrb" onclick="expand()">Läs varför</span>
          <div class="war-readmore hidden">
            <p>Den 18:e September 2019 genomfördes en rad razzias runt om i EU, bland annat hos Xstream-Codes i italien som resulterade i över 200 nedstängda serverar. Detta haltar våra verksamheter till 99% för tillfället.</p>
            <p>Du som redan är kund hos har <strong>absolut ingenting</strong> att oroa dig för, och vi får återigen påpeka vikten i att använda VPN och Kryptovaluta.</p>
            <p><strong>Widr.tv ska ingenstans, tvärtom!</strong> Vi har massvis med spännande uppdateringar på gång vilket vi kommer släppa på löpande band. Detta är enbart en liten, och visserligen den första motgång vi inom IPTV-communityt upplevt.</p>
            <p><strong>Alla aktiva konton från och med den 18:e September kommer att kompenseras med adekvat tid som blivit förlorad, utan någon som helst kostnad.</strong></p>
            <p>Nedan har vi listat en informativ video som förklarar lite tydligare, vad jag redan skrivit här.</p>
              <iframe width="300" height="180"  src="https://www.youtube.com/embed/GOS4Cnlefp4" frameborder="0" allowfullscreen></iframe>
              <p class="sign">Vi ber så hemskt om ursäkt för olägligheten och vi ber alla att vara så tålmodiga ni bara kan!</p>
              <p class="sign ss">// Veronica</p>
              <p class="sign ss">https://www.youtube.com/watch?v=GOS4Cnlefp4</p>
          </div>
        </div>
      </div>
      <script>

      function expand(){
        $('.war-readmore').toggleClass('hidden')
        $('.wrb').toggleClass('vis').html('Visa mindre')
        if(!$('.wrb').hasClass('vis')){ $('.wrb').html('Läs varför') }
      }

      </script>
      <!-- NOTIS  --->


      <div class="connecting_block">
        <div class="cb">
          <img src="assets/svg/delivery.svg" alt="">
          <h1>Supersnabb leverans</h1>
          <p>Med vårat automatiserade leveranssystem ligger vi steget före våra konkurrenter. Samma sekund som du betalt din order, flaggas din order för processering och skickas iväg!</p>
        </div>
        <div class="cb">
          <img src="assets/svg/xplatform.svg" alt="">
          <h1>På alla plattformar</h1>
          <p>Det är superenkelt att börja, och du kan även strömma TV på en 3G eller med VPN igång.</p>
        </div>
        <div class="cb">
          <img src="assets/svg/shield.svg" alt="">
          <h1>Säker datahantering</h1>
          <p>All din data är krypterad så att enbart vårat system kan läsa de. När din order är klar, förstörs all användar data.</p>
        </div>
      </div>
    </div>

  <div class="section mobile swipe">
    <!--
    # Abonnemang
    # On Demand
    # Antal kanaler
    # Multi-platform
    # Pris
    -->
    <h1>Widr.tv är bäst på marknaden</h1>
    <p>Vi på Widr.tv vill reflektera den klaraste bilden över Svergies ledande TV leverantörer, därför har vi skapat en tabell med informativ data där du enkelt kan jämföra priserna. All data är tagen från respektive leverantörers hemsidor och finns länkade under <i class="fas fa-info-circle" style="font-size: 18px; color: #f8874c;margin: 0 5px 0 5px"></i> knappen.</p>
    <table>
      <tr>
        <td><img src="assets/img/viasat.png" alt="viasat logo"></td>
        <td><img src="assets/img/telia.png" alt="telia logo"></td>
      </tr>
      <tr>
        <td><i class="fas fa-check"></i>Multiplattform</td>
        <td><i class="far fa-times-circle"></i>Multiplattform</td>
      </tr>
      <tr>
        <td><i class="fas fa-check"></i>On Demand</td>
        <td><i class="fas fa-check"></i>On Demand</td>
      </tr>
      <tr>
        <td><span>64<strong>st</strong></span>Kanalpaket</td>
        <td><span>43<strong>st</strong></span>Kanalpaket</td>
      </tr>
      <tr>
        <td><span class="price">9060<strong>/ år</strong></span>Pris <i class="fas fa-info-circle"><span><a href="https://www.viasat.se/utbud/tv/tv-paket" target="_BLANK">Källa <strong>(öppnas i nytt fönster)</strong></span></i></td>
        <td><span class="price">4788<strong>/ år</strong></span>Pris <i class="fas fa-info-circle"><span>Telia förutsätter att du samtidigt äger fibernät vilket drastiskt ökar priset.<br><br><a href="https://www.telia.se/privat/tv/tvpaket/product/stor?intcmp=tvpaket_stor" target="_BLANK">Källa <strong>(öppnas i nytt fönster)</strong></span></i></td>
      </tr>
    </table>
    <table>
      <tr>
        <td><img src="assets/img/canaldigital.png" alt="canal digital logo"></td>
        <td><img src="assets/img/comhem.png" alt="com hem logo"></td>
      </tr>
      <tr>
        <td><i class="fas fa-check"></i>Multiplattform</td>
        <td><i class="far fa-times-circle"></i>Multiplattform</td>
      </tr>
      <tr>
        <td><i class="fas fa-check"></i>On Demand</td>
        <td><i class="fas fa-check"></i>On Demand</td>
      </tr>
      <tr>
        <td><span>58<strong>st</strong></span>Kanalpaket</td>
        <td><span>122<strong>st</strong></span>Kanalpaket</td>
      </tr>
      <tr>
        <td><span class="price">6456<strong>/ år</strong></span>Pris <i class="fas fa-info-circle"><span>Förutsätter bindningstid på 24 mån. Minsta totalpris: 23 mån * 538 kr = <strong>12 374 kr.</strong>  <br><br><a href="https://www.canaldigital.se/kampanj/bli-kund/for-film--och-seriealskaren/" target="_BLANK">Källa <strong>(öppnas i nytt fönster)</strong></span></i></td>
        <td><span class="price">3588<strong>/ år</strong></span>Pris <i class="fas fa-info-circle"><span>Priset gäller första 12 mån, därefter <strong>5628kr/år</strong> (469kr/mån) <br><br><a href="https://www.comhem.se/tv/tv-guld" target="_BLANK">Källa <strong>(öppnas i nytt fönster)</strong></span> </i></td>
      </tr>
    </table>

    <table id="solo">
      <tr>
        <td><img src="assets/img/logowhnt.png" alt=""><br><br></td>
      </tr>
      <tr>

        <td><i class="fas fa-check"></i>Multiplattform</td>
      </tr>
      <tr>
        <td><i class="fas fa-check"></i>On Demand</td>
      </tr>
      <tr>
        <td><span>6000<strong>st</strong></span>Kanalpaket</td>
      </tr>
      <tr>
        <td><span class="price">890<strong>/ år</strong></span>Pris <i class="fas fa-info-circle"></i></td>

      </tr>
      <tr class="btn">
        <td>
        <a class="button" href="https://widr.tv/produkter/ultimate">Till kassan <i class="fas fa-shopping-basket"></i></a>

        </td>

      </tr>
    </table>

  </div>


  <div class="section first fsz bot" id="learn">
    <div class="sf_content">
      <h1 class="htop">Varför ska du handla från oss?</h1>
      <div class="blocks">

        <div class="bite">
          <i class="fab fa-discord"></i>
          <h1>Automatisk aktivering via Discord</h1>
          <p>Vill du få ditt dagspass bekräftat fortare? Vår Discordbot gör det åt dig!<br><code>!a [ID]</code></p>
        </div>
        <div class="bite">
          <i class="fas fa-shield-alt"></i>
          <h1>Säkraste datahanteringen på marknaden</h1>
          <p>Med hjälp av Bitcoins, SSL, VPN tunnlar och <strong>DHKE</strong> garanterar vi er anonymitet. När din order är klar, förstörs all användar data.</p>
        </div>
        <div class="bite">
          <i class="fas fa-medal"></i>
          <h1>Nordens bästa leverantör av IPTV</h1>
          <p>Vi är inte vilken IPTV leverantör som helst. Vi levererar IPTV i premium kvalitet och är ledande i Sverige, Norge, Danmark och Finland.</p>
        </div>
        <div class="bite">
          <i class="fas fa-user-ninja"></i>
          <h1>Diffie Hellman Key Exchange</h1>
          <p>Vi krypterar alla våra nycklar med hjälp av DHKE på ett sätt att en gemensam hemlighets-nyckel skapas mellan två enheter så att hemligheten inte kan ses genom att observera kommunikationen.</p>
        </div>

        <div class="bite">
          <i class="fas fa-magic"></i>
          <h1>Installationshjälp & Vägledning</h1>
          <p>Vi hjälper dig oavsett problem, utan väntetid! Vi finns nu på <strong>Discord</strong> vilket gör att vi kan bibehålla en exemplarisk kundservice-nivå</p>
        </div>
        <div class="bite">
          <i class="fas fa-server"></i>
          <h1>Servrar i Ryssland</h1>
          <p>Vi har både våra kort och servrar i Ryssland. Detta är utanför EU och ingen myndighet eller Antipiratbyrå i Sverige kan beslagta vår utrustning. Så ni kan vara på den säkra sidan.</p>
        </div>

      </div>
      <!--<h1>Widr.tv tar IPTV in i framtiden!</h1>
      <p>Widr.tv funkar till majoriteten olika enheter, du kan se på tv på din telefon, surfplatta, dator eller TV. För att kunna streama från en äldre TV behöver du en IPTV mottagare, exempel en <a href="#">Raspberry PI</a></p>
      <p>Widr.tv erbjuder TV via internet, så att du aldrig mer behöver oroa dig för krångliga installationer med kablar och störningar.</p>
      <p>Sedan televisionen kom till Sverige på 50-talet så har uppsättningen sett liknande ut med diverse boxar, antenner, paraboler, kablar, kort och annat som behövs för att kunna se på TV.</p>

        <p>Vi finns tillgängliga via <a href="#">kundsupport</a> 24 timmar om dygnet och hjälper gärna till med installering.</p>
        <div class="btn_push">
        <div class="button toProd" id="ld-p_more">
          <a href="https://widr.tv/produkter">Beställ</a>
        </div> -->

      </div>
    </div>
    <div class="section first fsz bot" id="learn">
      <div class="sf_content pickHolder">

        <div class="fpPick">
          <div class="fpHolder">
          <span>SE PÅ SPORT FRÅN HELA VÄRLDEN</span>
          <h1>Sport i världsklass!</h1>
          <p>Med Widr.tv ser du de viktigaste sporthändelserna från de största ligorna och serierna världen över.</p>
          <p>Champions League, Hockey VM, Premier League, Bundesliga, NHL, Formel 1, SSL, MotoGP, SHL, Allsvenskan, Handbollsligan, La Liga, NBA och mycket mer.</p>
          <a href="https://widr.tv/kanaler">Se vårat utbud</a>
          </div>
          <img src="assets/img/tv.png" alt="">
        </div>


          <div class="fpPick right">
            <div class="fpHolder">
            <span>FILM & SERIER</span>
            <h1>Största TV-utbudet</h1>
            <p>Vi erbjuder över 14,000 & över +4.000 VoD's kanaler från hela världen. Med Widr.tv missar du aldrig en säsongspremiär av din favoritserie</p>
            <p>Vi har ett massivt utbud för både stora och små. Allt från Action till Barnkanaler. Tveka inte! Testa oss, vi lovar att du blir nöjd.</p>
            <a href="https://widr.tv/produkter">Våra produkter</a>
            </div>
            <img src="assets/img/wp2.png" alt="">
          </div>

          <div class="fpPick">
            <div class="fpHolder">
            <span>FÖLJ MED IN I FRAMTIDEN</span>
            <h1>Oändliga möjligheter</h1>
            <p>Widr.tv funkar till majoriteten olika enheter, du kan se på tv på din telefon, surfplatta, dator eller TV. För att kunna streama från en äldre TV behöver du en IPTV mottagare, exempel en <strong>Raspberry PI</strong></p>
            <p>Widr.tv erbjuder TV via internet, så att du aldrig mer behöver oroa dig för krångliga installationer med kablar och störningar.</p>
            <p>Sedan televisionen kom till Sverige på 50-talet så har uppsättningen sett liknande ut med diverse boxar, antenner, paraboler, kablar, kort och annat som behövs för att kunna se på TV.</p>
            <a href="https://widr.tv/faq/alla">Läs mer</a>
            </div>
            <img src="assets/svg/large_security.svg" id="svg" alt="">
          </div>
        </div>
        <!--<h1>Widr.tv tar IPTV in i framtiden!</h1>
        <p>Widr.tv funkar till majoriteten olika enheter, du kan se på tv på din telefon, surfplatta, dator eller TV. För att kunna streama från en äldre TV behöver du en IPTV mottagare, exempel en <a href="#">Raspberry PI</a></p>
        <p>Widr.tv erbjuder TV via internet, så att du aldrig mer behöver oroa dig för krångliga installationer med kablar och störningar.</p>
        <p>Sedan televisionen kom till Sverige på 50-talet så har uppsättningen sett liknande ut med diverse boxar, antenner, paraboler, kablar, kort och annat som behövs för att kunna se på TV.</p>

          <p>Vi finns tillgängliga via <a href="#">kundsupport</a> 24 timmar om dygnet och hjälper gärna till med installering.</p>
          <div class="btn_push">
          <div class="button toProd" id="ld-p_more">
            <a href="https://widr.tv/produkter">Beställ</a>
          </div> -->

        </div>
      </div>
  </div>
  <div class="section pp bottom">
    <div class="pricePlan">
        <?php
            include_once 'script/func/co_p.php';
            $conn->set_charset("utf8");
            $sql = "SELECT * FROM products WHERE productType = 'pta'";
            $result = mysqli_query($conn, $sql);
              while($row = mysqli_fetch_assoc($result))
                    {
                      $prod = $row['product'];
                      $type = $row['productType'];
                      $price = $row['productPrice'];
                      $time = $row['productTime'];

                      ?>
                          <div class="pp_block" id="<?php echo $prod ?>">
                            <span class="title"><?php echo $prod ?></span>
                            <h1><?php echo $price ?>kr</h1>
                            <span class="time">/ <?php echo $time ?></span>
                              <ul>
                                <?php if($prod == 'ultimate')
                                        {
                                          echo '<li class="vip">VIP Pass</li>';
                                        }
                                ?>
                                <li>6000+ Kanaler</li>
                                <li>1080p VODs</li>
                                <li>Premium Kanaler</li>
                              </ul>
                              <div class="button">
                                <a href="https://widr.tv/produkter/<?php echo $prod ?>">Beställ</a>
                              </div>
                          </div>
                      <?php
                    }

         ?>
       </div>
       <div class="bblhldr">
         <div class="midBubble">
         </div>
       </div>

       <div class="free" id="try-it-out" style="display: none">
         <h1>Inte bestämt dig än?</h1>

         <p><strong>Varje dag</strong> erbjuder vi våra kunder 30st dagspass, titta på alla våra kanaler helt gratis i 24 timmar!</p>
         <form action="checkout.php" method="get">
           <button type="submit" name="p" value="trial"><span>Prova på!<span></button>
           </form>
           <span class="ht"><strong> <?php
                include_once 'script/func/co_p.php';
                $conn->set_charset("utf8");
                $sql = "SELECT available FROM trials";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result))
                 {
                   echo $row['available'];
                 }
             ?></strong>st kvar!</span>
       </div>
  </div>


  <?php include_once 'assets/dom/footer.php'; ?>
  </body>
</html>

<?php
    $_SESSION['hp_visisted'] = true;

 ?>
