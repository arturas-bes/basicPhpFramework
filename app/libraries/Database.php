<?php
/*
 * PDO Database Class
 * Connect to database
 * Create prepared statments
 * Bind values
 * Return rows and results
 */

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh; //database handler
    private $stmt;  //database statment
    private $error;

    public function __construct()
    {
        //Set DSN
        $dsn = 'mysql:host='.$this->host. ';dbname='.$this->dbname;
        $options = array(
            PDO:: ATTR_PERSISTENT => true,   //checks if connections is establisht
            PDO:: ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //handles errors
        );
        //Create PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error =  $e->getMessage();
            echo $this->error;
        }
    }

    //Prepare statment with query
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }
    //Bind values
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;

                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bind($param, $value, $type);
    }
   //Exexute prepared statment
    public function execute()
    {
        return $this->stmt->execute();
    }
    //Get results set as an objects
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    // Get single record as an object
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
    // Get row count
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
