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
                (`firstName`, `lastName`, `birthdate`, `nationality`, `familySituation`, `address`, `departureDate`, `arrivalDate`, `visaType`, `documentType`, `documentNumber`) 
                VALUES (:first_name , :last_name , :birthdate , :nationality, :family_situation , :address, :departure_date, :arrival_date , :visa_type , :document_type , :document_number );";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':last_name', $data['lastName']);
        $statement->bindParam(':first_name', $data['firstName']);
        $statement->bindParam(':birthdate', $data['birthdate']);
        $statement->bindParam(':nationality', $data['nationality']);
        $statement->bindParam(':family_situation', $data['familySituation']);
        $statement->bindParam(':address', $data['address']);
        $statement->bindParam(':visa_type', $data['visaType']);
        $statement->bindParam(':departure_date', $data['departure']);
        $statement->bindParam(':arrival_date', $data['arrival']);
        $statement->bindParam(':document_type', $data['documentType']);
        $statement->bindParam(':document_number', $data['documentNumber']);
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
                SET `lastName` = :last_name,
                    `firstName` = :first_name,
                    `birthdate` = :birth_date,
                    `nationality` = :nationality,
                    `familySituation` = :family_situation,
                    `address` = :address,
                    `visaType` = :visa_type,
                    `arrivalDate` = :start_date,
                    `departureDate` = :end_date,
                    `documentType` = :travel_type,
                    `documentNumber` = :travel_number
                WHERE `user`.`id` = :id ;";
        $statement = $this->connection->prepare($sql);
        $statement->bindvalue('last_name', $new['lastName'] ?? $current['lastName'], PDO::PARAM_STR);
        $statement->bindvalue('first_name', $new['firstName'] ?? $current['firstName']);
        $statement->bindvalue('birth_date', $new['birthdate'] ?? $current['birthdate']);
        $statement->bindvalue('nationality', $new['nationality'] ?? $current['nationality']);
        $statement->bindvalue('family_situation', $new['familySituation'] ?? $current['familySituation']);
        $statement->bindvalue('address', $new['address'] ?? $current['address']);
        $statement->bindvalue('visa_type', $new['visaType'] ?? $current['visaType']);
        $statement->bindvalue('start_date', $new['departure'] ?? $current['departure']);
        $statement->bindvalue('end_date', $new['arrival'] ?? $current['arrival']);
        $statement->bindvalue('travel_type', $new['documentType'] ?? $current['documentType']);
        $statement->bindvalue('travel_number', $new['documentNumber'] ?? $current['documentNumber']);
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