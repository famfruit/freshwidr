<?php
  session_start();

  include_once 'classes/comments.class.php';
  include_once 'script/func/co_p.php';
  mysqli_set_charset($conn, "utf8");
  $comment = new comment();
  if(isset($comment->submitAnswer)){
    #submitAnswer = array index
    if(isset($_COOKIE['admLogin']) && intval($_COOKIE['admLogin']) == 1){
      $comment->name = 'Admin';
      $comment->postComment();
    } else if(strtolower($comment->name != 'admin')){
      $comment->postComment();
    }
  }
  if(isset($comment->newThread)){
    if(isset($_COOKIE['admLogin']) && intval($_COOKIE['admLogin']) == 1){
      $comment->name = 'Admin';
      $comment->newComment();
    } else if(strtolower($comment->name != 'admin')){
      $comment->newComment();
    }
  }
  if(isset($comment->removeValue)){
    if(isset($_COOKIE['admLogin']) && intval($_COOKIE['admLogin']) == 1){
      $comment->removeThread();
    }
  }

  if(!isset($_COOKIE['jG3z0D'])){
    setcookie('jG3z0D', json_encode(array()), time() + (86400 * 30), "/"); // 86400 = 1 day * 30 days
  }
    //pta = pay to access
    //trial
    $route = '';
    $can = '';
    if(isset($_GET['guide']))
      {
        $can = 'guide/alla';
        $route = $_GET['guide'];
      } else if (isset($_GET['faq']))
      {
        $can = 'faq/alla';
        $route = $_GET['faq'];
      } else if (isset($_GET['issue']))
      {
        $can = 'issue/alla';
        $route = $_GET['issue'];
      }

      if(!empty($route)){
        $route = str_replace('-', ' ', $route);
        $route = ' - '.$route;
      }
      if(!isset($_GET['guide']) && !isset($_GET['faq']) && !isset($_GET['issue']))
        {
          $can = 'help';
        }

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <base href="/">
     <meta charset="utf-8">
     <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="canonical" href="https://widr.tv/<?php echo $can ?>">
     <link rel="apple-touch-icon" sizes="180x180" href="assets/img/fav/apple-touch-icon.png">
     <link rel="icon" type="image/png" sizes="32x32" href="assets/img/fav/favicon-32x32.png">
     <link rel="icon" type="image/png" sizes="16x16" href="assets/img/fav/favicon-16x16.png">
     <link rel="mask-icon" href="assets/img/fav/safari-pinned-tab.svg" color="#5bbad5">
     <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

     <link rel="stylesheet" href="assets/styles/styles.css?<?php echo date('hi') ?>">
     <script src="script/js/search.js?<?php echo date('hi') ?>"></script>
     <script src="script/js/pln.js"></script>
     <title>Hjälpcenter <?php echo ucwords($route);?> | Widr.tv</title>
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
       <div class="curve mini"></div>
     </div>

     <div class="connecting_block general helpcenter">
     <?php
      if(isset($_GET['guide'], $_GET['issue'],$_GET['faq']))
        { ?>
          <h1>Hur kan vi <strong>hjälpa dig?</strong></h1>

      <?php  }
      ?>
      <div class="sbox">
        <input type="text" name="search" value="" class="search" placeholder="Prova sök på ditt problem..">
        <i class="fas fa-search"></i>
      </div>

      <div class="resultBox"></div>

       <?php
        if(isset($_GET['guide']))
          {
            $conn->set_charset("UTF8");
            $g = mysqli_real_escape_string($conn, $_GET['guide']);
            if(empty($_GET['guide']))
              {
                //
                echo '404';
              } else {
                if($g == 'alla'){
                  $sql = "SELECT * FROM help WHERE type = 'guide' ORDER BY views DESC";
                  $result = mysqli_query($conn, $sql);
                  while($row = mysqli_fetch_assoc($result)){
                    $userContent = JSON_decode($row["usercontent"], true);
                    $viewCount = $row['views'];
                    $comCount = sizeOf($userContent["comments"]);
                    $type = $row['type'];
                    ?>
                    <div class="lsearch">
                      <?php
                        $i = 'fas fa-book';
                      ?>
                      <div class="icon">
                        <i class="<?php echo $i ?>"></i>
                      </div>
                      <div class="info">
                        <a href="<?php echo $type ?>/<?php echo $row['url_tag'] ?>"><?php echo ucfirst($row['title']) ?></a>
                        <span><?php echo $row['descr'] ?></span>
                        <div class="contentInfo">
                            <span id="c"><?php echo $comCount ?></span>
                            <span id="v"><?php echo $viewCount?></span>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                } else {
                  $sql = "SELECT *, AES_DECRYPT(usercontent, 'guide') FROM help WHERE url_tag = '$g' AND type = 'guide'";
                  $result = mysqli_query($conn, $sql);
                  $views = 0;
                  while($row = mysqli_fetch_array($result)){
                    $title = ucfirst($row['title']);
                    $views = $row['views'];
                    ?>
                    <div class="searchResults guide">
                      <h1 class="hrtitle"><?php echo $title ?></h1>

                      <?php
                      if($g != 'ladda-ner-m3u')
                        { ?>

                          <div class="psa">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h1>Hämta din M3U Länk</h1>
                            <p>Innan du påbörjar denna guide ber vi dig hämta din <a href="guide/ladda-ner-m3u">M3U Länk</a></p>
                          </div>
                      <?php  }

                      ?>
                      <div class="guideBox">
                        <?php
                        $block = explode('*', $row['text']);
                        foreach($block as $key => $guide)
                        {
                          ?>
                          <div class="gblock">
                            <?php echo $guide ?>
                          </div>
                          <?php
                        }
                        ?>
                      </div>

                    </div>

                    <div class="rateThis" style="display:block">
                      <h1 id="comments">Lämna en kommentar</h1>
                      <span>Vänligen håll god ton i kommentarsfältet.</span>


                    </div>
                    <div class="commentSection" style="padding: 20px 0 50px 0">
                      <form method="post">
                        <input name="name" type="text" placeholder="Ditt namn">
                        <input name="message" type="text" placeholder="Din kommentar..">
                        <input type="hidden" name="dbIndex" value="<?php echo $g ?>">
                        <div class="commentbtns">
                          <button type="submit" name="newThread" class="submitAnswer">Kommentera</button>
                        </div>
                      </form>
                    </div>
                    <div class="commentField">
                      <?php
                        # S: Working example
                        $userContent = JSON_decode($row["usercontent"], true);
                        $viewCount = $userContent["viewCount"];
                        $comments = $userContent["comments"];
                        foreach($userContent["comments"] as $key => $comment){
                          $mainKey = $key;
                          if(strtolower($comment['name']) === 'admin'){
                            $comment['name'] = '<i class="fas fa-shield-alt"><span>'.$comment['name'].'<span></i>';
                          }
                          ?>
                          <div class="tcom touc" data-id="<?php echo $userContent['tId'] ?>">
                            <?php
                              if(isset($_COOKIE['admLogin']) && intval($_COOKIE['admLogin']) == 1){
                                ?>
                                <form  method="post">
                                  <button type="submit" name="removeThread" value="<?php echo $mainKey ?>,null,<?php echo $g ?>">Ta bort</button>
                                </form>
                                <?php
                              }
                            ?>
                            <span class="user" <?php if($comment['likes'] < 0){ echo 'style="opacity: 0.2;text-decoration: line-through;"'; } ?>><?php echo $comment['name']?> &#8226; <strong><?php echo $comment['date'] ?></strong></span>
                            <span class="comment" <?php if($comment['likes'] < 0){ echo 'style="opacity: 0.3;text-decoration: line-through;"'; } ?>><?php echo $comment['content'] ?></span>
                            <div class="txtbtns">
                              <span class="answer_thrd">Svara</span>
                            </div>
                            <div class="commentSection">
                              <form method="post">
                                <input name="name" type="text" placeholder="Ditt namn">
                                <input name="message" type="text" placeholder="Din kommentar..">
                                <input type="hidden" name="dbIndex" value="<?php echo $g ?>">
                                <div class="commentbtns">
                                  <button type="submit" value="<?php echo $key ?>" name="submitAnswer" class="submitAnswer">Kommentera</button>
                                  <button class="cancelAnswer">Avbryt</button>
                                </div>
                              </form>
                            </div>
                              <?php if(sizeOf($comment['answers']) > 0){
                                ?>
                                <span class="commentCount">
                                  <?php
                                    echo sizeOf($comment['answers']);
                                  ?>
                                </span>
                                <?php
                               } ?>
                            <?php
                            if(sizeOf($comment['answers']) > 0){
                              foreach($comment['answers'] as $key => $response){
                                if(strtolower($response['name']) === 'admin'){
                                  $response['name'] = '<i class="fas fa-shield-alt"><span>'.$response['name'].'<span></i>';

                                }
                                ?>
                                <div class="tcom push">
                                  <?php
                                    if(isset($_COOKIE['admLogin']) && intval($_COOKIE['admLogin']) == 1){
                                      ?>
                                      <form  method="post">
                                        <button type="submit" name="removeThread" value="<?php echo $mainKey ?>,<?php echo $key ?>,<?php echo $g ?>">Ta bort</button>
                                      </form>
                                      <?php
                                    }
                                  ?>

                                  <span class="user" <?php if($response['likes'] < 0){ echo 'style="opacity: 0.2;text-decoration: line-through;"'; } ?>><?php echo $response['name']?> &#8226; <strong><?php echo $response['date'] ?></strong></span>
                                  <span class="comment" <?php if($response['likes'] < 0){ echo 'style="opacity: 0.3;text-decoration: line-through;"'; } ?>><?php echo $response['content'] ?></span>
                                  <div class="likeBtn">
                                    <div class="lkbtn like" data-index="p,<?php echo $mainKey ?>,<?php echo $key ?>,<?php echo $g ?>"></div>
                                    <span><?php echo $response['likes'] ?></span>
                                    <div class="lkbtn dislike" data-index="n,<?php echo $mainKey ?>,<?php echo $key ?>,<?php echo $g ?>"></div>
                                  </div>
                                </div>
                                <?php
                              }
                            }
                            ?>
                            <div class="likeBtn">
                              <div class="lkbtn like" data-index="p,<?php echo $mainKey ?>,null,<?php echo $g ?>"></div>
                              <span><?php echo $comment['likes'] ?></span>
                              <div class="lkbtn dislike" data-index="n,<?php echo $mainKey ?>,null,<?php echo $g ?>"></div>
                            </div>

                          </div>
                          <?php

                        }
                      ?>
                    </div>
                    <?php
                    $newViews = intval($row['views']) + 1;
                    $sql = "UPDATE help SET views = $newViews WHERE url_tag = '$g'";
                    mysqli_query($conn, $sql);
                  }

                }
              }
          } else if
          (isset($_GET['faq'])) { // OM query != guide?=
            include_once 'script/func/co_p.php';
            $conn->set_charset("utf8");
            $f = mysqli_real_escape_string($conn, $_GET['faq']);
              if(empty($_GET['faq']))
                {
                  //
                  echo '404';
                } else {
                  if($f === 'alla'){
                    $sql = "SELECT * FROM help WHERE type = 'faq'";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                      $type = $row['type'];
                      ?>
                      <div class="lsearch">
                        <?php
                          $i = 'far fa-comments';
                        ?>
                        <div class="icon">
                          <i class="<?php echo $i ?>"></i>
                        </div>
                        <div class="info">
                          <a href="<?php echo $type ?>/<?php echo $row['url_tag'] ?>"><?php echo ucfirst($row['title']) ?></a>

                          <span><?php echo $row['descr'] ?></span>
                        </div>


                      </div>
                      <?php
                    }
                  } else {
                    $sql = "SELECT * FROM help WHERE url_tag = '$f' AND  type = 'faq'";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_array($result)){
                      $title = ucfirst($row['title']);
                      ?>
                      <div class="searchResults faq">
                        <h1><?php echo $title ?></h1>
                        <span class="answ">Svar</span>
                        <span class="text"><?php echo $row['text'] ?></span>
                      </div>
                      <div class="needhelp">
                        <i class="far fa-life-ring"></i>
                        <h1>Behöver du hjälp?</h1>
                        <p>Kontakta supporten  <a href="https://widr.tv/support">här</a>  </p>
                      </div>
                      <?php
                      $newViews = intval($row['views']) + 1;
                      $sql = "UPDATE help SET views = $newViews WHERE url_tag = '$f'";
                      mysqli_query($conn, $sql);
                    }

                  }

                }


              } else if(isset($_GET['issue']))
                {
                  include_once 'script/func/co_p.php';
                  $conn->set_charset("utf8");
                  $f = mysqli_real_escape_string($conn, $_GET['issue']);
                  if(empty($_GET['issue']))
                    {
                      // 404
                      echo '404';
                    } else  {
                      if($f === 'alla'){
                        $sql = "SELECT * FROM help WHERE type = 'issue'";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)){
                          $type = $row['type'];
                          ?>
                          <div class="lsearch">
                            <?php
                              $i = 'fas fa-screwdriver';
                            ?>
                            <div class="icon">
                              <i class="<?php echo $i ?>"></i>
                            </div>
                            <div class="info">
                              <a href="<?php echo $type ?>/<?php echo $row['url_tag'] ?>"><?php echo ucfirst($row['title']) ?></a>

                              <span><?php echo $row['descr'] ?></span>
                            </div>


                          </div>
                          <?php
                        }
                      } else {
                        $sql = "SELECT * FROM help WHERE url_tag = '$f' AND type = 'issue'";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_array($result)){
                          $title = ucfirst($row['title']);
                          ?>
                          <div class="searchResults faq">
                            <h1><?php echo $title ?></h1>
                            <span class="answ">Svar</span>
                            <span class="text"><?php echo $row['text'] ?></span>
                          </div>
                          <div class="needhelp">
                            <i class="far fa-life-ring"></i>
                            <h1>Behöver du hjälp?</h1>
                            <p>Kontakta supporten  <a href="https://widr.tv/support">här</a>  </p>
                          </div>
                          <?php
                          $newViews = intval($row['views']) + 1;
                          $sql = "UPDATE help SET views = $newViews WHERE url_tag = '$f'";
                          mysqli_query($conn, $sql);
                        }
                      }
                    }
                }

              else { // om query inte är GUIDER eller C
             ?>


        <span class="underbar">Eller <strong>välj</strong> en av alternativen nedan.</span>
       <div class="bigIcons">
         <?php

            $arr = array(
                    "Guides" => array("text" => "Sök bland våra guider", "icon" => "fas fa-book"),
                    "FAQ" => array("text" => "Få svar på dina frågor", "icon" => "far fa-comments"),
                    "Felsök" => array("text" => "Hitta lösningen på ditt problem", "icon" => "fas fa-screwdriver")
                  );

            foreach($arr as $key => $value)
                {
                  if($key === 'Guides'){
                    $d = 'guide';
                  } else if ($key === 'FAQ') {
                    $d = 'faq';
                  } else if ($key === 'Felsök') {
                    $d = 'issue';
                  }
                ?>
                    <div class="block">
                      <a href="<?php echo $d ?>/alla"></a>

                      <i class="<?php echo $value['icon'] ?>"></i>
                      <h1><?php echo $key ?></h1>
                      <span><?php echo $value['text'] ?></span>
                    </div>
                <?php
              }

          ?>
       </div>

       <div class="getStarted">
         <div class="topheader">
           <h1>Komma igång</h1>
           <span>Innan du letar dig vidare ta några minuter och gå igenom problem folk har stött på förr.</span>
         </div>

         <div class="bar">
           <i class="fas fa-chevron-circle-down"></i>
             <?php
                include_once 'script/func/co_p.php';
                $conn->set_charset("UTF8");
                $sql = "SELECT * FROM help WHERE cat = 'start' ORDER BY cat";
                $result = mysqli_query($conn, $sql);
                ?>
                <h1 class="obS faq">Generella frågor (<?php echo mysqli_num_rows($result) ?>)</h1>
                <div class="hidden" id="faq">
                <?php
                  while($row = mysqli_fetch_array($result))
                    {  ?>
                        <a href="<?php echo $row['type'] ?>/<?php echo $row['url_tag'] ?>"><?php echo ucfirst($row['title']) ?></a>
                        <span><?php echo ucfirst($row['cat']) ?></span>

                  <?php  }
              ?>
           </div>
         </div>
           <div class="bar">
             <i class="fas fa-chevron-circle-down"></i>
               <?php
                  include_once 'script/func/co_p.php';
                  $conn->set_charset("UTF8");
                  $sql = "SELECT * FROM help WHERE descr = 'Installationsguide' ORDER BY cat";
                  $result = mysqli_query($conn, $sql);
                  ?>
                  <h1 class="obS install">Installation  (<?php echo mysqli_num_rows($result) ?>)</h1>
                  <div class="hidden" id="install">
                    <?php
                      while($row = mysqli_fetch_array($result))
                      {  ?>
                        <a href="guide/<?php echo $row['url_tag'] ?>"><?php echo ucfirst($row['title']) ?>

                        </a>
                        <span><?php echo ucfirst($row['cat']) ?></span>
                    <?php  }
                ?>
             </div>
           </div>
           <div class="bar">
             <i class="fas fa-chevron-circle-down"></i>
             <h1 class="obS service">Alternativt och Tjänster (0)</h1>
             <div class="hidden" id="service">
             </div>
           </div>
         </div>


       <?php  }
       ?>
       </div>
     </div>
     <?php include_once 'assets/dom/footer.php' ?>
   </body>
 </html>
 <?php

?>
