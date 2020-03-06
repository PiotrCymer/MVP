<?php

namespace appEngine\Core\Database;

use appEngine\App\Config as Config;

class Database
{
    private static $instance;

    private $login;

    private $pass;

    private $url;

    private $dbName;

    public $connection;

    public $result = '';


    private function __construct()
    {
        $this->config = Config\Config::getInstance();
        $connConfigArray = $this->config->get("database");

        
        $this->connection = new \mysqli($connConfigArray['host'], $connConfigArray['login'], $connConfigArray['pass'], $connConfigArray['dbName']);
        $this->connection->set_charset("utf8");

        if (!$this->connection) {
            echo 'nie działa';
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function query($sql)
    {

        $result = $this->connection->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        }

        return false;
    }

    public function getTable($sql)
    {
        $re =  $this->query($sql);

        $arrayA = array();

        foreach ($re as $k => $v) {
            $arrayA[$k] = $v;
        }
        return $arrayA;
    }

    public function getSingleRow($sql)
    {
        $response = $this->query($sql);

        return $response->fetch_assoc();
    }

    public function getSingleValue($name, $table, $where)
    {
        $query = $this->queryBuilder($table, $name, $where);
        return $this->query($query)->fetch_assoc();
    }

    private function queryBuilder($from, $what, $where = null)
    {
        $query = "SELECT ";
        $query .= $what . " FROM $from";

        if ($where == null) {
            return $query;
        } else {
            $query .= " WHERE " . $where;
        }
        return $query;
    }

    public function updateRecord($table, $data, $where)
    {
        $query = "UPDATE {$table} SET ";
        $set = "";
        $cnt = count($data);
        $i = 0;
        foreach ($data as $k => $v) {
            if (gettype($v) == 'string') {
                $value = "'" . $v . "'";
            } else {
                $value = $v;
            }
            if ($i == $cnt - 1) {
                $set .= $k . "=" . $value;
            } else {
                $set .= $k . "=" . $value . ", ";
            }
            $i++;
        }
        $query .= $set;
        $query .= " WHERE " . $where;
        // echo $query;
        // die;
        $this->query($query);
    }

    public function insertRecord($table, $data)
    {
        $query = "INSERT INTO {$table} ";
        $columns = "(";
        $values = "(";
        $cnt = count($data);
        $i = 0;
        foreach($data as $k => $v) {
            if (gettype($v) == 'string') {
                $value = "'" . $v . "'";
            } else {
                $value = $v;
            }
            if ($i == $cnt - 1) {
                $columns .= $k.")";
                $values .= $value.")";
            } else {
                $columns .= $k.", ";
                $values .= $value.", ";
            }
            $i++;
        }
        $query .= $columns;
        $query .= " VALUES ".$values;
        
        
        $this->query($query);
        
    }
}
