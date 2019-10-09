<?php
  session_start();
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script/js/preload.js?<?php echo date('hi') ?>"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/fav/favicon-16x16.png">
    <link rel="mask-icon" href="assets/img/fav/safari-pinned-tab.svg" color="#5bbad5">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/styles.css?">
    <script src="script/js/pln.js"></script>
    <title>Våra IPTV produkter | Widr.tv</title>
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
        <div class="assistCurve nocurve">

          <video autoplay muted loop>
            <source src="assets/done.webm">
          </video>
        </div>
        <div class="section pp incurve">
          <h1 class="prodtitle prd">Världens största utbud av TV kanaler och On Demand!</h1>
          <span class="prodspan prd">Börja med att välja tidsperiod som passar dig bäst, du får samma mängd kanaler oavsett pris!</span>
          <div class="pricePlan" style="padding-top: 0">

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
                                    <a href="#"></a>
                                    <div class="button">
                                      <a href="https://widr.tv/produkter/<?php echo $prod ?>">Beställ</a>
                                    </div>
                                </div>
                            <?php
                          }
               ?>
             </div>
           </div>

      </div>

    </div>
    <?php include_once 'assets/dom/freeplug_prd.php'?>
    <?php include_once 'assets/dom/footer_fix.php'?>
  </body>
</html>

<?php
    $_SESSION['hp_visisted'] = true;

 ?>
