<?php
class Database
{
    private $host = '127.0.0.1'; 
    private $user = 'root';      
    private $pass = '';          
    private $dbname = 'samsung'; 
    private $port = '4306';      

    private $dbh;  
    private $stmt; 
    private $error;

    public function connect()
    {
        try {
            $pdo = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8", $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("Kết nối thất bại: " . $e->getMessage());
        }
    }

    public function __construct()
    {
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname}";
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            throw new Exception('Database Connection Failed: ' . $this->error);
        }
    }

    public function query($sql)
    {
        if (!$this->dbh) {
            throw new Exception("Không có kết nối đến cơ sở dữ liệu.");
        }
        $this->stmt = $this->dbh->prepare($sql);
    }

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
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}