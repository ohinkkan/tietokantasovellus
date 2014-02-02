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


}
