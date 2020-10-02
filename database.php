<?php

  class database{

    private $host;
    private $username;
    private $password;
    private $database;
    private $charset;
    private $db;

    public function __construct($host, $username, $password, $database, $charset){
      $this->host = $host;
      $this->username = $username;
      $this->password = $password;
      $this->database = $database;
      $this->charset = $charset;
    
      try{
        $dsn = "mysql:host=$this->host;dbname=$this->database;charset=$this->charset";
        $this->db = new PDO($dsn, $this->username, $this->password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->db;

      }catch(PDOException $e){
        echo $e->getMessage();
        exit("Failed to connect with database!");

      }

    }

    public function signUp($firstname, $middlename, $lastname, $email, $password, $username){

      try{

        $this->db->beginTransaction();

        $password = password_hash($password, PASSWORD_DEFAULT);
        $query1 = "INSERT INTO account (id, email, password) VALUES (NULL, '$email', '$password')";
        $statement1 = $this->db->prepare($query1);
        $statement1->execute();

        $id = $this->db->lastInsertId();
        $query2 = "INSERT INTO person (id, username, firstname, middlename, lastname, account_id) VALUES (NULL, '$username', '$firstname', '$middlename', '$lastname', $id)";
        $statement2 = $this->db->prepare($query2);
        $statement2->execute();

        $this->db->commit();
        header("Location: index.php");

      }catch (PDOException $e){
        throw $e;
        $this->db->rollback();
      }

    }

  }

?>