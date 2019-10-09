<?php
  session_start();
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
     <script src="script/js/supportS.js?<?php echo date('hi') ?>"></script>
     <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
     <link rel="stylesheet" href="assets/styles/styles.css?">
     <script src="script/js/pln.js"></script>
     <script src="script/js/jsclick.js"></script>
     <title>Få snabb hjälp med din IPTV | Widr.tv</title>
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


     <div class="section support">
                 <h1>Hör av dig!</h1>
                 <span>Undrar du något? Vi svarar gärna på frågor!</span>
                 <span class="discl">Spana in vårat <a href="help.php"> hjälpcenter</a> för mer information.</span>


                 <div class="supportPick">
                   <div class="sp cfrm">
                     <img src="assets/img/form.png" alt="">
                     <h2>Webbformulär</h2>
                     <span>Få ditt svar direkt till din angivna email.</span>
                   </div>
                   <a href="https://discord.gg/Mqc3uzj" target="_BLANK">
                     <div class="sp">
                       <img src="assets/img/discord.png" alt="">
                       <h2>Discord</h2>
                       <span><strong>Alltid</strong> online, alltid <strong>supersnabbt!</strong> (Påskyndning av ordrar sker här)</span>
                     </div>
                   </a>
                 </div>



                 <div class="conForm pick">
                   <form method="post" action="script/mail/confirm_purchase/confmail.php">
                     <span>Namn / Användarnamn <strong>*</strong></span>
                     <input type="text" name="name">

                     <span>Email <strong>*</strong></span>
                     <input type="text" name="email">

                     <span>Meddelande <strong>*</strong></span>
                     <textarea name="comment"></textarea>

                     <button type="submit" name="send">Ropa på hjälp!</button>
                   </form>


       </div>

     </div>
     <?php include_once 'assets/dom/footer.php' ?>
   </body>
 </html>
 <?php

?>
