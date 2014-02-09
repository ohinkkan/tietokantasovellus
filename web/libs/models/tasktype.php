<?php

class tasktype {

    private $id;
    private $name;
    private $upper_id;
    private $dbuser_id;

    function __construct($id, $name, $upper_id, $dbuser_id) {
        $this->id = $id;
        $this->name = $name;
        $this->upper_id = $upper_id;
        $this->dbuser_id = $dbuser_id;
    }

    public static function getTasktypes($task_id) {
        $sql = "SELECT name FROM tasktype,typetasklink WHERE tasktype.id = tasktype_id AND task_id = ?";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($task_id));

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $results[] = $result->name;
        }
        return $results;
    }

    public static function getTypesForTask($task_id) {
        $sql = "SELECT tasktype.id,name,upper_id,dbuser_id FROM tasktype,typetasklink WHERE tasktype.id = tasktype_id AND task_id = ?";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($task_id));

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $tasktype = new tasktype($result->id, $result->name, $result->upper_id, $result->dbuser_id);
            $results[] = $tasktype;
        }
        return $results;
    }

    public static function getTasktypesSorted($userId) {
        $sql = "SELECT id,name,upper_id,dbuser_id FROM tasktype WHERE dbuser_id = ? ORDER BY name";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($userId));

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $tasktype = new tasktype($result->id, $result->name, $result->upper_id, $result->dbuser_id);
            $results[] = $tasktype;
        }
        return $results;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public static function getTasktypeName($id) {
        $sql = "SELECT name from tasktype where id = ? LIMIT 1";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($id));
        $result = $query->fetchObject();
        if ($result == null) {
            return null;
        } else {
            return $result->name;
        }
    }

}
