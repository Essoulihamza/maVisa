<?php 
class Reservation extends DataBase 
{
    private PDO $connection;
    public function __construct() 
    {
        $this->connection = $this->connect();
    }

    public function index(){
        
    }
    public function show(){

    }
    public function store(){

    }
    public function destroy(){

    }
}