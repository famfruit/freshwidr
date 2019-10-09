<?php
  session_start();
  if(isset($_POST['logout']))
    {
      $_SESSION['admAuth'] = false;
      setcookie('admLogin', 0, time() + (86400 * 30), "/");
      header('Location: index.php');
    }
  include_once '../script/func/co_p.php';
  function humanTiming ($time)
          {
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

          if(isset($_POST ['remove'])) {
            $page = '#c1';
            $id = $_POST['key'];
            $sql = "UPDATE orders SET completed = 2 WHERE v_key = '$id'";
            $res = mysqli_query($conn, $sql);
            if($res) {
              header('Location: ?updated='.$id.$page);
              exit;
            } else {
              header('Location: ?error='.$id.$page);
              exit;
            }
          }
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
  <script src="https://cdn.jsdelivr.net/npm/@jaames/iro/dist/iro.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script src="txlook/cli.js"></script>
  <title>Admin Panelen</title>
</head>
  <body class="admX">

    <?php
      if(isset($_COOKIE['admLogin']) && $_COOKIE['admLogin'] == 1)
        {

          $sql = "SELECT * FROM support";
          $navSupportCount = mysqli_num_rows(mysqli_query($conn, $sql));
          ?>
            <div class="xBody">

              <div class="ui_leftBar">
                  <a href="#c1">
                    <i nav-attr="c1" class="fas fa-globe-europe"></i>
                  </a>
                  <a href="#c4">
                    <i nav-attr="c4" class="far fa-life-ring"></i>
                  </a>
                  <a href="#c2">
                    <span class="count"><?php echo $navSupportCount ?></span>
                    <i nav-attr="c2" class="far fa-comments"></i>
                  </a>
                  <a href="#c5">
                    <i nav-attr="c5" class="fas fa-wallet"></i>
                  </a>
                  <a href="#c3" class="inac">
                    <i nav-attr="c3" class="fas fa-chart-area"></i>
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
                <div class="imgholder">

                <img src="../assets/img/logowhnt.svg" alt="">
              </div>
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
                               $msql = "SELECT * FROM connections WHERE pdate BETWEEN (NOW() - INTERVAL 30 DAY) AND NOW()";
                               $mon = mysqli_query($conn, $msql);
                               $monCount = mysqli_num_rows($mon);
                               $now = date('m');
                                ## create array with 31 indexes
                                $inputArray = array();
                                for($d = 0; $d < 31; $d++){ array_push($inputArray, 0); }

                               while($row = mysqli_fetch_assoc($mon)){
                                 $time = strtotime($row['pdate']);
                                 $day = date("d", $time);
                                 $month = date("m", $time);
                                 if($month === $now){
                                   $day = (int)$day - 1;
                                   $inputArray[$day] = $inputArray[$day] + 1;

                                 }

                               }
                               $newData = json_encode($inputArray);
                               #file_put_contents("data/chartDt.json", $newData);



                              $wsql = "SELECT * FROM connections WHERE pdate BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()";
                              $week = mysqli_query($conn, $wsql);
                              $weekCount = mysqli_num_rows($week);

                              $dsql = "SELECT * FROM connections WHERE DATE(pdate) = CURDATE()";
                              $d = mysqli_query($conn, $dsql);
                              $dayCount = mysqli_num_rows($d);




                            ?>
                            <div class="metrics">

                           <!--<h1>Unika besökare</h1> -->
                           <div class="counts">

                           <h2 id="day"><?php echo $dayCount ?></h2>
                           <h2 id="week"><?php echo $weekCount ?></h2>
                           <h2 id="mon"><?php echo $monCount ?></h2>
                          </div>
                          <div class="timerHolder">
                            <h1 class="lttimer"><?php echo date('h:i:s') ?></h1>
                          </div>
                           <div class="profileStat" style="margin-top: 0;width: 88%;">
                             <canvas id="onlineGraph"></canvas>
                           </div>
                           <script src="js/graph.js"></script>
                            </div>

                           <div class="currentlyOn">

                             <?php
                                $sql = "SELECT * FROM connections WHERE pdate BETWEEN (NOW() - INTERVAL 1 HOUR) AND NOW()";
                                #$sql = "SELECT * FROM connections WHERE DATE(pdate) = CURDATE() ORDER BY pdate ASC";
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

                      <div class="analytic stats">
                        <div class="anaHolder">
                          <?php
                            mysqli_set_charset($conn, "utf8");
                            $globalArray = array();

                            #first
                            $sql = "SELECT id FROM connections";
                            $res_1 = mysqli_num_rows(mysqli_query($conn, $sql));
                            array_push($globalArray, $res_1);

                            #second
                            $sql = "SELECT usercontent FROM help";
                            $result = mysqli_query($conn, $sql);
                            $commentCount = 0;
                            while($row = mysqli_fetch_assoc($result)){
                              $data = json_decode($row['usercontent']);
                              $commentCount =  $commentCount + sizeOf($data->comments);
                            }
                            array_push($globalArray, $commentCount);

                            #third
                            $sql = "SELECT id from help";
                            $count = mysqli_num_rows(mysqli_query($conn, $sql));
                            array_push($globalArray, $count);

                            #fourth
                            $sql = "SELECT orderID from orders";
                            $count = mysqli_num_rows(mysqli_query($conn, $sql));
                            array_push($globalArray, $count);

                            #fifth
                            $sql = "SELECT * FROM channels";
                            $count = mysqli_num_rows(mysqli_query($conn, $sql));
                            array_push($globalArray, $count);


                            #sixth
                            # inherit sql from  last
                            $result = mysqli_query($conn, $sql);
                            $count = 0;
                            while($row = mysqli_fetch_assoc($result)){
                              ## 34 rows
                              $ch = explode("\n", $row['channels']);
                              $count = $count + sizeOf($ch);
                            }
                            array_push($globalArray, $count);

                            #seven
                            $count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM wallet WHERE used = 0"));
                            array_push($globalArray, $count);
                          ?>



                          <span><i class="fas fa-network-wired"></i>CONNECTIONS <strong><?php echo $globalArray[0] ?></strong></span>
                          <span><i class="far fa-comments"></i>COMMENTS <strong><?php echo $globalArray[1] ?></strong></span>
                          <span><i class="fas fa-book"></i>THREADS <strong><?php echo $globalArray[2] ?></strong></span>
                          <span><i class="fas fa-box-open"></i>ORDERS  <strong><?php echo $globalArray[3] ?></strong></span>
                          <span><i class="fas fa-flag-usa"></i>NATIONS <strong><?php echo $globalArray[4] ?></strong></span>
                          <span><i class="fas fa-tv"></i>CHANNELS  <strong><?php echo $globalArray[5] ?></strong></span>
                          <span><i class="fas fa-wallet"></i>WALLETS <strong><?php echo $globalArray[6] ?></strong></span>


                        </div>
                      </div>

                      <div class="processOrder hidden">

                      </div>
                      <div class="orders new">
                        <?php
                           $conn->set_charset("UTF8");
                           $csl = "SELECT * FROM orders";
                           $result = mysqli_query($conn, $csl);
                           ?>
                             <div class="hiddenCount" style="display:none;" id="<?php echo $result->num_rows; ?>"></div>
                           <?php
                           $sql = "SELECT * FROM orders WHERE completed = 0 ORDER BY date DESC";
                           $result = mysqli_query($conn, $sql);
                             while($row = mysqli_fetch_assoc($result))  {
                                 $status = $row['completed'];
                                 if($status === '0'){
                                   $st = 'pending';
                                 } else {
                                   $st = 'completed';
                                 }
                                 ?>
                                 <div class="orderBar <?php echo $st ?>" id="<?php echo $row['v_key'] ?>">
                                   <span class="timeago"><?php echo humanTiming( strtotime($row['date']) ); ?></span>
                                   <span class="vkey"><?php echo $row['v_key'] ?></span>
                                   <span class="ord <?php echo $row['order'] ?>"><?php echo $row['order'] ?></span>
                                   <span class="eml"><?php echo $row['email'] ?></span>
                                   <span class="usr"><?php echo $row['username']?></span>
                                   <span class="addr"><?php if($row['address'] != 'none') { echo $row['address']; }?></span>
                                   <span class="price"><?php echo $row['setPrice'] ?></span>
                                   <span class="method"><?php echo $row['payMethod'] ?></span>


                                   <div class="remove">
                                     <form method="post">
                                       <input type="hidden" name="key" value="<?php echo $row['v_key'] ?>">
                                     <button class="rmv" type="submit" name="remove">
                                       Remove</button>
                                   </form>
                                   </div>
                                   <div class="sendToProcess">
                                     BEHANDLA ORDER
                                   </div>
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

                         <?php
                            $conn->set_charset("UTF8");
                            $csl = "SELECT * FROM orders";
                            $result = mysqli_query($conn, $csl);
                            ?>
                            <div class="breakExpand hidden">
                              <span class="txt">Visa alla (<?php echo $result->num_rows; ?>)</span>
                            </div>
                            <div class="orders hidden" id="all_orders">

                              <div class="hiddenCount" style="display:none;" id="<?php echo $result->num_rows; ?>"></div>
                            <?php
                            $sql = "SELECT * FROM orders ORDER BY date DESC";
                            $result = mysqli_query($conn, $sql);
                              while($row = mysqli_fetch_assoc($result))  {
                                  $status = $row['completed'];
                                  if($status === '0'){
                                    $st = 'pending';
                                  } else {
                                    $st = 'completed';
                                  }
                                  ?>
                                  <div class="orderBar <?php echo $st ?>" id="<?php echo $row['v_key'] ?>">
                                    <span class="timeago"><?php echo humanTiming( strtotime($row['date']) ); ?></span>
                                    <span class="vkey"><?php echo $row['v_key'] ?></span>
                                    <span class="ord <?php echo $row['order'] ?>"><?php echo $row['order'] ?></span>
                                    <span class="eml"><?php echo $row['email'] ?></span>
                                    <span class="usr"><?php echo $row['username']?></span>
                                    <span class="addr"><?php if($row['address'] != 'none') { echo $row['address']; }?></span>
                                    <span class="price"><?php echo $row['setPrice'] ?></span>
                                    <span class="method"><?php echo $row['payMethod'] ?></span>
                                    <div class="sendToProcess">
                                      BEHANDLA ORDER
                                    </div>
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

                                    <div class="optiosnHolder">

                                      <div class="remove">
                                        <form method="post">
                                          <input type="hidden" name="key" value="<?php echo $row['v_key'] ?>">
                                        <button class="rmv" type="submit" name="remove">
                                          ta bort</button>
                                      </form>
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
                <p style="margin-bottom: 50px">Lägg till, Ta bort eller ändra i hjälpcentret.</p>
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
            <div class="ui_content" id="c2" <?php # Messages / Support ?>>
              <div class="orders hcntr">
              <?php
                $sql = "SELECT * FROM support ORDER BY date DESC";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result))
                { ?>
                    <div class="orderBar help support">
                          <span class="id"><?php echo $row['name']?></span>
                          <span class="email"><?php echo $row['email']?></span>
                          <span class="comment"><?php echo $row['comment']?></span>

                          <span class="time"><?php echo humanTiming(strtotime($row['date'])) ?></span>
                          <button type="submit" name="read">Läst</button>
                    </div>
                <?php
                }
               ?>
            </div>
            </div>
            <div class="ui_content" id="c5" <?php # Wallet ?>>
              <h1>Wallets</h1>
            </div>
            </div>
              <script src="js/scnor.js<?php date('hi')?>"></script>
          <?php


        } else {
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
