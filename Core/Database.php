<?php

namespace Core;

class Database 
{
    public $connect;

    public function __construct()
    {
        $this->connect = new \PDO('mysql:host=us-cdbr-east-05.cleardb.net;dbname=heroku_5ddf4ca775ad0e6;', 'b3e1e678b64a6f', '175dcb0d');
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