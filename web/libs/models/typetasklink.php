<?php

class typetasklink {

    private $task_id;
    private $tasktype_id;

    function __construct($task_id, $tasktype_id) {
        $this->task_id = $task_id;
        $this->tasktype_id = $tasktype_id;
    }

}
