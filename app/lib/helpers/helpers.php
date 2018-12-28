<?php
  function dnd($data){
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
  }
  function sanitize($derty){
    return htmlentities($derty,ENT_QUOTES,'UTF-8');
  }
  function currentUser(){
    return User::currentLoggedIn();
  }
