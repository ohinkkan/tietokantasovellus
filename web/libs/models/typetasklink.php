<?php

class typetasklink {

    private $task_id;
    private $tasktype_id;

    function __construct($task_id, $tasktype_id) {
        $this->task_id = $task_id;
        $this->tasktype_id = $tasktype_id;
    }

    public static function getTasktypesForTask($dbuser_id) {
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

}
