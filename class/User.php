<?php

class User
{
    private $conn;
    private $db_table = "users";

    public $user_id;
    public $token;
    public $name;
    public $email;
    public $password;
    public $phone;
    public $created_at;
    public $updated_at;
    public $is_active;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getUsers()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function createUser()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . " SET user_id = :user_id, token = :token, name = :name, email = :email, password = :password, phone = :phone";

        $stmt = $this->conn->prepare($sqlQuery);

        /* sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->age=htmlspecialchars(strip_tags($this->age));
        $this->designation=htmlspecialchars(strip_tags($this->designation));
        $this->created=htmlspecialchars(strip_tags($this->created));
        */

        // bind data
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":phone", $this->phone);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getUserById()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE user_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->user_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->user_id = $dataRow['user_id'];
        $this->token = $dataRow['token'];
        $this->name = $dataRow['name'];
        $this->email = $dataRow['email'];
        $this->phone = $dataRow['phone'];
        $this->created_at = $dataRow['created_at'];
        $this->updated_at = $dataRow['updated_at'];
        $this->is_active = $dataRow['is_active'];
    }

    public function getUserByEmail()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE email = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->user_id = $dataRow['user_id'];
        $this->token = $dataRow['token'];
        $this->name = $dataRow['name'];
        $this->email = $dataRow['email'];
        $this->phone = $dataRow['phone'];
        $this->created_at = $dataRow['created_at'];
        $this->updated_at = $dataRow['updated_at'];
        $this->is_active = $dataRow['is_active'];
    }

    public function getUserByToken()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE token = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->user_id = $dataRow['user_id'];
        $this->token = $dataRow['token'];
        $this->name = $dataRow['name'];
        $this->email = $dataRow['email'];
        $this->phone = $dataRow['phone'];
        $this->created_at = $dataRow['created_at'];
        $this->updated_at = $dataRow['updated_at'];
        $this->is_active = $dataRow['is_active'];
    }

    public function updateUser()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        name = :name,
                        email = :email,
                        password = :password,
                        phone = :phone,
                        created = :created,
                        is_active = :is_active
                    WHERE 
                        id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        /*
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->age=htmlspecialchars(strip_tags($this->age));
        $this->designation=htmlspecialchars(strip_tags($this->designation));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->id=htmlspecialchars(strip_tags($this->id));
        */

        // bind data
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":is_active", $this->is_active);
        $stmt->bindParam(":id", $this->user_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function deleteUser()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(1, $this->user_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
