<?php

  // DB PDO connection
  class database {

    private $host;
    private $username;
    private $password;
    private $database;
    private $charset;
    private $db;

    public function __construct($host, $username, $password, $database, $charset) {
      $this->host = $host;
      $this->username = $username;
      $this->password = $password;
      $this->database = $database;
      $this->charset = $charset;
    
      try {
        $dsn = "mysql:host=$this->host;dbname=$this->database;charset=$this->charset";
        $this->db = new PDO($dsn, $this->username, $this->password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->db;

      }catch(PDOException $e) {
        echo $e->getMessage();
        exit("Failed to connect with database!");

      }

    }

    // SignUp function
    public function signUp($firstname, $middlename, $lastname, $email, $password, $username) {

      try {

        // Begin transaction
        $this->db->beginTransaction();

        // Hash password
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query1 = "INSERT INTO account (id, username, email, password, usertype_id) VALUES (NULL, :username, :email, :password, 1)";
        $statement1 = $this->db->prepare($query1);
        // Execute statement1
        $statement1->execute(
          array(
              'username' => $username,
              'email' => $email,
              'password' => $password
          )
        );

        // Use last inserted id value
        $id = $this->db->lastInsertId();
        $query2 = "INSERT INTO person (id, firstname, middlename, lastname, account_id) VALUES (NULL, :firstname, :middlename, :lastname, $id)";
        $statement2 = $this->db->prepare($query2);
        // Execute statement2
        $statement2->execute(
          array(
              'firstname' => $firstname,
              'middlename' => $middlename,
              'lastname' => $lastname,
          )
        );

        // Commit changes
        $this->db->commit();
        // Prevent adding extra data during refresh
        header("Location: index.php");

      }catch (PDOException $e) {
        throw $e;
        // Rollback changes if something went wrong
        $this->db->rollback();
      }

    }

    // Login function
    public function login($username, $password) { 

      try {  
        
        // Begin transaction
        $this->db->beginTransaction(); 

        $query = "SELECT firstname, middlename, lastname, email, username, password, type FROM person INNER JOIN account ON person.account_id = account.id JOIN usertype ON account.usertype_id = usertype.id WHERE username = :username ";
        $statement = $this->db->prepare($query);

        // Execute statement1
        $statement->execute(
          array(
            'username' => $username
          )
        );

        $rows = $statement->fetchAll(PDO::FETCH_OBJ);

        foreach ($rows as $row) {
          $rowpassword = $row->password;
        }

          if (count($rows) > 0) { 

            $verify = password_verify($password, $rowpassword);

              if ($verify) {
                session_start();

                  if ($rows[0]->type === 'admin') {
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['row'] = $rows;
                    $_SESSION['type'] = $rows[0]->type;
                    header("Location: home.php"); 

                  }elseif($rows[0]->type === 'mod') {                        
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['row'] = $rows;
                    $_SESSION['type'] = $rows[0]->type;
                    header("Location: home.php"); 

                  }else {
                    $_SESSION['username'] = $username;
                    $_SESSION['type'] = $rows[0]->type;
                    header("Location: home.php"); 
                  }

                // Alert when credentials are wrong
                }else {
                  $alert = '<div class="alert alert-warning"><a href="#" class="close" alert-block data-dismiss="alert" aria-label="close">&times;</a>'.'Username and/or password incorrect' .'</div>';
                  $_SESSION['alert'] = $alert;
                }

              }else {
                $alert = '<div class="alert alert-warning"><a href="#" class="close" alert-block data-dismiss="alert" aria-label="close">&times;</a>'.'Username and/or password incorrect' .'</div>';
                $_SESSION['alert'] = $alert;
              }

        // Commit changes
        $this->db->commit();                    

      } 
      catch (PDOException $e) { 
          throw $e;
      }    

    }

  }

?>