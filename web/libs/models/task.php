<?php

require_once 'libs/models/priority.php';
require_once 'libs/models/tasktype.php';

class task {

    private $id;
    private $name;
    private $descr;
    private $priority_id;
    private $dbuser_id;
    private $importance;
    private $done;

    function __construct($id, $name, $descr, $priority_id, $dbuser_id, $importance, $done) {
        $this->id = $id;
        $this->name = $name;
        $this->descr = $descr;
        $this->priority_id = $priority_id;
        $this->dbuser_id = $dbuser_id;
        $this->importance = $importance;
        $this->done = $done;
    }

    public function filter($filter) {
        if (empty($filter)) {
            return true;
        } elseif (strpos($this->name, $filter) !== false) {
            return true;
        } elseif (strpos($this->descr, $filter) !== false) {
            return true;
        }
        $priority = priority::getPriorityName($this->priority_id);
        if (strpos($priority, $filter) !== false) {
            return true;
        }
        $tasktypes = tasktype::getTasktypes($this->id);
        foreach ($tasktypes as $type) {
            if (strpos($type, $filter) !== false) {
                return true;
            }
        }
        return false;
    }

    public static function getTask($id) {
        $sql = "SELECT task.id,task.name,descr,priority_id,task.dbuser_id,importance,done FROM task,priority WHERE task.priority_id = priority.id AND task.id = ? LIMIT 1";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($id));
        $result = $query->fetchObject();
        if ($result == null) {
            return new Task(0, "", "", 0, $id, 0, 0);
        } else {
            $task = new Task($result->id, $result->name, $result->descr, $result->priority_id, $result->dbuser_id, $result->importance, $result->done);
            return $task;
        }
    }

    public static function getTasks() {
        $sql = "SELECT id,name,descr,priority_id,dbuser_id,done from task";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $task = new Task($result->id, $result->name, $result->descr, $result->priority_id, $result->dbuser_id, $result->importance, $result->done);
            $results[] = $task;
        }
        return $results;
    }

    public static function getTasksSorted($userId) {
        $sql = "SELECT task.id,task.name,descr,priority_id,task.dbuser_id,importance,done FROM task,priority WHERE task.priority_id = priority.id AND task.dbuser_id = ? ORDER BY importance DESC, done, name";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($userId));

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $task = new Task($result->id, $result->name, $result->descr, $result->priority_id, $result->dbuser_id, $result->importance, $result->done);
            $results[] = $task;
        }
        return $results;
    }

    public function getName() {
        return $this->name;
    }

    public function getDone() {
        return $this->done;
    }

    public function getDbuser_id() {
        return $this->dbuser_id;
    }

    public function getPriority_id() {
        return $this->priority_id;
    }

    public function getId() {
        return $this->id;
    }

    public function getDescr() {
        return $this->descr;
    }

    public function getImportance() {
        return $this->importance;
    }

    public static function addTask($name, $descr, $priority) {
        $sql = "INSERT INTO task(name, descr, priority_id, dbuser_id, done) VALUES(?,?,?,?,?) RETURNING id";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($name, $descr, $priority, $_SESSION['userid'], 0));

        $newId = $query->fetchColumn();

        foreach ($_SESSION['newtasktypes'] as $type) {
            $sql = "INSERT INTO typetasklink(task_id, tasktype_id) VALUES(?,?)";
            $query = getDatabaseconnection()->prepare($sql);
            $query->execute(array($newId, $type));
        }
    }

    public function toggleDone() {
        if ($this->done === 0) {
            $new = 1;
        } else {
            $new = 0;
        }
        $sql = "UPDATE task SET done = ? WHERE id = ?";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($new, $this->id));
    }

    public static function allDone() {
        $sql = "UPDATE task SET done = 1 WHERE dbuser_id = ?";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($_SESSION['userid']));
    }

    public static function workWork() {
        $sql = "UPDATE task SET done = 0 WHERE dbuser_id = ?";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($_SESSION['userid']));
    }

    public static function delete($id) {
        $sql = "DELETE FROM task WHERE id = ?";
        $query = getDatabaseconnection()->prepare($sql);
        $query->execute(array($id));
    }

}
