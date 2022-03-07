<?php

    namespace KeyValue;
    
    class KeyValue{
        private $dbConnection;

        function __construct($host, $db, $user, $password) {
            $this->host = $host;
            $this->db = $db;
            $this->user = $user;
            $this->password = $password;

            
            $this->dbConnection = new mysqli($host, $user, $password, $db);
            if ($this->dbConnection->connect_error) {
                die("Connection failed: " . $dbConnection->connect_error);
            } 
            
            $query = "SELECT ID FROM kv_details";

            $result = mysqli_query($this->dbConnection, $query);
            if((empty($result)) || $result == false) {
                $query = "CREATE TABLE kv_details (
                        `ID` int(11) AUTO_INCREMENT,
                        `KEY` varchar(255) NOT NULL UNIQUE,
                        `VALUE` varchar(255),
                         PRIMARY KEY  (ID)
                        )";
                $result = mysqli_query($this->dbConnection, $query);
                if($result == false){
                    die("Something wrong !");
                }
            }


        }
        
        //insert
        public function insert($key, $value=null){
            $query = "INSERT INTO `kv_details` (`KEY`, `VALUE`) VALUES ('".$key."', '".$value."')";
            $result = mysqli_query($this->dbConnection, $query);
            
            if($result == false){
                die("Error: ".mysqli_error($this->dbConnection));
            }else{
                return true;
            }
        }

        //get
        public function get($need){
            $returnArray=[];
            if($need == '*'){
                $query = "SELECT * FROM `kv_details`";
                $result = mysqli_query($this->dbConnection, $query);
                $i=0;
                while($row = $result->fetch_assoc()){
                    $returnArray[$i]['ID']=$row['ID'];
                    $returnArray[$i]['KEY']=$row['KEY'];
                    $returnArray[$i]['VALUE']=$row['VALUE'];
                    $i++;
                }
            }else if(strpos($need, ':')){
                $split = explode(":",$need);
                if(strtoupper($split[0]) == 'KEY'){
                    $key = $split[1];
                    $query = "SELECT * FROM `kv_details` WHERE `KEY` = '".$key."'";
                    $result = mysqli_query($this->dbConnection, $query);
                    $i=0;
                    while($row = $result->fetch_assoc()){
                        $returnArray[$i]['ID']=$row['ID'];
                        $returnArray[$i]['KEY']=$row['KEY'];
                        $returnArray[$i]['VALUE']=$row['VALUE'];
                        $i++;
                    }
                }else if(strtoupper($split[0]) == 'ID'){
                    $ID = (int)$split[1];
                    $query = "SELECT * FROM `kv_details` WHERE `ID` = '".$ID."'";
                    $result = mysqli_query($this->dbConnection, $query);
                    $i=0;
                    while($row = $result->fetch_assoc()){
                        $returnArray[$i]['ID']=$row['ID'];
                        $returnArray[$i]['KEY']=$row['KEY'];
                        $returnArray[$i]['VALUE']=$row['VALUE'];
                        $i++;
                    }

                }
            }else{
                    $key = $need;
                    $query = "SELECT * FROM `kv_details` WHERE `KEY` = '".$key."'";
                    $result = mysqli_query($this->dbConnection, $query);
                    $i=0;
                    while($row = $result->fetch_assoc()){
                        $returnArray[$i]['ID']=$row['ID'];
                        $returnArray[$i]['KEY']=$row['KEY'];
                        $returnArray[$i]['VALUE']=$row['VALUE'];
                        $i++;
                    }
            }
            return $returnArray;
        }

        //update key
        public function updateKey($oldKey=null, $newKey,$ID=null){
            if($ID == null){
                $query = "UPDATE `kv_details` SET `KEY`='".$newKey."' WHERE `KEY`='".$oldKey."'";
                $result = mysqli_query($this->dbConnection, $query);
                
                if($result == false){
                    die("Error: ".mysqli_error($this->dbConnection));
                }else{
                    return true;
                }
            }else if($oldKey == null){
                $query = "UPDATE `kv_details` SET `KEY`='".$newKey."' WHERE `ID`='".(int)$ID."'";
                $result = mysqli_query($this->dbConnection, $query);
                
                if($result == false){
                    die("Error: ".mysqli_error($this->dbConnection));
                }else{
                    return true;
                }
            }
        }

        //update value
        public function updateValue($key=null,$newValue,$ID=null){
            if($ID == null){
                $query = "UPDATE `kv_details` SET `VALUE`='".$newValue."' WHERE `KEY`='".$key."'";
                $result = mysqli_query($this->dbConnection, $query);
                
                if($result == false){
                    die("Error: ".mysqli_error($this->dbConnection));
                }else{
                    return true;
                }
            }else if($key == null){
                $query = "UPDATE `kv_details` SET `VALUE`='".$newValue."' WHERE `ID`='".(int)$ID."'";
                $result = mysqli_query($this->dbConnection, $query);

                if($result == false){
                    die("Error: ".mysqli_error($this->dbConnection));
                }else{
                    return true;
                }
            }

        }

        //delete
        public function delete($key){
            $query = "DELETE FROM `kv_details` WHERE `KEY` = '".$key. "'";
            $result = mysqli_query($this->dbConnection, $query);

            if($result == false){
                die("Error: ".mysqli_error($this->dbConnection));
            }else{
                return true;
            }
        }

        //getid
        public function getID($key){
            $query = "SELECT `ID` FROM `kv_details` WHERE `KEY` = '".$key. "'";
            $result = mysqli_query($this->dbConnection, $query);

            if($result == false){
                die("Error: ".mysqli_error($this->dbConnection));
            }else{
                while($row = $result->fetch_assoc()){
                    return (int)$row['ID'];
                }
            }
        }

    }

?>