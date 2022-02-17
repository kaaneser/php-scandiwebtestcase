<?php

namespace Core;

class Database 
{
    public $connect;

    public function __construct()
    {
        $this->connect = new \PDO('mysql:host=127.0.0.1;dbname=scandiweb;', 'root');
        $this->connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function query($sql, $multi = false)
    {
        if ($multi == false) {
            return $this->connect->query($sql, \PDO::FETCH_ASSOC)->fetch() ?? [];
        } else {
            return $this->connect->query($sql, \PDO::FETCH_ASSOC)->fetchAll() ?? [];
        }
    }

    public function transaction()
    {
        return $this->connect->beginTransaction();
    }

}