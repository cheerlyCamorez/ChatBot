<?
class DB{
    private $servername='localhost';
    private $username='root';
    private $password='';
    private $dbname='Chat_botDB';
    private $conn;
    private function connect(){
        $this->conn = new mysqli($this->servername,$this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Ошибка подключения к базе данных: " . $this->conn->connect_error);
        }
    }
    private function disconnect(){
        $this->conn->close();
    }
    function do_query(string $sql)
    {
        $this->connect();
        $result = $this->conn->query($sql);
        $inserted_id = $this->conn->insert_id;
        $this->disconnect();
        return $inserted_id != 0 ? $inserted_id : $result;
    }

}
?>