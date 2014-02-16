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

    public static function getTasktype($taskid) {
        $sql = "SELECT id,name,upper_id,dbuser_id FROM tasktype WHERE id = ? LIMIT 1";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($taskid));

        $result = $query->fetchObject();
        $tasktype = new tasktype($result->id, $result->name, $result->upper_id, $result->dbuser_id);

        return $tasktype;
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

    public function getUpper_id() {
        if ($this->upper_id < 1) {
            return 0;
        }
        return $this->upper_id;
    }

    public function filter($filter) {
        if (empty($filter)) {
            return true;
        } elseif (strpos($this->name, $filter) !== false) {
            return true;
        }
        $upper = tasktype::getTasktype($this->upper_id);
        if (strpos($upper->getName(), $filter) !== false) {
            return true;
        }
        return false;
    }

    public static function addTasktype($name, $upper) {
        if ($upper == 0) {
            $upper = null;
        }
        $sql = "INSERT INTO tasktype(name, dbuser_id, upper_id) VALUES(?,?,?)";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($name, $_SESSION['userid'], $upper));
    }

    public static function updateTasktype($name, $upper, $id) {
        if ($upper == 0) {
            $upper = null;
        }
        $sql = "UPDATE tasktype SET name = ?, upper_id = ? WHERE id = ?";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($name, $upper, $id));
    }

    public static function delete($id) {
        $sql = "DELETE FROM tasktype WHERE id = ? AND dbuser_id = ?";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($id, $_SESSION['userid']));
    }

}
