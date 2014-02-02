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

}
