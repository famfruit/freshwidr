<?php
  class hash {
    public function __construct(){
      $this->inputString = "ABC";
      $this->letters = array(
        " " => "ZZZ",
        "A" => 111,
        "a" => 110,
        "B" => 222,
        "b" => 220,
        "C" => 333,
        "c" => 330
      );
    }
    public function encrypt($string){
      $string = str_split($string);
      foreach($string as $value){
        echo $value;

      }
    }
  }
