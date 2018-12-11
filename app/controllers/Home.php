<?php
  class Home extends Controller{
    public function __construct($controller,$action){
      parent::__construct($controller,$action);

    }
    public function indexAction(){
      $db=DB::getInstance();
    //  $sql="SELECT * FROM contact";
      $fields =[
        "nom" =>"testInsert",
        "prenom" => "testinsert"
      ];
      dnd($db->insert("contact",$fields));
      $this->view->render('home/index');

    }
  }
