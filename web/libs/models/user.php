<?php

class User {

    private $id;
    private $username;
    private $password;

    function __construct($id, $username, $password) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public static function getUsers() {
        $sql = "SELECT id,username, password from dbuser";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $user = new User($result->id, $result->username, $result->password);
            $results[] = $user;
        }
        return $results;
    }

    public function getUsername() {
        return $this->username;
    }

    public static function getUser($username, $password) {
        $sql = "SELECT id,username, password from dbuser where username = ? AND password = ? LIMIT 1";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($username, $password));
        $result = $query->fetchObject();
        if ($result == null) {
            return null;
        } else {
            $username = new User();
            $username->id = $result->id;
            $username->username = $result->username;
            $username->password = $result->password;

            return $username;
        }
    }
    public function getId() {
        return $this->id;
    }


}
