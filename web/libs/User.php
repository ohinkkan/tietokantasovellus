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


}
