<?php

class Model {

    protected $db;

    public function __construct(){
        $this->db = new DB();
        $this->db->connect('mysql', 'localhost', 'root', 'santa123', 'mvcapp');
    }
}
?>