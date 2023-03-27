<?php
class Token extends DataBase {
    public function insert($token, $user_id) {
        $sql = "INSERT INTO token (`token`,`user-id`)
                VALUES(:token , :user_id)";
        $result = $this->connect()->prepare($sql);
        $result->bindParam('token', $token);
        $result->bindParam('user_id', $user_id);
        $result->execute();
    }
}