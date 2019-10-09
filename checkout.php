<?php
  //$_GET['p'] = 'ultimate';
  session_start();
  if(!isset($_GET['p'])){
    header('Location: index?e504');
    exit;
  } else {
    include_once 'script/func/co_p.php';
    $conn->set_charset("utf8");
    $prod = $_GET['p'];
    $sql = "SELECT * FROM products WHERE product = '$prod'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 0)
      {
        header('Location: index?e404');
        exit;
      }
      else
      {
        while($row = mysqli_fetch_assoc($result))
              {



    //pta = pay to access
    //trial
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="apple-touch-icon" sizes="180x180" href="assets/img/fav/apple-touch-icon.png">
     <link rel="icon" type="image/png" sizes="32x32" href="assets/img/fav/favicon-32x32.png">
     <link rel="icon" type="image/png" sizes="16x16" href="assets/img/fav/favicon-16x16.png">
     <link rel="mask-icon" href="assets/img/fav/safari-pinned-tab.svg" color="#5bbad5">
     <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
     <script src="script/js/chot.js?<?php echo date('hi') ?>"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
     <link rel="stylesheet" href="assets/styles/styles.css?<?php echo date('hi') ?>">
     <script src="script/js/pln.js"></script>
     <title><?php echo ucfirst($row['product']) ?> - Placera din order | Widr.tv</title>
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
     <div class="orderHeader">
       <h1 class="ch_title">Du är nästan klar</h1>
       <span class="current">1. Placera order</span>
       <span>2. Betala</span>
     </div>
     <div class="connecting_block finalstep">
        <?php
          if(isset($_GET['v'])){

          }
        ?>
     </div>
     <div class="connecting_block general" style="min-height: 100vh">
       <div class="orInput">

          <div class="block">
              <h1>1. Granska produkt</h1>
              <div class="radio">
                  <h1 class="prodName"><?php echo ucfirst($row['product']) ?></h1>
                  <span><?php if($row['productPrice'] != 'free') { echo $row['productPrice'].'kr / '.$row['productTime']; } else { echo 'Gratis / '.$row['productTime']; } ?></span>
              </div>
          </div>
          <?php
              if($row['product'] != 'trial')
                { ?>
                  <div class="block of_a">
                    <h1>2. Välj betalningsmetod</h1>
                    <div class="pb" id="swish">
                      <img src="assets/img/swish.svg" alt="">
                    </div>
                    <div class="pb" id="bitcoin">
                      <img src="assets/img/bitcoin.svg" alt="">
                    </div>
                  </div>
              <?php  } else if($row['product'] == 'trial'){
                ?>
                  <input type="hidden" class="of_a">
                  <input type="hidden" class="pb set" id="free">
                <?php
              }
           ?>
          <div class="block io">
            <h1>3. Användaruppgifter</h1>
            <span>Användarnamn *</span>
            <input type="text" name="username" class="ch_usnm">

            <span>Email *</span>
            <input type="text" name="email" class="ch_eml">

            <span>Land</span>
            <input type="text" name="country" class="ch_cnty">


            <button type="button" class="chot_po" name="order">Lägg beställning</button>
          </div>

          <div class="eta">
            <i class="far fa-clock"></i>
            <span>Beräknad ankomsttid: <strong><?php include_once 'script/func/modeta.php'; if($etaTimer < 120) { echo '5 Minuter'; } else { echo '1 Timma'; }?></strong></span>
            <span class="disclaimer">* Datan är baserad på antalet moderatörer <strong>online.</strong></span>
          </div>
       </div>
       <div class="prodInfo">
         <h1>Widr.tv | <?php echo ucfirst($_GET['p']) ?></h1>

         <p>Med Widr.tv så får du TV via internet så du behöver endast ha internet-uppkoppling och en enhet som kan spela upp IPTV, vilket dom flesta Smart-TV har i dagens läge.</p>
         <p> Widr.tv fungerar till tex iPhone, Android, Kodi, MAG och många många fler enheter, så länge enheten kan ta emot IPTV så kan du se på våra kanaler.</p>
       </div>
     </div>
     <?php include_once 'assets/dom/footer.php' ?>
   </body>
 </html>
 <?php
}
}
}

?>
