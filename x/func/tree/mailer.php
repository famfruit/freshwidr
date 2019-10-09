<?php
  include_once '../../tree/m.php';
  if(!isset($_POST['set'])){
    header('Location: ../../../?gtfo');
    exit;
    return false;
  } else {


    ### Function delcare
    function remove($id){
      $sql = "UPDATE orders SET completed = 2 WHERE v_key = '$id'";
      $result = mysqli_query($conn, $sql);


      if($mysql){ echo 'remove'; }
    }
    ### Function delcare
    $type = $_POST['type'];
    if($type === 'remove'){
      remove($_POST['id']);
    }
  }
