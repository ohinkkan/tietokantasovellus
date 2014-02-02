<?php

class task {

    private $id;
    private $name;
    private $descr;
    private $priority_id;
    private $dbuser_id;

    function __construct($id, $name, $descr, $priority_id, $dbuser_id) {
        $this->id = $id;
        $this->name = $name;
        $this->descr = $descr;
        $this->priority_id = $priority_id;
        $this->dbuser_id = $dbuser_id;
    }

}
