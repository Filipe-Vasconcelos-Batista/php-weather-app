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
    public function createTable(){
        try{
            $sql = "CREATE TABLE IF NOT EXISTS searchTable (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                times_searched INT(6) NOT NULL
            )";
            $this->conn->exec($sql);
            echo "Table searchTable created successfully";
        } catch(PDOException $e){
            echo $sql . "<br>" . $e->getMessage();
        }
    }
    public function searchCity($cityName){
        try{
            $stmt=$this->conn->prepare("SELECT * FROM searchTable WHERE name=:$cityName");
            $stmt->execute(['cityName=$cityName']);
            $result=$stmt->fetchColumn();;
            if($result !==false){
                return $result;
            }else{
                return false;
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }    public function addCity($cityName){
    try{
        $stmt = $this->conn->prepare("INSERT INTO searchTable (name, times_searched) VALUES (:cityName, 1)");
        $stmt->execute(['cityName' => $cityName]);

        echo "City: " . $cityName . " added successfully with 1 search count.";
    } catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
}
    public function incrementSearchCountById($cityId){
        try{
            $stmt = $this->conn->prepare("UPDATE searchTable SET times_searched = times_searched + 1 WHERE id = :cityId");
            $stmt->execute(['cityId' => $cityId]);

            echo "Search count incremented for city with ID: " . $cityId;
        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }
    public function getAllData(){
        try{
            $stmt = $this->conn->prepare("SELECT * FROM searchTable");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getTop10Cities(){
        try{
            $stmt = $this->conn->prepare("SELECT * FROM searchTable ORDER BY times_searched DESC LIMIT 10");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}