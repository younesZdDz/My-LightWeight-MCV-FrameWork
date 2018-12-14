<?php
  class Home extends Controller{
    public function __construct($controller,$action){
      parent::__construct($controller,$action);

    }
    public function indexAction(){
      $db=DB::getInstance();
      $sql="SELECT * FROM contact";
      $result=$db->delete("contact",1 );
      dnd($result);
      $this->view->render('home/index');

    }
  }
