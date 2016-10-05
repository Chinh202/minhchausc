<?php

class  Product{
      /* các biến thành viên */
      var $name;
      var $price;
      var $type;
      var $producer;
      var $year;
      var $url;
      
      /* các hàm thành viên */
      function setPrice($par){
         $this->price = $par;
      }
      
      function getPrice(){
         echo $this->price;
      }
      
      function setName($par){
         $this->name = $par;
      }
      
      function getName(){
         echo $this->name;
      }
      function setType_id($par){
         $this->type_id = $par;
      }
      
      function getType_id(){
         echo $this->type_id;
      }
      function setProducer($par){
         $this->producer = $par;
      }
      
      function getProducer(){
         echo $this->producer;
      }
      function setYear($par){
         $this->year = $par;
      }
      
      function getYear(){
         echo $this->year;
      }
      function setUrl($par){
         $this->url = $par;
      }
      
      function getUrl(){
         echo $this->url;
      }
   }
