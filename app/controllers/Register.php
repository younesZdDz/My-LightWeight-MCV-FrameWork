<?php
  class Register extends Controller{
    public function __construct($controller,$action){
      parent::__construct($controller,$action);
      $this->load_model('Users');
      $this->view->setLayout('default');
    }
    public function loginAction(){
      $validation=new Validate();
      if($_POST){
        $validation->check($_POST,[
          "username"=>[
            'display' => true,
            'required'=>true
          ],
          "password"=>[
            'display' => true,
            'required'=>true
        ]]);
        if($validation->pass()){
          $user=$this->UsersModel->findByUsername($_POST['username']) ;
          if ($user && !password_verify(Input::get('password'),$user->password)){
            $remember= (isset($_POST['remember_me']) && Input::get('remember_me')) ? true : false;
            $user->login($remember);

            Router::redirect('');
          }
        }
      }
      $this->view->displayErrors=$validation->displayErrors();
      $this->view->render('register/login');

    }
    public function logout(){
      if(currentUser){
        currentUser()->logout();
      }
      Router::redirect('register/login');
    }
  }
