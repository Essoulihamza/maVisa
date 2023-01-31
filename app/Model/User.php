<?php
class User extends DataBase 
{
    private PDO $connection;
    public function __construct() 
    {
        $this->connection = $this->connect();
    }
    public function getAll() : array 
    {
        $sql = "SELECT * 
                FROM user";
        $statement = $this->connection->query($sql);
        return $statement->fetchAll();
    }
    public function create(array $data) : string
    {
        $sql = "INSERT INTO `user` 
        (`last name`, `first name`, `birth date`, `nationality`, `family situation`, `address`, `visa type`, `start date`, `end date`, `travel type`, `travel number`)
        VALUES (`:last name`, `:first name`, `:birth date`, `:nationality`, `:family situation`, `:address`, `:visa type`, `:start date`, `:end date`, `:travel type`, `:travel number`);";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam('last name', $data['last name']);
        $statement->bindParam('first name', $data['first name']);
        $statement->bindParam('birth date', $data['birth date']);
        $statement->bindParam('nationality', $data['nationality']);
        $statement->bindParam('family situation', $data['family situation']);
        $statement->bindParam('address', $data['address']);
        $statement->bindParam('visa type', $data['visa type']);
        $statement->bindParam('start date', $data['start date']);
        $statement->bindParam('end date', $data['end date']);
        $statement->bindParam('travel type', $data['travel type']);
        $statement->bindParam('travel number', $data['travel number']);
        $statement->execute();
        return $this->connection->lastInsertId();
    }

    public function get(string $id) : array | false
    {
        $sql = "SELECT * 
                FROM user
                WHERE id = :id ;";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam('id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    }
    public function update(array $current, array $new ) : int
    {
        $sql = "UPDATE `user` 
                SET `last name` = :last_name,
                    `first name` = :first_name,
                    `birth date` = :birth_date,
                    `nationality` = :nationality,
                    `family situation` = :family_situation,
                    `address` = :address,
                    `visa type` = :visa_type,
                    `start date` = :start_date,
                    `end date` = :end_date,
                    `travel type` = :travel_type,
                    `travel number` = :travel_number
                WHERE `user`.`id` = :id ;";
        $statement = $this->connection->prepare($sql);
        $statement->bindvalue('last_name', $new['last name'] ?? $current['last name'], PDO::PARAM_STR);
        $statement->bindvalue('first_name', $new['first name'] ?? $current['first name']);
        $statement->bindvalue('birth_date', $new['birth date'] ?? $current['birth date']);
        $statement->bindvalue('nationality', $new['nationality'] ?? $current['nationality']);
        $statement->bindvalue('family_situation', $new['family situation'] ?? $current['family situation']);
        $statement->bindvalue('address', $new['address'] ?? $current['address']);
        $statement->bindvalue('visa_type', $new['visa type'] ?? $current['visa type']);
        $statement->bindvalue('start_date', $new['start date'] ?? $current['start date']);
        $statement->bindvalue('end_date', $new['end date'] ?? $current['end date']);
        $statement->bindvalue('travel_type', $new['travel type'] ?? $current['travel type']);
        $statement->bindvalue('travel_number', $new['travel number'] ?? $current['travel number']);
        $statement->bindValue(':id', $current['id'], PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }

    public function delete(string $id) : int 
    {
        $sql = "DELETE FROM user
                WHERE id = :id ;";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
}