<?php
  class Validate{
    private $passed=false, $_db=nul, $errors=[];
    public function __construct(){
      $this->_db=DB::getInstance();
    }

    public function check($source,$items=[]){
      $this->errors=[];
      foreach ($items as $item => $rules) {
        $display=$rules['display'];
        foreach ($rules as $rule => $rule_value) {
          $value=Input::sanitize(trim($source[$item]));
          if($rule=='required'  && empty($value)){
            $this->addError(["{$display} is required",$item]);
          }else if(!empty($value)){
            switch ($rule) {
              case 'min':
                if(strlen($value)<$rule_value){
                  $this->addError(["{$display} must be a minimum of {$rule_value} characters",$item]);
                }
                break;
              case 'max':
                if(strlen($value)>$rule_value){
                  $this->addError(["{$display} must be a maximum of {$rule_value} characters",$item]);
                }
                break;
              case 'matches':
                if($value != $source[$rule_value]){
                  $matchDisplay= $item[$rule_value]['display'];
                  $this->addError(["{$matchDisplay} and {$display} must match",$item]);
                }
                break;
              case 'unique':
                $check=$this->_db->query("SELECT {$item} FROM {$rule_value} WHERE {$item} =?",[$value]);
                if($check->count()){
                  $this->addError(["{$display} already exists, please choose another {$display}",$item]);
                }
                break;
              case 'unique_update':
                $t=explode(",", $rule_value);
                $table =$t[0];
                $id=$t[1];
                $query=$this->_db->query("SELECT * FROM {$table} WHERE id != ? AND {$item}=?",[$item, $value]);
                if($query->count()){
                  $this->addError(["{$display} already exists, please choose another {$display}",$item]);
                }
                break;
              case 'is_numeric':
                if(!is_numeric($value)){
                  $this->addError(["{$display} has to be a numeric, please type a numeric value",$item]);
                }
                break;
              case 'valid_email':
                if(!filter_var($var, FILTER_VALIDATE_EMAIL)){
                  $this->addError(["{$display} has to be a valid email",$item]);
                }
                break;
            }

          }
        }
      }
    }
    public function addError($error){
      $this->errors=$error;
      if(empty($this->_errors)){
        $this->passed=true;
      }else {
          $this->passed=false;
      }
    }
    public function errors(){
      return $this->errors;
    }
    public function pass(){
      return $this->passed;
    }
    public function displayErrors(){
      $html='<ul class="bg-danger"';
      foreach ($this->$errors as $error) {
        $html.='<li class="text-danger">'.$error[0].'</li>';
        $html.='<script>jQuery("document").ready(function(){jQuery("#'.$error[1].'").parent().closest("div").addClass("has-error");});</script>';
      }
      $html.='</ul>';
      return $html;
    }

  }
