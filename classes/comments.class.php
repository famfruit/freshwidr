<?php
  class comment {
    public function __construct(){
      $this->submitAnswer = isset($_POST['submitAnswer']) ? $_POST['submitAnswer'] : null;
      $this->newThread = isset($_POST['newThread']) ? $_POST['newThread'] : null;
      $this->name = isset($_POST['name']) ? $_POST['name'] : null;
      $this->message = isset($_POST['message']) ? $_POST['message'] : null;
      $this->dbIndex = isset($_POST['dbIndex']) ? $_POST['dbIndex'] : null;
      $this->theDate = date("Y-m-d H:i:s");
      $this->conn = mysqli_connect('localhost', 'root', '', 'widrgwbu_widr');
      $this->vote = isset($_POST['vote']) ? $_POST['vote'] : null;
      $this->voteData = isset($_POST['votedata']) ? $_POST['votedata'] : null;
      $this->removeValue = isset($_POST['removeThread']) ? $_POST['removeThread'] : null;
    }
    public function errorhandle(){
      if(empty($this->name) || empty($this->message)){
        return false;
      } else {
        return true;
      }
    }
    public function postComment(){
      if($this->errorhandle() != false){
        mysqli_set_charset($this->conn, "utf8");
        $sql = "SELECT usercontent FROM help where url_tag = '$this->dbIndex'";
        $dbArray = mysqli_query($this->conn, $sql);
        while($row = mysqli_fetch_array($dbArray)){
          $array = JSON_decode($row['usercontent'], true);
          $userArray = array(
            "name" => $this->name,
            "content" => $this->message,
            "likes" => 0,
            "date" => $this->theDate
          );
          array_push($array['comments'][$this->submitAnswer]['answers'], $userArray);
          $insertArray = json_encode($array, JSON_UNESCAPED_UNICODE);
          $sql = "UPDATE help SET usercontent = '$insertArray' WHERE url_tag = '$this->dbIndex'";
          mysqli_query($this->conn, $sql);
          header('Location: #comments');
          exit;
        }
      }
    }
    public function newComment(){
      if($this->errorhandle() != false){
        mysqli_set_charset($this->conn, "utf8");
        $sql = "SELECT usercontent FROM help where url_tag = '$this->dbIndex'";
        $dbArray = mysqli_query($this->conn, $sql);
        while($row = mysqli_fetch_array($dbArray)){
          $array = JSON_decode($row['usercontent'], true);
          $userArray = array(
            "name" => $this->name,
            "content" => $this->message,
            "date" => $this->theDate,
            "likes" => 0,
            "answers" => array()
          );
          array_push($array['comments'], $userArray);
          $insertArray = json_encode($array, JSON_UNESCAPED_UNICODE);
          $sql = "UPDATE help SET usercontent = '$insertArray' WHERE url_tag = '$this->dbIndex'";
          mysqli_query($this->conn, $sql);
          header('Location: #comments');
          exit;
        }
      }
    }
    public function removeThread(){
      mysqli_set_charset($this->conn, "utf8");
      #echo $this->removeValue;
      $data = explode(",", $this->removeValue);
      #var_dump($data);
      $mIndex = $data[0];
      $subIndex = $data[1];
      $tag = $data[2];
      $sql = "SELECT usercontent FROM help WHERE url_tag = '$tag'";
      $result = mysqli_query($this->conn, $sql);
      while($row = mysqli_fetch_assoc($result)){
        $uc = json_decode($row['usercontent'], true);
        $pointer = $uc['comments'][$mIndex];
        if($subIndex != 'null'){
          #var_dump($pointer['answers'][$subIndex]);
          unset($uc['comments'][$mIndex]['answers'][$subIndex]);
          $newArray = array_values($uc['comments']);
        } else {
          #var_dump($pointer);
          unset($uc['comments'][$mIndex]);
          $newArray = array_values($uc['comments']);
        }
        #var_dump($newArray);
        $uc['comments'] = $newArray;
        #var_dump($uc);
        $inputArray = json_encode($uc, JSON_UNESCAPED_UNICODE);
        $sql = "UPDATE help SET usercontent = '$inputArray' WHERE url_tag = '$tag'";
        mysqli_query($this->conn, $sql);
        header('Location: #comments');
        exit;
      }
    }
    public function blockVote($mainIndex, $subIndex, $dbIndex){
      $cookie = json_decode($_COOKIE['jG3z0D'], true);
      $keyStr = $mainIndex.",".$subIndex.",".$dbIndex;
      $c = 0;
      foreach($cookie as $key => $value){
        if($value === $keyStr){
          $c++;
        }
      }
      if($c === 0){
        return true;
      } else {
        return false;
      }
    }
  }
  if(isset($_POST['vote'])){
    session_start();
    $comment = new comment();
    mysqli_set_charset($comment->conn, "utf8");
    $data = explode(",",$comment->voteData);
    $pointer = $data[0];
    $mIndex = $data[1];
    $subIndex = $data[2];
    $dbIndex = $data[3];

    if($comment->blockVote($mIndex, $subIndex, $dbIndex) != false){

      $returnNum = 0;
      $sql = "SELECT usercontent FROM help WHERE url_tag = '$dbIndex'";
      $result = mysqli_query($comment->conn, $sql);
      while($row = mysqli_fetch_assoc($result)){
        $data = json_decode($row['usercontent'], true);

        if($subIndex != 'null'){
          #this is a subthread vote1
          if($pointer == 'p'){
            $data['comments'][$mIndex]['answers'][$subIndex]['likes'] = $data['comments'][$mIndex]['answers'][$subIndex]['likes'] + 1;
            $returnNum = $data['comments'][$mIndex]['answers'][$subIndex]['likes'];
          } else {
            $data['comments'][$mIndex]['answers'][$subIndex]['likes'] = $data['comments'][$mIndex]['answers'][$subIndex]['likes'] - 1;
            $returnNum = $data['comments'][$mIndex]['answers'][$subIndex]['likes'];
          }
        } else {
          if($pointer == 'p'){
            $data['comments'][$mIndex]['likes'] = $data['comments'][$mIndex]['likes'] + 1;
            $returnNum = $data['comments'][$mIndex]['likes'];
          } else {
            $data['comments'][$mIndex]['likes'] = $data['comments'][$mIndex]['likes'] - 1;
            $returnNum = $data['comments'][$mIndex]['likes'];
          }
        }



        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $sql = "UPDATE help SET usercontent = '$data' WHERE url_tag = '$dbIndex'";
        mysqli_query($comment->conn, $sql);
        echo $returnNum;


      }
      ## set block-cookie
      $currentCookieValue = json_decode($_COOKIE['jG3z0D'], true);
      $latestValue = $mIndex.",".$subIndex.",".$dbIndex;
      array_push($currentCookieValue, $latestValue);
      #var_dump($cookie_value);
      $cn = 'jG3z0D';
      setcookie($cn, json_encode($currentCookieValue), time() + (86400 * 30), "/"); // 86400 = 1 day * 30 days

    } else {
      #block user from voting on this one
      return false;
    }
  }
