<?php 
class Database{
    private $host = 'localhost';
    private $db = 'sistem_parkir';
    private $user = 'root';
    private $pass = '';
    private $pdo;

    public function __construct(){
        try{
            $dsn = "mysql:host={$this->host};dbname={$this->db}";
            $this->pdo = new PDO($dsn,$this->user,$this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("koneksi gagal :" . $e->getMessage());
        }
    }

    public function getConnection(){
        return $this->pdo;
    }
}