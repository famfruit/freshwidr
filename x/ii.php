<?php
  session_start();
  if(isset($_POST['logout']))
    {
      $_SESSION['admAuth'] = false;
      setcookie('admLogin', 0, time() + (86400 * 30), "/");
      header('Location: index.php');
    }
  include_once '../script/func/co_p.php';
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/fav/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/fav/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/fav/favicon-16x16.png">
  <link rel="mask-icon" href="../assets/img/fav/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="theme-color" content="#ffffff">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/styles/styles.css?<?php echo date('hsi') ?>">
  <script src="js/au.js?<?php echo date('hsi') ?>"></script>
  <script src="js/dbs.js?<?php echo date('hsi') ?>"></script>
  <script src="js/conpoll.js?<?php echo date('hsi') ?>"></script>
  <script src="js/proccOrd.js?<?php echo date('hsi') ?>"></script>
  <script src="js/nav.js?<?php echo date('hsi') ?>"></script>
  <script src="js/editthrd.js?<?php echo date('hsi') ?>"></script>
  <title>Admin Panel</title>
</head>
  <body class="admX">

    <?php
      if(isset($_COOKIE['admLogin']) && $_COOKIE['admLogin'] == 1)
        {

          ?>
            <div class="xBody">

              <div class="ui_leftBar">
                  <a href="#c1">
                    <i nav-attr="c1" class="fas fa-globe-europe"></i>
                  </a>
                  <a href="#c4">
                    <i nav-attr="c4" class="far fa-life-ring"></i>
                  </a>
                  <a href="#c2" class="inac">
                    <i nav-attr="c2" class="far fa-comments"></i>
                  </a>
                  <a href="#c3" class="inac">
                    <i nav-attr="c3" class="fas fa-chart-area"></i>
                  </a>

                  <a href="#c5" class="inac">
                    <i nav-attr="c5" class="fas fa-wallet"></i>
                  </a>
                  <a href="#c6" class="inac">
                    <i nav-attr="c6" class="fas fa-cog"></i>
                  </a>
                  <div class="navBot">
                    <form method="post">
                        <button type="submit" name="logout">out</button>
                    </form>
                  </div>
              </div>
              <div class="ui_topBar">
                    <div class="searchDiv">
                      <i class="fas fa-search"></i>
                      <input class="dbadmS" type="text" name="searchAdm" value="" placeholder="Sök i databasen">
                    </div>
                    <div class="resultBox">

                    </div>
              </div>
              <div class="popLeft">

              </div>
              <div class="ui_content active" id="c1">

                      <div class="analytic">
                          <div class="top">

                          </div>
                         <div class="botStats">
                           <?php


                              $wsql = "SELECT * FROM connections WHERE pdate BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()";
                              $week = mysqli_query($conn, $wsql);
                              $weekCount = mysqli_num_rows($week);

                              $dsql = "SELECT * FROM connections WHERE DATE(pdate) = CURDATE()";
                              $d = mysqli_query($conn, $dsql);
                              $dayCount = mysqli_num_rows($d);




                            ?>
                           <h1>Unika besökare</h1>
                           <span>Detta dygn</span>
                           <span>Senaste veckan</span>

                           <h2><?php echo $dayCount ?></h2>
                           <h2><?php echo $weekCount ?></h2>

                           <div class="currentlyOn">

                             <h1><?php echo date('h:i | s') ?></h1>
                             <span class="timer">0</span>
                             <?php
                                $sql = "SELECT * FROM connections WHERE DATE(pdate) = CURDATE() ORDER BY pdate ASC";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result))
                                  {

                                    $then = strtotime(date('Y-m-d H:i:s'));
                                    $now = strtotime($row['pdate']);
                                    $tdif = round(abs($now - $then) / 60,2);
                                    $sta = '';
                                    if($tdif > 1)
                                    {
                                      $sta = 'offline';
                                    } else if ($tdif < 1)
                                    {
                                      $sta = 'online';
                                    }
                                    $p = $row['page'];
                                    ?>
                                      <div class="ocBar <?php echo $sta ?>">
                                        <span class="fst"><?php echo $p ?></span>

                                        <span><?php echo $tdif. " m";?></span>
                                      </div>
                                    <?php
                                  }

                              ?>

                           </div>

                          </div>
                      </div>

                      <div class="topTable">
                        <span># Order</span>
                        <span>Product</span>
                        <span>Costumer</span>
                        <span>Total</span>
                        <span>Referal</span>
                        <span>Existing</span>
                        <span>Created</span>
                        <span>Status</span>
                      </div>
                      <div class="orders">
                        <?php


                         ?>

                         <?php
                            $conn->set_charset("UTF8");
                            $sql = "SELECT * FROM orders ORDER BY date DESC";
                            $result = mysqli_query($conn, $sql);
                              while($row = mysqli_fetch_assoc($result))  {
                                  $status = $row['completed'];
                                  if($status == 0)
                                    {$st = 'Pending';}
                                  else if
                                  ($status == 1)
                                    {$st = 'Completed';}
                                  ?>
                                  <div class="orderBar">
                                    <span><?php echo $row['v_key'] ?></span>
                                    <span><?php echo $row['order'] ?></span>
                                    <span><?php echo $row['email'] ?></span>
                                    <span><?php echo $row['setPrice'] ?></span>
                                    <span>Unset</span>
                                    <span>Recurring</span>
                                    <span>10 Min ago</span>
                                    <span class="stBar <?php echo $st ?>"><?php echo $st ?></span>

                                    <div class="clAb"></div>
                                          <div class="addInfo hidden">
                                            <div class="inputs">
                                              <input type="hidden" name="ordid" value="<?php echo $row['v_key'] ?>">
                                              <input type="text" name="username" value="<?php echo $row['username'] ?>">
                                              <input type="text" name="password" value="" placeholder="Lösenord">
                                              <input type="hidden" name="eml" value="<?php echo $row['email'] ?>">
                                              <button class="procBtn" type="submit" name="process">Behandla</button>

                                            </div>
                                          </div>
                                  </div>
                                  <?php
                                }
                          ?>
                      </div>

              </div>


              <div class="ui_content" id="c4">
                <h3>Hjälpcenter</h3>
                <p>Lägg till, Ta bort eller ändra i hjälpcentret.</p>
                <i class="fas fa-plus-circle help"></i>
                <div class="orders hcntr">

                <?php
                  $sql = "SELECT * FROM help ORDER BY type DESC";
                  $result = mysqli_query($conn, $sql);
                  while($row = mysqli_fetch_assoc($result))
                  { ?>
                      <div class="orderBar help">
                            <span class="id"><?php echo $row['ID']?></span>
                            <span class="type <?php echo $row['type']?>"><?php echo $row['type']?></span>
                            <span><?php echo $row['url_tag']?></span>
                            <span><?php echo $row['descr']?></span>
                            <div class="clAb">  </div>
                            <div class="addInfo hidden">
                              <span>Innehåll</span>
                              <div class="textcontent" contenteditable="true">

                                        <?php
                                        $string = $row['text'];
                                        ?>
                                        <xmp class="xmpVal"><?php echo $string; ?></xmp>


                              </div>

                              <span>DB Title - Header text</span>
                              <input class="db_title" type="text" name="" value="<?php echo $row['title'] ?>">

                              <span>DB Category - Start/PC/TV/epg/Boxer</span>
                              <input class="db_cat" type="text" name="" value="<?php echo $row['cat'] ?>">

                              <span>DB Tags - Search tags</span>
                              <input class="db_tags" type="text" name="" value="<?php echo $row['tags'] ?>">

                              <span>DB Type - guide/faq/issue</span>
                              <input class="db_type" type="text" name="" value="<?php echo $row['type'] ?>">

                              <span>DB Description - Installationsguide / 1ord beskrvning</span>
                              <input class="db_descr" type="text" name="" value="<?php echo $row['descr'] ?>">

                              <span>DB URL_TAG - www.widr.tv/*type*/url_tag</span>
                              <input class="db_urltag" type="text" name="" value="<?php echo $row['url_tag'] ?>">
                              <div class="save dbsv">
                                Spara
                              </div>
                            </div>
                      </div>
                  <?php
                  }
                 ?>
              </div>
            </div>
            </div>
              <script src="js/scnor.js"></script>
          <?php


        }
        else
        {
          //show login
     ?>

     <div class="xLog">
        <div class="xloader">
          <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
         <span>username</span>
         <input id="x_un" type="text" name="un" value="">

         <span>password</span>
         <input id="x_pw" type="password" name="pw" value="">
         <span>auth</span>
         <input id="x_key" type="password" name="akey" value="" placeholder="XXX - XXX">
         <button id="x_sub" type="submit" name="xlog">Authenticate</button>
         <div class="whiteSpace"></div>


     </div>
     <?php
       }
     ?>
  </body>
</html>
