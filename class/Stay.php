<?php

class Stay
{
    public $stay_id;
    public $city_id;
    public $category_id;
    public $name;

    private $conn;
    private $db_table = "stays";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getStays()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function createStay()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . " SET stay_id = :stay_id, city_id = :city_id, category_id = :category_id, name = :name";

        $stmt = $this->conn->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":stay_id", $this->stay_id);
        $stmt->bindParam(":city_id", $this->city_id);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getStayById()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE stay_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->stay_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->stay_id = $dataRow['stay_id'];
        $this->city_id = $dataRow['city_id'];
        $this->category_id = $dataRow['category_id'];
        $this->name = $dataRow['name'];
    }

    // todo
    public function updateStay()
    {
        $sqlQuery = "UPDATE " . $this->db_table . " SET name = :name WHERE province_id = :province_id";
        $stmt = $this->conn->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // todo
    function deleteStay()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE province_id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->province_id = htmlspecialchars(strip_tags($this->province_id));

        $stmt->bindParam(1, $this->province_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
