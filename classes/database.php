<?php
class Database{
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset = 'utf8mb4';
    private $conn;

    public function __construct(){
        $this->host = getenv("DB_HOST");
        $this->db_name = getenv("DB_NAME");
        $this->username = getenv("DB_USER");
        $this->password = getenv("DB_PASS");
    }
    public function connect(){
        $this->conn = null;
        try{
            $dsn= "mysql:host?$this->>host;dbname?=$this->>db_name;charset=$this->>charset";
            $opt=[
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES=>false,
            ];
            $this->conn=new PDO($dsn, $this->username,$this->password,$opt);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        return $this->conn;
    }
}