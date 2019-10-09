<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// These must be at the top of your script, not inside a function
//Load Composer's autoloader


if(isset($_POST['sndml'])) {

  require 'vendor/autoload.php';
  include_once '../../func/co_p.php';
  $conn->set_charset("UTF8");
  $mottagare = mysqli_real_escape_string($conn, $_POST['email']);
  $id = mysqli_real_escape_string($conn, $_POST['orderID']);
  $type = mysqli_real_escape_string($conn, $_POST['mailtype']);
  $sql = "SELECT * FROM orders WHERE v_key = '$id'";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_assoc($result))
    {

      $body = '';
      $title = '';
  if($type == 'process')
    {
      //mark order as complete and set complete_date
      // sql n stuff
      $odate = date('Y-m-d H:i:s');
      $sql = "UPDATE orders SET completed = 1, date_completed = '$odate' WHERE v_key = '$id'";
      mysqli_query($conn, $sql);

      $a1 = '<h2>Din betalning lyckades!</h2>';

      $details = '<h3>Användaruppgifter</h3><p>Användarnamn: <strong>'.$_POST['username'].'</strong><br>Lösenord: <strong>'.$_POST['password'].'</strong></p>';
      $footer = '<br><br><h3>Logga in och hämta din M3U Länk på<br>www.widr.tv/login</h3><br><p>Har du problem? Vi hjälper dig på www.widr.tv/guide/alla';


      $body = $a1.$details.$footer;
      $title = 'Widr.tv - Orderleverans: '.strtoupper($row['order']).' #'.$id;
      $btcadr = $row['address'];
      $method = $row['payMethod'];
      if($method != 'free'){
        if($method == 'swish'){
          $sql = "UPDATE wallet set used = 0, blocked = 1 WHERE hash = '$btcadr'";
        } else if($method == 'bitcoin'){
          $sql = "UPDATE wallet set used = 0 WHERE hash = '$btcadr'";
        }
        mysqli_query($conn, $sql);
      }
    }
    else if ($type == 'order')
    {
      // Import PHPMailer classes into the global namespace
      $a1 = '<h2>Tack för din beställning, '.$row['username'].'</h2>';
      $a4 = '<h3>Följ din order: www.widr.tv/betala/'.$id.'</h3>';
      $a2 = '<p>Nedan ser du din personliga Bitcoinadress. Denna adress är knuten till din order och när den korrekta summan finns på kontot, behandlas din order.</p>';
      $a3 = '<h3>'.$row['address'].'</h3>';



      $details = '<h3>Orderdetaljer</h3><span><strong>Namn:</strong> '.$row['username'].' </span><br><span><strong>Email:</strong> '.$row['email'].'</span><br><span><strong>Betalningsmetod:</strong> '.$row['payMethod'].'</span><br><span><strong>Total:</strong> '.$row['finalValue'].' </span><br><span><strong>Period:</strong> '.$row['time'].'</span><br><span><strong>BTC Adress: </strong> '.$row['address'].'';
      $body = $a1.$a2.$a3.$a4.$a5.'<br><br><br>'.$details.'<br>';
      $title = 'Widr.tv - Orderbekräftelse: '.strtoupper($row['order']).' #'.$id;
    }


}

  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'server187.web-hosting.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'support@widr.tv';                 // SMTP username
    $mail->Password = 'PsBKfB2NESp8whC8';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to
    $mail->CharSet = 'UTF-8';
    //Recipients
    $mail->setFrom('support@widr.tv', 'Widr.tv - Sveriges bästa IPTV'); // HEADER FROM
    $mail->addAddress($mottagare, $mottagare);  // Add a recipient


    //Content

    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $title;
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);

    $mail->send();
  } catch (Exception $e) {
      echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;

  }
}
?>
