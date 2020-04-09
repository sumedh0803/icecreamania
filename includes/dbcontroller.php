<?php
    class DBController{
        private $hostName = "remotemysql.com:3306";
        private $userName = "tK0HEv3ZWF";
        private $password = "t4qEtDKTnP";
        private $database = "tK0HEv3ZWF";
        public $conn;

        public function connectDb(){
            $this->conn = mysqli_connect($this->hostName,$this->userName,$this->password,$this->database);
            mysqli_select_db($this->conn,$this->database) or DIE('Cannot find database. Please validate the database');
            if(!$this->conn){
                echo "Connection cannot be established. Please try again!";
                DIE("Connection failed");
            }
        }

        public function runQuery($query){
            $result = mysqli_query($this->conn,$query);
            if(!$result){
                printf("Cannot execute query due to following reason : %s \n",mysqli_error($this->conn));
                exit();
            }
            return $result;
        }
    }
?>
