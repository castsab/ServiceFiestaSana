<?php

class Connect {

    private $user = 'castsab';
    private $password = 'CaRr2015';
    private $host = 'localhost:1521/ORCL';
    private $link;
    private $stmt;
    static $_instance;
    
    public function __construct() {
        $this->getConnect();
    }

    public function getConnect() {
        $this->link = oci_connect($this->user, $this->password,$this->host);
    }

    public function getRun($sql) {
        $this->stmt = oci_parse($this->link, $sql); 
        oci_execute($this->stmt);
        return $this->stmt;
    }
    
}

?>