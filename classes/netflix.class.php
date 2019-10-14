<?php
  class netflix {
    public function __construct(){
      $this->key = "5bea29aec07ce4f0a098fd3f9f460e4a";
      $this->api = "https://api.themoviedb.org/3/search/movie?api_key=".$this->key;
      $this->apiTv = "https://api.themoviedb.org/3/search/tv?api_key=".$this->key;
      $this->con = mysqli_connect('localhost', 'root', '', 'media');
      $this->latestCookie = isset($_COOKIE['latest']) ? $_COOKIE['latest'] : null;
      $this->moviePage = isset($_GET['movie']) ? $_GET['movie'] : null;
      $this->seriesPage = isset($_GET['serie']) ? $_GET['serie'] : null;
      $this->historyPage = isset($_GET['history']) ? $_GET['history'] : null;
      $this->searchBarKey = isset($_POST['searchBarKey']) ? $_POST['searchBarKey'] : null;
      $this->searchValue = isset($_POST['keyString']) ? str_replace(" ", "-", $_POST['keyString']) : null;
      $this->loginSet = isset($_POST['loginSet']) ? $_POST['loginSet'] : null;
      $this->username = isset($_POST['username']) ? $_POST['username'] : null;
      $this->password = isset($_POST['password']) ? $_POST['password'] : null;
      $this->typeCat = isset($_GET['c']) ? $_GET['c'] : null;
      $this->dateCreated = date("Y-m-d H:i:s");
      $this->profilePage = isset($_GET['profile']) ? $_GET['profile'] : null;
      # i = initial setup, not yet registered or logged in
      $this->authPage = isset($_POST['i']) ? $_POST['i'] : null;
      $this->loginCookie = isset($_COOKIE['sessionSettings']) ? $_COOKIE['sessionSettings'] : null;
      $this->logout = isset($_GET['logout']) ? $_GET['logout'] : null;
      $this->decodedUser = json_decode($this->loginCookie, true);
      $this->userChangeSet = isset($_POST['userChangeSet']) ? $_POST['userChangeSet'] : null;
      $this->userChangeInfo = isset($_POST['userChangeInfo']) ? $_POST['userChangeInfo'] : null;
      $this->generateInvite = isset($_POST['generateInvite']) ? $_POST['generateInvite'] : null;
      $this->genres = array(
        "action" => 28,
        "animerad" => 16,
        "dokumentär" => 99,
        "drama" => 18,
        "familj" => 10751,
        "fantasi" => 14,
        "historia" => 36,
        "komedi" => 35,
        "krig" => 10752,
        "brott" => 80,
        "musik" => 10402,
        "mysterium" => 9648,
        "romantik" => 10749,
        "sci-fi" => 878,
        "skräck" => 27,
        "tv-film" => 10770,
        "thriller" => 53,
        "western" => 37,
        "äventyr" => 12
      );
    }

    public function randomString($num){
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $num; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }
    public function buildDatabase($title){
      $data = json_decode(file_get_contents($this->api."&query=".$title."&language=sv",true), true);
      if($data){
        return $data['results'][0];
      } else {
        return null;
      }
    }
    public function getFromAPI($title){
      $data = json_decode(file_get_contents($this->api."&query=".$title."&language=sv",true), true);
      return $data;
    }
    public function getFromAPI_tv($title){
      $data = json_decode(file_get_contents($this->apiTv."&query=".$title."",true), true);
      return $data;
    }
    public function getFromMysql($string){
      $result = mysqli_query($this->con, $string);
      return $result;
    }
    public function setLatestId($titleArray, $type){
      if(isset($this->latestCookie)) {
          $cookieArray = json_decode($this->latestCookie, true);
          # Find if it already exists, discard if so
          $compareArray = $cookieArray[$type];
          if(empty($compareArray)){
            ## If the array[INDEX] is empty, meaning no movie or serie
            ## add to brand new index
            $newArray = array(
              "id" => $titleArray['id'],
              "title" => $titleArray['title'],
              "img" => $titleArray['img'],
              "genre" => $titleArray['genre'],
              "clicks" => 0,
              "type" => $type
            );
            array_push($cookieArray[$type], $newArray);
            $encodedCookie = json_encode($cookieArray);
            setcookie('latest', $encodedCookie, time() + (86400 * 30), "/"); // 86400 = 1 day
          } else {
            ## Theres more 1 or more in this array[index]
            ## First, see if we can find someone with the same name
            ## If we find a match in the titles, we add 1 to the counter
              $doubleCount = 0;
              $matchingKey = 0;
              foreach($compareArray as $key => $value){
                if($value['title'] == $titleArray['title']){
                  $matchingKey = $key;
                  $doubleCount = $doubleCount + 1;
                }
              }
            ## If the counter is clean, theres no entry like this
              if($doubleCount === 0){
                ## This a unique title in the subindex, proceed to add
                $newArray = array(
                  "id" => $titleArray['id'],
                  "title" => $titleArray['title'],
                  "img" => $titleArray['img'],
                  "genre" => $titleArray['genre'],
                  "clicks" => 0,
                  "type" => $type
                );
                array_push($cookieArray[$type], $newArray);
                $encodedCookie = json_encode($cookieArray);
                setcookie('latest', $encodedCookie, time() + (86400 * 30), "/"); // 86400 = 1 day
              } else {
                ## Theres 1 existing entry of this type
                ## Increment its viewcount and exit
                $cookieArray[$type][$matchingKey]['clicks'] = $cookieArray[$type][$matchingKey]['clicks'] + 1;
                $encodedCookie = json_encode($cookieArray);
                setcookie('latest', $encodedCookie, time() + (86400 * 30), "/"); // 86400 = 1 day
              }
          }
      }
    }

    public function compileGenres($array){
      $returnString = "";
      $array = json_decode($array, true);
      # Returns null if the serie/movie dont have GENRES SET
      foreach($array as $k => $v){
          // 28
          foreach($this->genres as $i => $y){
            if($v === $y){
              $returnString = $returnString.$i." &#8226; ";
            }
          }
      }
      return substr_replace($returnString, "", - 9);
    }
    public function getSingleGenre(){
      foreach($this->genres as $key => $value) {
        if($this->typeCat == $value){
          return $key;
        }
      }
    }
    public function search($string){
      #$sql = "SELECT * FROM movies WHERE title LIKE '%$string%' UNION SELECT * FROM series WHERE title LIKE '%$string%'";
      #$sql = "SELECT * FROM tutorial WHERE MATCH (title) AGAINST ('$string' IN NATURAL LANGUAGE MODE)";
      #$sql = "SELECT *, 'film' as moviedb FROM movies WHERE title LIKE '%$string%' UNION SELECT *, 'serie' as moviedb FROM series WHERE title LIKE '%$string%'";


      $sql = "SELECT *, 'serie' as moviedb FROM series WHERE MATCH(title) AGAINST ('$string*' IN BOOLEAN MODE) UNION SELECT *, 'film' as moviedb FROM movies WHERE MATCH(title) AGAINST ('$string*' IN BOOLEAN MODE) LIMIT 100";
      $result = mysqli_query($this->con, $sql);
      $array = array();
      if(mysqli_num_rows($result) == 0){
        $array = array("error" => "404", "input" => $string);
        echo json_encode($array);
        exit;
      } else {
        while($row = mysqli_fetch_assoc($result)){
          if(!$row['genre']){

            $genre = "asdf";
          } else {
            $genre = $this->compileGenres($row['genre']);

          }
          if($row['moviedb'] == 'film'){
            $link = "?movie=".$row['title'];
          } else if($row['moviedb'] == 'serie'){
            $link = "?serie=".$row['title'];
          }
          #$searchArray = array(str_replace("-", " ",$row['title']), "https://image.tmdb.org/t/p/w185".$row['img'], $genre, $row['moviedb'], $link);
          $searchArray = array(
            str_replace("-", " ",$row['title']),
            "https://image.tmdb.org/t/p/w185".$row['img'],
            $genre,
            $row['moviedb'],
            $link
          );
          array_push($array, $searchArray);
        }
        echo json_encode($array);
      }

    }

    public function sortByViews($a, $b){
      return $a['clicks'] - $b['clicks'];
    }
    public function authenticate(){
      ## True / False return
      $result = $this->getFromMysql("SELECT * FROM clients WHERE name = '$this->username'");
      if(mysqli_num_rows($result) == 0){
        echo "404";
        return false;
      } else {
        while($row = mysqli_fetch_assoc($result)){
          if(!password_verify($this->password, $row['password'])){
            echo "503";
            return false;
          } else {
            $userArray = json_encode(array("id" => $row['id'], "username" => $row['name'], "ecpw" => $this->password));
            setcookie('sessionSettings', $userArray, time() + (86400 * 30), "/");
            echo "true";
            exit;
          }
        }
      }
    }
    public function increaseView($id, $type){
      $result = $this->getFromMysql("SELECT views FROM $type WHERE id = $id");
      while($row = mysqli_fetch_assoc($result)){
        $views = $row['views'] + 1;
        mysqli_query($this->con, "UPDATE $type SET views = $views WHERE id = $id");
      }
    }

    public function personalizeRecom(){
          $cookie = json_decode($this->latestCookie);
          $moviePoints = array("28" => 0, "16" => 0, "99" => 0, "18" => 0, "10751" => 0, "14" => 0, "36" => 0, "35" => 0, "10752" => 0, "80" => 0, "10402" => 0, "9648" => 0, "10749" => 0, "878" => 0, "27" => 0, "10770" => 0, "53" => 0, "37" => 0, "12" => 0);
          foreach($cookie->movie as $key => $value) {
            $val = json_decode($value->genre);
            if($val != NULL){
              foreach($val as $k => $num){
                foreach($moviePoints as $m => $p){
                  if($num == $m){
                    # Got a match
                    $moviePoints[$num] += 1;
                  }
                }
              }
            }
          }
          foreach($cookie->serie as $key => $value) {
            $val = json_decode($value->genre);
            if($val != NULL){
              foreach($val as $k => $num){
                foreach($moviePoints as $m => $p){
                  if($num == $m){
                    # Got a match
                    $moviePoints[$num] += 1;
                  }
                }
              }
            }
          }

          #var_dump($moviePoints);
          $highNum = ["", 0];
          foreach($moviePoints as $key => $value){
            if($value >= $highNum[1]){
              $highNum[1] = $value;
              $highNum[0] = $key;
            }
          }

          $cat = strval($highNum[0]);
          $sql = "SELECT *, 'movies' as mc FROM movies WHERE genre LIKE '%$cat%' UNION SELECT *, 'series' as mc FROM series WHERE genre LIKE '%$cat%' ORDER BY releasedate DESC LIMIT 1";
          $result = $this->getFromMysql($sql);
          return $result;
    }

    public function changeUser(){
      var_dump($this->userChangeInfo);
      $email = $this->userChangeInfo[1];
      $password = password_hash($this->userChangeInfo[2], PASSWORD_DEFAULT);
      $id = (int)$this->userChangeInfo[3];
      $sql = "UPDATE clients SET password = '$password', email = '$email' WHERE id = $id";
      if(mysqli_query($this->con, $sql)){
        $cookie = json_decode($this->loginCookie, true);
        $cookie['ecpw'] = $this->userChangeInfo[2];
        var_dump($cookie);
        $cookie = json_encode($cookie);
        setcookie('sessionSettings', $cookie, time() + (86400 * 30), "/");

        return true;
      } else {
        return false;
      }
    }
    public function generateKey(){
      ## Dubblecheck if the user has invites left
      ## if so, consume one and make it
      ## return true
      $cookie = json_decode($this->loginCookie, true);
      $id = (int)$cookie['id'];
      $sql = "SELECT * FROM clients WHERE id = $id";
      $result = $this->getFromMysql($sql);
      while($row = mysqli_fetch_assoc($result)){
          $invite = $row['invites'];
          if($invite != 0){
            $newinvite = $invite - 1;
            $vkey = $this->randomString(15);
            $ref = $cookie['username'];
            $thedate = date("Y-m-d H:i:s");
            $sql = "INSERT INTO invites (vkey, status, ref, date, completed, reguser) VALUES ('$vkey', 0,'$ref','$thedate', '0', '')";
            mysqli_query($this->con, $sql);


            $sql = "UPDATE clients SET invites = $newinvite WHERE id = $id";
            mysqli_query($this->con, $sql);


            $returnArray = array(
              "invitesLeft" => $newinvite,
              "vkey" => $vkey,
              "date" => $thedate,
              "status" => 0
            );
            echo json_encode($returnArray);
            return true;
          } else {
            echo "404";
            return false;
          }
      }
    }
  }
