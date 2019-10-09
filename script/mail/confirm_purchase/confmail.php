<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// These must be at the top of your script, not inside a function
//Load Composer's autoloader


  if(!isset($_POST['send'])) {
    header('Location: ../../../support?');
    exit;
  } else {

  require 'vendor/autoload.php';
  include_once '../../func/co_p.php';
  $from = mysqli_real_escape_string($conn, $_POST['email']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $comment = mysqli_real_escape_string($conn, $_POST['comment']);
  if(strlen($comment) > 30){
    $prev = substr($comment, 0, 30)."...";
  } else {
    $prev = $comment;
  }
  $msg = "<h3 style='margin: 0'>Email: ".ucfirst($from)."</h3><h3 style='margin: 0 0 20px 0'>Namn: ".ucfirst($name)."</h3><span><strong style='margin-bottom: 10px'>Meddelande</strong></span><br>".$comment."<br><br><br><span style='font-style:italic;color:grey;'>Sickat från webbformulär</span><br>";
  $title = "Support - ".ucfirst($name).": ".$prev;
  // Instantiation and passing `true` enables exceptions
  $mail = new PHPMailer(true);
  try {
      //Server settings
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'server187.web-hosting.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'support@widr.tv';                 // SMTP username
      $mail->Password = 'PsBKfB2NESp8whC8';                           // SMTP password
      $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 465;                                    // TCP port to connect to
      $mail->CharSet = 'UTF-8';
      //Recipients
      $mail->setFrom("support@widr.tv", 'Kundservice - Support');
      // HEADER FROM
      $mail->addAddress("support@widr.tv", "support@widr.tv");  // Add a recipient
      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $title;
      $mail->Body    = $msg;
      $mail->AltBody = strip_tags($msg);
      $mail->send();
    } catch (Exception $e) {
        return false;
        #echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
    header('Location: ../../../support?meddelande-skickat');
    exit;
}
?>
