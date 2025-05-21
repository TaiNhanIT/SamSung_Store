<?php
class Database {
    private $host = 'localhost'; // Địa chỉ máy chủ
    private $user = 'root';      // Tên người dùng MySQL
    private $pass = '';          // Mật khẩu MySQL
    private $dbname = 'samsung'; // Tên cơ sở dữ liệu

    private $dbh;  // Xử lý csdl
    private $stmt; // Statement
    private $error;

public function connect() {
    // Ví dụ với PDO
    $host = 'localhost';
    $dbname = 'samsung';
    $username = 'root';
    $password = '';
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Kết nối thất bại: " . $e->getMessage());
    }
}
    public function __construct() {
        // DSN (Data Source Name)
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = [
            PDO::ATTR_PERSISTENT => true, // Kết nối bền vững
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Báo lỗi dưới dạng exception
        ];

        // Tạo kết nối PDO
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            die('Database Connection Failed: ' . $this->error);
        }
    }

    // Chuẩn bị câu lệnh SQL
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Gán giá trị cho tham số
    public function bind($param, $value, $type = null) {
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

    // Thực thi câu lệnh
    public function execute() {
        return $this->stmt->execute();
    }

    // Lấy tất cả kết quả
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy một kết quả duy nhất
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
}