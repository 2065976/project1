<?php

  // DB PDO connection
  class database {

    private $host;
    private $username;
    private $password;
    private $database;
    private $charset;
    private $db;

    // create class constants (admin and user)
    const ADMIN = 1;
    const MOD = 2;
    const USER = 3;

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
    public function signUp($firstname, $middlename, $lastname, $email, $password, $username, $usertype_id=self::USER) {

      try {

        // Begin transaction
        $this->db->beginTransaction();

        // Hash password
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query1 = "INSERT INTO account (id, username, email, password, usertype_id) VALUES (NULL, :username, :email, :password, :usertype_id)";
        $statement1 = $this->db->prepare($query1);
        
        // Execute statement1
        $statement1->execute(
          array(
              'username' => $username,
              'email' => $email,
              'password' => $password,
              'usertype_id' => $usertype_id
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

        // Redirect user to login form
        header("Location: index.php");

        // Prevent further code being executed
        exit;

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

        $query = "SELECT firstname, middlename, lastname, email, username, password, type 
        FROM person INNER JOIN account ON person.account_id = account.id 
        JOIN usertype 
        ON account.usertype_id = usertype.id 
        WHERE username = :username ";

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

                  // User has usertype 'admin'
                  if ($rows[0]->type === 'admin') {

                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['row'] = $rows;
                    $_SESSION['type'] = $rows[0]->type;

                    // Redirect user to admin page
                    header("Location: home_admin.php"); 

                  // None of the above? Then user has usertype 'mod'
                  }elseif($rows[0]->type === 'mod') {        

                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['row'] = $rows;
                    $_SESSION['type'] = $rows[0]->type;

                    // Redirect user to mod page
                    header("Location: home_mod.php");

                  // None of the above? Then user has default usertype 'user'
                  }else {
                    
                    $_SESSION['username'] = $username;
                    $_SESSION['type'] = $rows[0]->type;

                    // Redirect user to user page
                    header("Location: home.php"); 
                  }

                // Alert user when credentials are wrong
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