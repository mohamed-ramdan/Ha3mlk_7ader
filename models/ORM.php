<?php

require 'appconf.php';

/*
    ORM Class
    Merrit Jesus
 */

/**
 * Description of ORM
 *
 */
class ORM {

    //put your code here

    static $ObjectInstace;
    private $dbconn;
    protected $table;

    //make instance from the class with prevent to dublictaion
    static function getInstance() {
        if (self::$ObjectInstace == null) {
            self::$ObjectInstace = new ORM();
        }
        return self::$ObjectInstace;
    }

    //open connection with data base 
    protected function __construct() {

        extract($GLOBALS['conf']);
        @ $this->dbconn = new mysqli($host, $username, $password, $database);

        if (mysqli_connect_errno()) {
            echo 'Error: Could not connect to database. Please try again later';
            exit;
        }
    }

    // getter to the connection
    function getConnection() {
        return $this->dbconn;
    }

    // setter to the table name
    function setTable($table) {
        $this->table = $table;
    }

    // insert in data base
    function insert($data) {
        //prepare quary
        $query = "insert into $this->table set ";
        foreach ($data as $col => $value) {
            $query .= $col . "= '" . $value . "' , ";
        }
        //remove last ','
        $query[strlen($query) - 2] = " ";
        //output of the query
        $state = $this->dbconn->query($query);
        
        if (!$state) {
            return $this->dbconn->error;
        }

        return $this->dbconn->affected_rows;
    }
     // select function
    function select($data, $extra = "") {
        //"select * from table name"
        $query = "select * from $this->table ";
        //if no cond dont concate with where
        if (!empty($data)) {
            $query .= "where ";
        }
        // concate cond array
        foreach ($data as $col => $value) {
            $query .= $col . "= '" . $value . "'and ";
        }
        //remove last and
        if (!empty($data)) {
            $query = substr($query, 0, strlen($query) - 4);
        }
        //if there is extra cond
        if (!empty($extra)) {
            $query .= $extra;
        }
        
        //execute the query
        $result = $this->dbconn->query($query);
        
        if (!$result) {
            return $this->dbconn->error;
        } else {
            $tmp = array();
            while ($row = $result->fetch_assoc()) {
                //load all returned rows into an array
                $tmp[] = $row;
            }
            return $tmp;
        }
    }
     //select from more than one table
    function selectjoin($tables, $data, $extra = "") {
        
        $query = "select * from  ";
        //table array concate with the quary
        foreach ($tables as $table) {
            $query .= $table . " , ";
        }
        // remove last ","
        $query = substr($query, 0, strlen($query) - 2);
        //if there is conditions

        if (!empty($data)) {
            $query .= " where  ";


            foreach ($data as $col => $value) {
                $query .= $col . "= " . $value . " and ";
            }

            $query = substr($query, 0, strlen($query) - 4);
        }
        
         // if there is extra cond
        if (!empty($extra)) {
            $query .= $extra;
        }

        $result = $this->dbconn->query($query);

        if (!$result) {
            return $this->dbconn->error;
        } else {
            return $result->fetch_assoc();
        }
    }
        
    function update($data, $cond, $extra = "") {
        // "update user set "
        $query = "update  $this->table set  ";
        //"concate with all cond if founded"
        foreach ($data as $col => $value) {
            $query .= $col . "= '" . $value . "'and ";
        }
        //remove last and 
        $query = substr($query, 0, strlen($query) - 4);
        // if there a cond
        if (!empty($cond)) {
            $query .= " where  ";


            foreach ($cond as $col => $value) {
                $query .= $col . "= " . $value . " and ";
            }

            $query = substr($query, 0, strlen($query) - 4);
        }
        // if there are extra cond
        if (!empty($extra)) {
            $query .= $extra;
        }

        

        $result = $this->dbconn->query($query);

        if (!$result) {
            return $this->dbconn->error;
        } else {
            return $this->dbconn->affected_rows;
        }
    }

    function delete($data, $extra = "") {
        $query = "delete from $this->table ";
        if (!empty($data)) {
            $query .= "where ";
        }
        foreach ($data as $col => $value) {
            $query .= $col . "= '" . $value . "'and ";
        }
        if (!empty($data)) {
            $query = substr($query, 0, strlen($query) - 4);
        }

        if (!empty($extra)) {
            $query .= $extra;
        }

        $result = $this->dbconn->query($query);

        if (!$result) {
            return $this->dbconn->error;
        } else {
            return $this->dbconn->affected_rows;
        }
    }

}
