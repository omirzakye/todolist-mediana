<?php

class DB {
    private $host = 'localhost';
    private $user = 'yerzak';
    private $pass = 'OOeCxy3GryKpLVb9';
    private $dbname = 'todolist';

    public function connect() {
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        $conn = new PDO($conn_str, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

        return $conn;
    }
}
?>