<?php
  class DB{
    private static $_instance=null;
    private $_pdo,$_query,$_error=false, $_result, $_count=0,$_lastInsertId=null;


    private function __construct(){
      try{
        $this->_pdo=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
      }catch(PDOException $e ){
        die($e->getMessaage());
      }
    }


    public static function getInstance(){
      if(!isset(self::$_instance)){
        self::$_instance=new DB();
      }
      return self::$_instance;
    }

    public function query($sql, $params=[]){
      $this->_error=false;
      if($this->_query=$this->_pdo->prepare($sql)){
        $x=1;
        if(count($params)){
          foreach ($params as $param) {
            $this->_query->bindValue($x, $param);
            $x++;
          }
        }

        if($this->_query->execute()){
          $this->_result=$this->_query->fetchALL(PDO::FETCH_OBJ);
          $this->_count=$this->_query->rowCount();
          $this->_lastInsertId=$this->_pdo->lastInsertId();

        }else{
          $this->_error=true;
        }

      }else{
        $this->_error=true;
      }

      return $this;
    }


    public function insert($table, $fields=[]){
      $valueString='';
      $fieldString='';
      $values=[];
      foreach ($fields as $field => $value) {
        $fieldString .= '`'.$field.'`,';
        $valueString .= '?,';
        $values []=$value;
      }

      $fieldString=rtrim($fieldString,',');
      $valueString=rtrim($valueString,',');
      $sql="INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";
      if(!$this->query($sql,$values)->error()){
        return true;
      }
      return false;
    }


    public function update($table,$id,$params){
      $paramsString='';
      $values=[];
      if(isset($params) && !empty($params) && isset($id) && !empty($id)){

        foreach ($params as $field => $value) {
          $paramsString.=' '.$field.'=? ,';
          $values[]=$value;
        }
        $values[]=$id;
        $paramsString=trim($paramsString);
        $paramsString=rtrim($paramsString,' ,');
        $sql="UPDATE {$table}  SET {$paramsString} WHERE id=?";
        return $this->query($sql,$values)->_error;
      }
      return false;
    }

    public function delete($table,$id){
      $sql="DELETE FROM {$table} WHERE id= ?";
      if(!$this->query($sql,[$id])->_error){
        return true;
      }
      return false;

    }

    public function results(){
      return $this->_result;
    }

    public function first(){
      return (!empty($this->_result)) ? $this->_result[0] : [] ;
    }

    public function count(){
      return $this->_count;
    }

    public function lastID(){
      return $this->_lastInsertId;
    }

    public function showColumns($table){
      return $this->query("SHOW COLUMNS FROM {$table}")->results();
    }

    private function _read($table,$params){
      //conditions
      $conditionsString='';
      $bind=[];
      $order='';
      $limit='';
      if(array_key_exists('conditions', $params)){
        if(is_array($params['conditions'])){
          foreach ($params['conditions'] as $condition) {
            $conditionsString .= ' '.$condition. ' AND ';
          }
          $conditionsString=trim($conditionsString);
          $conditionsString=rtrim($conditionsString,' AND');

        }else{
          $conditionsString =$params['conditions'];
        }
        if($conditionsString != ''){
          $conditionsString=' WHERE ' . $conditionsString;
        }
      }

      // bind
      if(array_key_exists('bind', $params)){
        $bind=$params['bind'];
      }
      //order
      if(array_key_exists('order', $params)){
        $order=' ORDER BY '.$params['order'];
      }
      //limit
      if(array_key_exists('limit', $params)){
        $order=' LIMIT '.$params['limit'];
      }

      $sql="SELECT * FROM {$table}{$conditionsString}{$order}{$limit}";
      
      if(!$this->query($sql,$bind)->_error){
        if(!count($this->_result))
          return false;
        return true;
      }
      return false;
    }

    public function find($table,$params){
      if($this->_read($table,$params)){
        return $this->results();
      }
      return false;
    }
    public function findFirst($table,$params){
      if($this->_read($table,$params)){
        return $this->first();
      }
      return false;
    }

    public function error(){
      return $this->_error;
    }
  }
