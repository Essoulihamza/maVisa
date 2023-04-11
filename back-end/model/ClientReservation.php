<?php
class ClientReservation
{
    private $conn;

    public $id;
    public $id_client;
    public $token;
    public $nom_complet;
    public $naissance;
    public $nationalite;
    public $situation;
    public $address;
    public $type_visa;
    public $date_depart;
    public $date_arriver;
    public $type_document;
    public $numero_document;
    public $reservation_date;
    public $reservation_time;
    public $string_pattern = "/^[a-zA-Z\s]+$/";
    public $email_pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    public $date_pattern = "/^\d{4}-\d{2}-\d{2}$/";
    public $numeric_pattern = "/^[0-9]+$/";
    public $time_pattern = "/^([0-9]{2}:[0-9]{2})-([0-9]{2}:[0-9]{2})$/";


    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function read()
    {
        $query = 'SELECT * FROM client';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        $query = 'SELECT * FROM client WHERE token = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->token = $row['token'];
        $this->nom_complet = $row['nom_complet'];
        $this->naissance = $row['naissance'];
        $this->nationalite = $row['nationalite'];
        $this->situation = $row['situation'];
        $this->address = $row['address'];
        $this->type_visa = $row['type_visa'];
        $this->date_depart = $row['date_depart'];
        $this->date_arriver = $row['date_arriver'];
        $this->type_document = $row['type_document'];
        $this->numero_document = $row['numero_document'];
    }

    public function create()
    {
        $query = 'INSERT INTO client SET 
        `token` = :token, 
        `nom_complet` = :nom_complet,
        `naissance` = :naissance,
        `nationalite` = :nationalite, 
        `situation` = :situation, 
        `address` = :address, 
        `type_visa` = :type_visa, 
        `date_depart` = :date_depart, 
        `date_arriver` = :date_arriver, 
        `type_document` = :type_document, 
        `numero_document` = :numero_document';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':token', $this->token);
        $stmt->bindParam(':nom_complet', $this->nom_complet);
        $stmt->bindParam(':naissance', $this->naissance);
        $stmt->bindParam(':nationalite', $this->nationalite);
        $stmt->bindParam(':situation', $this->situation);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':type_visa', $this->type_visa);
        $stmt->bindParam(':date_depart', $this->date_depart);
        $stmt->bindParam(':date_arriver', $this->date_arriver);
        $stmt->bindParam(':type_document', $this->type_document);
        $stmt->bindParam(':numero_document', $this->numero_document);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        $query = 'UPDATE client JOIN reservation
        ON client.id = reservation.id_client
        SET 
        client.`nom_complet` = :nom_complet,
        client.`naissance` = :naissance,
        client.`nationalite` = :nationalite, 
        client.`situation` = :situation, 
        client.`address` = :address, 
        client.`type_visa` = :type_visa, 
        client.`date_depart` = :date_depart, 
        client.`date_arriver` = :date_arriver, 
        client.`type_document` = :type_document, 
        client.`numero_document` = :numero_document,
        reservation.`date` = :reservation_date,
        reservation.`time` = :reservation_time
        WHERE client.`token` = :token';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nom_complet', $this->nom_complet);
        $stmt->bindParam(':naissance', $this->naissance);
        $stmt->bindParam(':nationalite', $this->nationalite);
        $stmt->bindParam(':situation', $this->situation);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':type_visa', $this->type_visa);
        $stmt->bindParam(':date_depart', $this->date_depart);
        $stmt->bindParam(':date_arriver', $this->date_arriver);
        $stmt->bindParam(':type_document', $this->type_document);
        $stmt->bindParam(':numero_document', $this->numero_document);
        $stmt->bindParam(':reservation_date', $this->reservation_date);
        $stmt->bindParam(':reservation_time', $this->reservation_time);
        $stmt->bindParam(':token', $this->token);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        $query = 'DELETE FROM client WHERE `token` = :token';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':token', $this->token);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function checkReservation() {
        $query = "SELECT `time` FROM `reservation` WHERE date = :date";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':date', $this->reservation_date);

        $stmt->execute();

        return $stmt;
    }

    public function reservation()
    {
        $query = 'INSERT INTO reservation SET 
        `id_client` = :id_client,
        `date` = :reservation_date,
        `time` = :reservation_time';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_client', $this->id_client);
        $stmt->bindParam(':reservation_date', $this->reservation_date);
        $stmt->bindParam(':reservation_time', $this->reservation_time);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllEvents() {
        $query = 'SELECT date FROM `reservation`';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function updateData() {
        $query = 'SELECT client.*, reservation.date, reservation.time
            from client
            LEFT JOIN reservation
            on reservation.id_client = client.id
            WHERE client.token = :token';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $this->token);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->id = $row['id'];
        $this->token = $row['token'];
        $this->nom_complet = $row['nom_complet'];
        $this->naissance = $row['naissance'];
        $this->nationalite = $row['nationalite'];
        $this->situation = $row['situation'];
        $this->address = $row['address'];
        $this->type_visa = $row['type_visa'];
        $this->date_depart = $row['date_depart'];
        $this->date_arriver = $row['date_arriver'];
        $this->type_document = $row['type_document'];
        $this->numero_document = $row['numero_document'];
        $this->reservation_date = $row['date'];
        $this->reservation_time = $row['time'];

    }
}
