<?php

class priority {

    private $id;
    private $name;
    private $importance;
    private $dbuser_id;

    function __construct($id, $name, $importance, $dbuser_id) {
        $this->id = $id;
        $this->name = $name;
        $this->importance = $importance;
        $this->dbuser_id = $dbuser_id;
    }

    public static function getPriorities() {
        $sql = "SELECT id,name,importance,dbuser_id from priority";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $priority = new Priority($result->id, $result->name, $result->importance, $result->dbuser_id);
            $results[] = $priority;
        }
        return $results;
    }

    public static function getPriority($id, $userid) {
        $sql = "SELECT id,name,importance,dbuser_id from priority where id = ? AND dbuser_id = ? LIMIT 1";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($id, $userid));
        $result = $query->fetchObject();
        if ($result == null) {
            return null;
        } else {
            $priority = new Priority($result->id, $result->name, $result->importance, $result->dbuser_id);
            return $priority;
        }
    }

    public static function getPriorityName($id) {
        $sql = "SELECT name from priority where id = ? LIMIT 1";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($id));
        $result = $query->fetchObject();
        if ($result == null) {
            return 'Ei asetettu!';
        } else {
            return $result->name;
        }
    }

    public static function getPrioritiesSorted($userId) {
        $sql = "SELECT id,name,importance,dbuser_id FROM priority WHERE dbuser_id = ? ORDER BY importance DESC";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($userId));

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $priority = new Priority($result->id, $result->name, $result->importance, $result->dbuser_id);
            $results[] = $priority;
        }
        return $results;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getImportance() {
        return $this->importance;
    }

    public function filter($filter) {
        $filter = strtolower($filter);
        if (empty($filter)) {
            return true;
        } elseif (strpos(strtolower($this->name), $filter) !== false) {
            return true;
        }
        if (strpos($this->importance, $filter) !== false) {
            return true;
        }
        return false;
    }

    public static function addPriority($name, $importance) {
        $sql = "INSERT INTO priority(name, importance, dbuser_id) VALUES(?,?,?)";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($name, $importance, $_SESSION['userid']));
    }

    public static function updatePriority($name, $importance, $id) {
        $sql = "UPDATE priority SET name = ?, importance = ? WHERE id = ?";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($name, $importance, $id));
    }

    public static function delete($id) {
        $sql = "DELETE FROM priority WHERE id = ? AND dbuser_id = ?";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($id, $_SESSION['userid']));
    }

}
