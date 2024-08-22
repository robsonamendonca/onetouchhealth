<?php
class Conexao {
    private $host = 'localhost';
    private $db_name = 'onetouchhealth';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConexao() {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Conexao error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
