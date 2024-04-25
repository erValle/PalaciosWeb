<?php
require_once('User.class.php');

class Administrador extends User 
{
    public function __construct(StdClass $obj) {
        parent::__construct($obj);
        $this->init();
    }

    public function init()
    {
        $this->password = null;
    }

    public function isAdmin() { return true; }
}
