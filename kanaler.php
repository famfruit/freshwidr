<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://widr.tv/kanaler">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/fav/favicon-16x16.png">
    <link rel="mask-icon" href="assets/img/fav/safari-pinned-tab.svg" color="#5bbad5">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="script/js/chan_p.js?<?php echo date('hi') ?>"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/styles.css?<?php echo date('hi') ?>">
    <script src="script/js/pln.js"></script>
    <script src="script/js/daypass.js"></script>
    <title>Våra kanaler | Widr.tv</title>
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
    <div class="lang_cat">

    <?php
    if(isset($_GET['l']))
    {
      echo '<h2>'.ucfirst($_GET['l']).'</h2>';
      include_once 'script/func/co_p.php';
      $l = mysqli_real_escape_string($conn,$_GET['l']);
      $conn->set_charset("utf8");
      $sql = "SELECT * FROM channels WHERE cat = '$l'";
      $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) > 0)
          {
            while($row = mysqli_fetch_assoc($result))
                {
                  $ar = explode('*', $row['channels']);
                    foreach($ar as $k => $v)
                          {
                            if($l === 'sweden'){
                              $vfix = preg_replace('/\s+/', '', $v);
                              $prfx = '<img src="assets/c_img/'.strtolower($vfix).'.png">';
                              $clsprfx = 'img';
                            } else { $prfx = ''; $clsprfx = ''; }
                            ?>
                              <p class="listStyle <?php echo $clsprfx ?>"><?php echo $prfx;echo $v; ?></p>

                            <?php
                          }
                }
          }
    }
      else
    {
      echo '<h1>Välj ett land!</h1>';
      include_once 'script/func/co_p.php';
      $conn->set_charset("utf8");
      $sql = "SELECT DISTINCT cat FROM channels ORDER BY id";
      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) { ?>
          <div class="block ch_l" id="<?php echo strtolower($row['cat']) ?>">
            <img src="assets/flag/<?php echo $row['cat'] ?>.svg" alt="">
            <span><?php echo $row['cat'] ?></span>
          </div>
          <?php
        }
      }
    }


     ?>
   </div>

   <?php include_once 'assets/dom/freeplug.php' ?>

   <?php include_once 'assets/dom/footer.php' ?>
  </body>
</html>
