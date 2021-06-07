<?php
class DatabaseController
{
    function __construct()
    {
    }

    public function getData($data, $app)
    {
        $nama = $data['nama'];
        $sql = "SELECT * FROM foods WHERE email = :email";
        $stm = $app->db->prepare($sql);
        $stm->bindParam(':name', $nama, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetchAll();
        return $result;
    }

    public function login($data, $app)
    {
        $email = $data['email'];
        $sql = "SELECT * FROM users WHERE email = :email";
        $stm = $app->db->prepare($sql);
        $stm->bindParam(':email', $email, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetchAll();
        if($result){
            if (password_verify($data['password'], $result[0]['password'])) {
                $message = 'Password is valid!';
                $status = 'success';
                return (["message" => $message, "data" => $result, "status" => $status]);
            } else {
                $message = 'Invalid password.';
                $status = 'error';
                return (["message" => $message, "status" => $status]);
            }
        }else{
            return (["message" => "Wrong Credentials"]);
        }
    }

    public function register($data, $app)
    {
        $options = [
            'cost' => 10
        ];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_BCRYPT, $options);
        $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $stm = $app->db->prepare($sql);
        $stm->bindParam(':email', $email, PDO::PARAM_STR);
        $stm->bindParam(':password', $password, PDO::PARAM_STR);
        $result = $stm->execute();
        return $result;
    }
}
