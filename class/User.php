<?php

class User
{
    private $conn;
    private $db_table = "users";
    public $user_id;
    public $name;
    public $email;
    public $password;
    public $phone;
    public $is_active;
    public $created;

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
        $sqlQuery = "INSERT INTO " . $this->db_table . " SET user_id = :user_id, name = :name, email = :email, password = :password, phone = :phone";

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
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":phone", $this->phone);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getSingleUser()
    {

        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE user_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->user_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $dataRow['name'];
        $this->email = $dataRow['email'];
        $this->password = $dataRow['password'];
        $this->phone = $dataRow['phone'];
        $this->created = $dataRow['created'];
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
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(1, $this->user_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
